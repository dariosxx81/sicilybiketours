const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));
const localTours = JSON.parse(fs.readFileSync('data/tours.json', 'utf8'));

console.log('Total WP Posts:', posts.length);
console.log('Total Local Tours:', localTours.length);

const results = [];

posts.forEach((p, idx) => {
  const content = p.content?.rendered || '';
  
  // Extract images
  const imgRegex = /src=["'](https?:\/\/[^"']+\.(?:jpg|jpeg|png|webp))["']/gi;
  let match;
  const images = [];
  while ((match = imgRegex.exec(content)) !== null) {
    if (!images.includes(match[1])) {
      images.push(match[1]);
    }
  }

  // Extract sections from WP content
  // Many WP posts have headers like: "Periodo:", "Durata:", "Lunghezza:", "Dislivello:", "La quota comprende:", "La quota non comprende:"
  const plainText = content
    .replace(/<br\s*\/?>/gi, '\n')
    .replace(/<\/p>/gi, '\n\n')
    .replace(/<\/li>/gi, '\n')
    .replace(/<[^>]+>/g, '')
    .replace(/&nbsp;/g, ' ')
    .replace(/&#8217;/g, "'")
    .replace(/&#8211;/g, "-")
    .replace(/&amp;/g, "&");

  // Search price lines
  const lines = plainText.split('\n').map(l => l.trim()).filter(Boolean);
  const priceMentions = lines.filter(l => /€|euro|a partire da|prezzo|quota/i.test(l));

  // Try to match with local tour
  const matchedLocal = localTours.find(lt => {
    return lt.slug === p.slug || 
           lt.title.toLowerCase().includes(p.title.rendered.slice(0, 15).toLowerCase()) ||
           p.slug.includes(lt.slug.slice(0, 15));
  });

  results.push({
    wp_id: p.id,
    wp_slug: p.slug,
    wp_title: p.title.rendered,
    wp_categories: p.categories,
    featured_media_id: p.featured_media,
    wp_images_found: images,
    price_mentions: priceMentions,
    content_length: plainText.length,
    full_text_preview: plainText.slice(0, 500),
    matched_local_id: matchedLocal ? matchedLocal.id : null,
    matched_local_title: matchedLocal ? matchedLocal.title : null,
    matched_local_price: matchedLocal ? matchedLocal.price : null,
    matched_local_category: matchedLocal ? matchedLocal.category : null,
    matched_local_type: matchedLocal ? matchedLocal.type : null
  });
});

fs.writeFileSync('wp_analysis_report.json', JSON.stringify(results, null, 2));
console.log('Analysis saved to wp_analysis_report.json');
