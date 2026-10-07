const fs = require('fs');
const path = require('path');
const https = require('https');
const http = require('http');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf-8'));

// Function to download image
function downloadImage(url, dest) {
  return new Promise((resolve, reject) => {
    if (!url || !url.startsWith('http')) return resolve(null);
    const dir = path.dirname(dest);
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
    if (fs.existsSync(dest)) return resolve(dest);

    const client = url.startsWith('https') ? https : http;
    client.get(url, (res) => {
      if (res.statusCode === 200) {
        const fileStream = fs.createWriteStream(dest);
        res.pipe(fileStream);
        fileStream.on('finish', () => {
          fileStream.close();
          resolve(dest);
        });
      } else {
        resolve(null);
      }
    }).on('error', (err) => resolve(null));
  });
}

async function processTours() {
  const structuredTours = [];

  for (const p of posts) {
    const content = p.content.rendered;
    
    // Extract image URLs from content
    const imgMatches = [...content.matchAll(/src=["'](https?:\/\/[^"']+\.(?:jpg|jpeg|png|webp))["']/gi)];
    const images = imgMatches.map(m => m[1]);

    // Simple parser for specs often written like "Periodo: ... Inizio: ... Durata: ... Lunghezza: ... Dislivello: ... Livello: ..."
    const stripHtml = (html) => html.replace(/<[^>]+>/g, ' ').replace(/&nbsp;/g, ' ').replace(/&#8217;/g, "'").replace(/&#8211;/g, "-").replace(/\s+/g, ' ').trim();
    const cleanContent = stripHtml(content);

    // Determine type: 'giornaliera' vs 'plurigiornaliero'
    const isMultiDay = p.slug.includes('giorni') || p.slug.includes('weekend') || p.slug.includes('barocco') || p.slug.includes('eolie') || cleanContent.toLowerCase().includes('più giorni') || cleanContent.toLowerCase().includes('giorni,');

    structuredTours.push({
      id: p.id,
      slug: p.slug,
      title: p.title.rendered.replace(/&#8217;/g, "'").replace(/&#8211;/g, "-"),
      type: isMultiDay ? 'tour' : 'escursione', // 'escursione' (1 day) or 'tour' (multi day)
      category: isMultiDay ? 'Tour Plurigiornalieri' : 'Escursioni Giornaliere',
      featured_image: images[0] || '',
      gallery: images.slice(1, 6),
      excerpt: stripHtml(p.excerpt.rendered),
      raw_content: content,
      clean_content: cleanContent
    });
  }

  fs.writeFileSync('structured_tours.json', JSON.stringify(structuredTours, null, 2));
  console.log('Structured tours saved. Processing downloads...');
}

processTours();
