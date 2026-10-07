const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf-8'));
const pages = JSON.parse(fs.readFileSync('wp_pages.json', 'utf-8'));

console.log('=== POSTS (TOURS) ===');
posts.forEach(p => {
  console.log(`ID: ${p.id} | Slug: ${p.slug} | Title: ${p.title.rendered}`);
});

console.log('\n=== PAGES ===');
pages.forEach(p => {
  console.log(`ID: ${p.id} | Slug: ${p.slug} | Title: ${p.title.rendered}`);
});
