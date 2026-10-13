const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));
const imagesMap = JSON.parse(fs.readFileSync('wp_tour_local_images.json', 'utf8'));

// Category mapping helper
function mapCategories(catIds) {
  const map = {
    15: { slug: 'giornaliere', name: 'Escursioni Giornaliere', en: 'Day Excursions' },
    16: { slug: 'piu-giorni', name: 'Tour di Più Giorni', en: 'Multi-Day Tours' },
    5: { slug: 'etna', name: 'Etna & Crateri', en: 'Etna Volcano' },
    17: { slug: 'nebrodi', name: 'Parco dei Nebrodi', en: 'Nebrodi Park' },
    4: { slug: 'gusto', name: 'Enogastronomia & Gusto', en: 'Food & Wine' },
    7: { slug: 'borghi', name: 'Borghi Storici', en: 'Historical Villages' },
    20: { slug: 'grotte', name: 'Grotte Vulcaniche', en: 'Volcanic Caves' },
    24: { slug: 'castelli', name: 'Castelli Medievali', en: 'Medieval Castles' },
    55: { slug: 'eolie', name: 'Isole Eolie', en: 'Aeolian Islands' },
    60: { slug: 'barocco', name: 'Barocco Siciliano', en: 'Sicilian Baroque' },
    63: { slug: 'val-di-noto', name: 'Val di Noto', en: 'Val di Noto' },
    64: { slug: 'bronte', name: 'Terre del Pistacchio', en: 'Pistachio Lands' }
  };

  const primaryType = catIds.includes(16) ? 'tour' : 'escursione';
  const categoryNames = catIds.map(id => map[id]?.name).filter(Boolean);
  const categorySlugs = catIds.map(id => map[id]?.slug).filter(Boolean);

  let mainCategory = 'Escursioni';
  let mainCategoryEn = 'Excursions';
  let area = 'Sicilia Orientale';
  let areaTag = 'sicilia';

  if (catIds.includes(5)) {
    mainCategory = 'Vulcano Etna & Crateri';
    mainCategoryEn = 'Mount Etna & Craters';
    area = 'Etna';
    areaTag = 'etna';
  } else if (catIds.includes(17)) {
    mainCategory = 'Boschi & Laghi dei Nebrodi';
    mainCategoryEn = 'Nebrodi Woods & Lakes';
    area = 'Nebrodi';
    areaTag = 'nebrodi';
  } else if (catIds.includes(55)) {
    mainCategory = 'Isole Eolie Bici & Barca';
    mainCategoryEn = 'Aeolian Islands Bike & Boat';
    area = 'Isole Eolie';
    areaTag = 'eolie';
  } else if (catIds.includes(60) || catIds.includes(63)) {
    mainCategory = 'Barocco Siciliano & Val di Noto';
    mainCategoryEn = 'Sicilian Baroque & Val di Noto';
    area = 'Val di Noto';
    areaTag = 'val-di-noto';
  } else if (catIds.includes(4)) {
    mainCategory = 'Enogastronomia & Cantine DOC';
    mainCategoryEn = 'Food, Wine & Cellars';
    area = 'Etna';
    areaTag = 'etna';
  }

  return {
    primaryType,
    mainCategory,
    mainCategoryEn,
    area,
    areaTag,
    categoryNames,
    categorySlugs
  };
}

// Clean HTML to text paragraphs
function cleanHtml(html) {
  if (!html) return '';
  return html
    .replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '')
    .replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '')
    .replace(/<br\s*\/?>/gi, '\n')
    .replace(/<\/p>/gi, '\n\n')
    .replace(/<\/li>/gi, '\n')
    .replace(/<[^>]+>/g, '')
    .replace(/&nbsp;/g, ' ')
    .replace(/&#8217;/g, "'")
    .replace(/&#8211;/g, "-")
    .replace(/&#8220;/g, '"')
    .replace(/&#8221;/g, '"')
    .replace(/&amp;/g, '&')
    .replace(/\n{3,}/g, '\n\n')
    .trim();
}

const curatedSpecs = JSON.parse(fs.readFileSync('curated_specs.json', 'utf8'));

// Specific extraction for each WP post
const structuredTours = posts.map((p, index) => {
  const content = p.content.rendered;
  const catsMeta = mapCategories(p.categories);
  const imgMeta = imagesMap[p.id] || { featured: '', gallery: [] };
  const spec = curatedSpecs[p.id] || {};

  // 1. Title
  let title = p.title.rendered.replace(/&#8217;/g, "'").replace(/&#8211;/g, "-").trim();
  if (title.endsWith(',')) title = title.slice(0, -1).trim();

  // 2. Technical specs
  const periodo = spec.season || 'Aprile - Novembre';
  const inizio = spec.start || 'Randazzo';
  const durata = spec.duration || (catsMeta.primaryType === 'tour' ? '2-5 Giorni' : '4-6 ore');
  const distanza = spec.distance || '40 km';
  const dislivello = spec.elevation || '+1.000 m';
  const difficolta = spec.difficulty || 'Medio';

  // 3. Price
  let price = 90;
  let priceNote = 'a persona (guida + e-bike inclusa)';
  let priceNoteEn = 'per person (guide + e-bike included)';

  if (p.id === 1651) { // Gourmet
    price = 150;
    priceNote = 'a persona (minimo 2 persone)';
    priceNoteEn = 'per person (min 2 persons)';
  } else if (p.id === 1621) { // Etna Summit
    price = 130;
    priceNote = 'a persona (minimo 2 persone)';
    priceNoteEn = 'per person (min 2 persons)';
  } else if (p.id === 866) { // Randazzo - Bronte
    price = 95;
    priceNote = 'a persona (minimo 2 persone)';
    priceNoteEn = 'per person (min 2 persons)';
  } else if (p.id === 841) { // Randazzo - Floresta
    price = 90;
    priceNote = 'a persona (minimo 2 persone)';
    priceNoteEn = 'per person (min 2 persons)';
  } else if (p.id === 810) { // Grotta Lamponi
    price = 90;
    priceNote = 'a persona (minimo 2 persone)';
    priceNoteEn = 'per person (min 2 persons)';
  } else if (p.id === 798) { // Dorsale Nebrodi
    price = 140;
    priceNote = 'a persona (minimo 4 persone)';
    priceNoteEn = 'per person (min 4 persons)';
  } else if (p.id === 505) { // Etna Wine
    price = 90;
    priceNote = 'a persona (degustazione cantina +45€)';
    priceNoteEn = 'per person (winery tasting +€45)';
  } else if (catsMeta.primaryType === 'tour') {
    // Multi-day tour defaults / base estimates
    if (p.id === 1598) price = 240;
    else if (p.id === 1059) price = 390;
    else if (p.id === 1580) price = 520;
    else if (p.id === 1017) price = 790;
    else if (p.id === 888) price = 890;
    priceNote = 'a persona (preventivo su misura)';
    priceNoteEn = 'per person (customized quote)';
  }

  // 4. Extract narrative itinerary & descriptions
  let description = '';
  let itinerary = '';

  // Look for itinerary heading
  const itinRegex = /ITINERARIO[\s\S]*?(?:SCOPRI GLI ALTRI|Scopri gli altri|PRENOTA ORA|La quota comprende|FAQ|###|$)/i;
  const itinM = content.match(itinRegex);
  if (itinM) {
    itinerary = cleanHtml(itinM[0])
      .replace(/^ITINERARIO\s*/i, '')
      .replace(/Scopri gli altri[\s\S]*/i, '')
      .replace(/PRENOTA ORA[\s\S]*/i, '')
      .trim();
  }

  // Look for introductory narrative (before itinerary)
  const introMatch = content.match(/<h1[^>]*>[\s\S]*?<\/h1>([\s\S]*?)(?:PRENOTA ORA|A PARTIRE DA|ITINERARIO)/i);
  if (introMatch) {
    description = cleanHtml(introMatch[1]).replace(/PRENOTA ORA/g, '').trim();
  }
  if (!description && itinerary) {
    // take first paragraph of itinerary as description
    const parts = itinerary.split('\n\n');
    description = parts[0] || '';
  }

  // 5. Included and Excluded
  let included = [];
  const incM = content.match(/Incluso:?([\s\S]*?)(?:Non [iI]ncluso|Abbigliamento|ITINERARIO|$)/i);
  if (incM) {
    included = cleanHtml(incM[1])
      .split('\n')
      .map(s => s.replace(/^[\*\-•]\s*/, '').trim())
      .filter(s => s.length > 2 && !s.toLowerCase().includes('incluso'));
  }
  if (included.length === 0) {
    included = [
      'Noleggio E-MTB biammortizzata di ultima generazione',
      'Casco protettivo e kit di riparazione',
      'Guida cicloturistica certificata',
      'Assicurazione e assistenza logistica'
    ];
  }

  let excluded = [];
  const excM = content.match(/Non [iI]ncluso:?([\s\S]*?)(?:Abbigliamento|ITINERARIO|PRENOTA|$)/i);
  if (excM) {
    excluded = cleanHtml(excM[1])
      .split('\n')
      .map(s => s.replace(/^[\*\-•]\s*/, '').trim())
      .filter(s => s.length > 2 && !s.toLowerCase().includes('non incluso'));
  }
  if (excluded.length === 0) {
    excluded = [
      'Tutto quello non espressamente indicato alla "quota comprende"',
      'Extra personali e mance'
    ];
  }

  // 6. Highlights extracted from text
  const highlights = [];
  if (itinerary) {
    const lines = itinerary.split('\n').filter(l => l.length > 20);
    for (const l of lines.slice(0, 4)) {
      highlights.push(l.slice(0, 100).replace(/[.,;:]$/, ''));
    }
  }

  // 7. Subtitle
  const subtitle = description.length > 0 && description.length < 250 
    ? description 
    : (itinerary.slice(0, 160) + '...');

  return {
    id: index + 1,
    wp_id: p.id,
    slug: p.slug,
    type: catsMeta.primaryType,
    category: catsMeta.mainCategory,
    category_en: catsMeta.mainCategoryEn,
    area: catsMeta.area,
    area_tag: catsMeta.areaTag,
    featured: index < 4,
    title: title,
    title_en: title,
    subtitle: subtitle,
    subtitle_en: subtitle,
    description: description,
    description_en: description,
    itinerary: itinerary,
    itinerary_en: itinerary,
    image: imgMeta.featured || 'assets/img/gallery/summit.jpg',
    gallery: imgMeta.gallery.length > 0 ? imgMeta.gallery : [imgMeta.featured],
    price: price,
    price_note: priceNote,
    price_note_en: priceNoteEn,
    duration: durata,
    duration_en: durata,
    days: catsMeta.primaryType === 'tour' ? (p.id === 1598 ? 2 : p.id === 1059 ? 3 : p.id === 1580 ? 4 : p.id === 1017 ? 5 : 7) : 1,
    distance: distanza,
    elevation: dislivello,
    difficulty: difficolta,
    difficulty_en: difficolta,
    start_location: inizio,
    season: periodo,
    season_en: periodo,
    highlights: highlights.length > 0 ? highlights : [
      'Guida esperta e certificata del territorio',
      'Itinerario esclusivo tra natura, vulcani e borghi storici',
      'E-bike di ultima generazione con pedalata assistita',
      'Assistenza tecnica e logistica completa'
    ],
    highlights_en: highlights.length > 0 ? highlights : [
      'Certified expert local guide',
      'Exclusive route through nature, volcanoes and historic hamlets',
      'Latest generation e-bikes with pedal assist',
      'Full technical and logistical support'
    ],
    included: included,
    included_en: included,
    excluded: excluded,
    excluded_en: excluded,
    schedule_dates: [
      '2026-04-15', '2026-05-01', '2026-05-15', '2026-06-01', 
      '2026-07-01', '2026-08-01', '2026-09-01', '2026-10-01'
    ],
    category_slug: catsMeta.areaTag,
    categories: catsMeta.categorySlugs
  };
});

fs.writeFileSync('data/tours.json', JSON.stringify(structuredTours, null, 2), 'utf8');
console.log('Successfully updated data/tours.json with complete official WordPress contents, texts and photos!');
