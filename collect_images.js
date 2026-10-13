const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));
const media = JSON.parse(fs.readFileSync('wp_featured_media.json', 'utf8'));

const allImages = new Set();
posts.forEach(p => {
  const feat = media[p.featured_media];
  if (feat && feat.source_url) allImages.add(feat.source_url);
  const m = p.content.rendered.match(/https?:\/\/[^\s"'<>]+?\.(?:jpg|jpeg|png|webp)/gi) || [];
  m.forEach(url => {
    if (!url.includes('logo') && !url.includes('icon') && !url.includes('svg')) {
      allImages.add(url);
    }
  });
});

console.log('Total unique images found:', allImages.size);
fs.writeFileSync('all_wp_images.json', JSON.stringify([...allImages], null, 2));
