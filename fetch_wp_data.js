const fs = require('fs');

async function fetchAll() {
  try {
    const postsRes = await fetch('https://www.sicilybiketours.it/wp-json/wp/v2/posts?per_page=100');
    const posts = await postsRes.json();
    console.log(`Fetched ${posts.length} posts`);
    
    const pagesRes = await fetch('https://www.sicilybiketours.it/wp-json/wp/v2/pages?per_page=100');
    const pages = await pagesRes.json();
    console.log(`Fetched ${pages.length} pages`);

    fs.writeFileSync('wp_posts.json', JSON.stringify(posts, null, 2));
    fs.writeFileSync('wp_pages.json', JSON.stringify(pages, null, 2));
    console.log('Saved to wp_posts.json and wp_pages.json');
  } catch (err) {
    console.error('Error fetching WP data:', err);
  }
}

fetchAll();
