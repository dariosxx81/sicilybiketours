const fs = require('fs');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));

posts.forEach((p, idx) => {
  const content = p.content.rendered;
  
  // Extract text blocks
  // Remove scripts, styles
  let clean = content.replace(/<style[^>]*>[\s\S]*?<\/style>/gi, '');
  clean = clean.replace(/<script[^>]*>[\s\S]*?<\/script>/gi, '');
  
  // Replace headings with markers
  clean = clean.replace(/<h([1-6])[^>]*>([\s\S]*?)<\/h\1>/gi, '\n### [H$1] $2\n');
  clean = clean.replace(/<li[^>]*>([\s\S]*?)<\/li>/gi, '\n* $1');
  clean = clean.replace(/<p[^>]*>([\s\S]*?)<\/p>/gi, '\n$1\n');
  clean = clean.replace(/<br\s*\/?>/gi, '\n');
  clean = clean.replace(/<[^>]+>/g, '');
  clean = clean.replace(/&nbsp;/g, ' ');
  clean = clean.replace(/&#8217;/g, "'");
  clean = clean.replace(/&#8211;/g, "-");
  clean = clean.replace(/&#8220;/g, '"');
  clean = clean.replace(/&#8221;/g, '"');
  clean = clean.replace(/&amp;/g, '&');
  
  const lines = clean.split('\n').map(l => l.trim()).filter(l => l.length > 0);
  
  console.log(`\n================================================================================`);
  console.log(`POST #${idx + 1} [WP ID ${p.id}] - ${p.title.rendered}`);
  console.log(`Slug: ${p.slug}`);
  console.log(`================================================================================`);
  console.log(lines.join('\n'));
});
