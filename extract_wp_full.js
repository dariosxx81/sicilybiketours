const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));
const media = JSON.parse(fs.readFileSync('wp_featured_media.json', 'utf8'));

// Category map
const catMap = {
  15: 'Escursioni giornaliere',
  16: 'Escursioni di più giorni',
  5: 'Etna',
  17: 'Nebrodi',
  4: 'Degustazione & Gusto',
  7: 'Borghi Storici',
  20: 'Grotta / Vulcanologia',
  24: 'Castelli',
  55: 'Isole Eolie',
  60: 'Barocco',
  63: 'Val di Noto',
  64: 'Bronte'
};

const fullTours = posts.map(p => {
  const content = p.content.rendered;
  
  // Clean text
  let clean = content.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '')
                     .replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '');
  
  // Extract images
  const imgRegex = /src=["'](https?:\/\/[^"']+\.(?:jpg|jpeg|png|webp))["']/gi;
  let m;
  const gallery = [];
  while ((m = imgRegex.exec(clean)) !== null) {
    if (!gallery.includes(m[1]) && !m[1].includes('logo') && !m[1].includes('icon')) {
      gallery.push(m[1]);
    }
  }

  // Extract itinerary text specifically
  let itinerary = '';
  const itinMatch = clean.match(/ITINERARIO[\s\S]*?(?:Scopri gli altri|PRENOTA ORA|La quota comprende|FAQ|$)/i);
  if (itinMatch) {
    itinerary = itinMatch[0]
      .replace(/<[^>]+>/g, '')
      .replace(/ITINERARIO/i, '')
      .replace(/Scopri gli altri[\s\S]*/i, '')
      .replace(/PRENOTA ORA[\s\S]*/i, '')
      .replace(/&nbsp;/g, ' ')
      .replace(/&#8217;/g, "'")
      .replace(/&#8211;/g, "-")
      .trim();
  }

  // Extract included
  let included = [];
  const incMatch = clean.match(/Incluso:?([\s\S]*?)(?:Non [iI]ncluso|Abbigliamento|ITINERARIO|$)/i);
  if (incMatch) {
    const raw = incMatch[1].replace(/<[^>]+>/g, '\n').replace(/&nbsp;/g, ' ').replace(/&#8217;/g, "'");
    included = raw.split('\n').map(s => s.trim().replace(/^[\*\-•]\s*/, '')).filter(s => s.length > 2);
  }

  // Extract excluded
  let excluded = [];
  const excMatch = clean.match(/Non [iI]ncluso:?([\s\S]*?)(?:Abbigliamento|ITINERARIO|PRENOTA|$)/i);
  if (excMatch) {
    const raw = excMatch[1].replace(/<[^>]+>/g, '\n').replace(/&nbsp;/g, ' ').replace(/&#8217;/g, "'");
    excluded = raw.split('\n').map(s => s.trim().replace(/^[\*\-•]\s*/, '')).filter(s => s.length > 2);
  }

  // Price extraction
  let price = null;
  let priceNote = 'a persona';
  const priceRegex = /(?:DA|PARTIRE DA|Prezzo a partire da)\s*€?\s*([0-9]+)\s*€?/i;
  const pm = clean.match(priceRegex);
  if (pm) {
    price = parseInt(pm[1], 10);
  }

  // Technical specs
  let periodo = (clean.match(/Periodo:\s*([^\n<]+)/i) || [])[1] || '';
  let inizio = (clean.match(/Inizio (?:e [fF]ine )?Tour:?\s*([^\n<]+)/i) || [])[1] || '';
  let durata = (clean.match(/Durata:?\s*([^\n<]+)/i) || [])[1] || '';
  let km = (clean.match(/(?:Lunghezza|Km totali):?\s*([^\n<]+)/i) || [])[1] || '';
  let dislivello = (clean.match(/Dislivello:?\s*([^\n<]+)/i) || [])[1] || '';
  let livello = (clean.match(/Livello:?\s*([^\n<]+)/i) || [])[1] || '';

  const featMedia = media[p.featured_media];

  const cats = (p.categories || []).map(c => catMap[c] || `Cat ${c}`);
  const isMultiDay = p.categories.includes(16);

  return {
    wp_id: p.id,
    slug: p.slug,
    title: p.title.rendered.replace(/&#8217;/g, "'").replace(/&#8211;/g, "-"),
    type: isMultiDay ? 'tour' : 'escursione',
    categories: cats,
    featured_image: featMedia ? featMedia.source_url : (gallery[0] || ''),
    price: price,
    price_note: priceNote,
    periodo: periodo.replace(/&nbsp;/g, ' ').trim(),
    inizio_tour: inizio.replace(/&nbsp;/g, ' ').trim(),
    durata: durata.replace(/&nbsp;/g, ' ').trim(),
    distanza: km.replace(/&nbsp;/g, ' ').trim(),
    dislivello: dislivello.replace(/&nbsp;/g, ' ').trim(),
    difficolta: livello.replace(/&nbsp;/g, ' ').trim(),
    itinerario_completo: itinerary,
    incluso: included,
    non_incluso: excluded,
    gallery: gallery
  };
});

fs.writeFileSync('wp_extracted_tours_complete.json', JSON.stringify(fullTours, null, 2));
console.log('Successfully structured 12 tours into wp_extracted_tours_complete.json');
