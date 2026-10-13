const fs = require('fs');
const https = require('https');
const http = require('http');
const path = require('path');

const posts = JSON.parse(fs.readFileSync('wp_posts.json', 'utf8'));
const media = JSON.parse(fs.readFileSync('wp_featured_media.json', 'utf8'));

const targetDir = path.join(__dirname, 'assets', 'img', 'tours');
if (!fs.existsSync(targetDir)) {
  fs.mkdirSync(targetDir, { recursive: true });
}

function downloadFile(url, destPath) {
  return new Promise((resolve, reject) => {
    if (fs.existsSync(destPath) && fs.statSync(destPath).size > 1000) {
      // Already downloaded
      return resolve(destPath);
    }
    const client = url.startsWith('https') ? https : http;
    const req = client.get(url, { headers: { 'User-Agent': 'Mozilla/5.0' } }, (res) => {
      if (res.statusCode >= 300 && res.statusCode < 400 && res.headers.location) {
        return downloadFile(res.headers.location, destPath).then(resolve).catch(reject);
      }
      if (res.statusCode !== 200) {
        return reject(new Error(`Failed to download ${url}: status code ${res.statusCode}`));
      }
      const fileStream = fs.createWriteStream(destPath);
      res.pipe(fileStream);
      fileStream.on('finish', () => {
        fileStream.close();
        resolve(destPath);
      });
      fileStream.on('error', (err) => {
        fs.unlink(destPath, () => {});
        reject(err);
      });
    });
    req.on('error', reject);
    req.setTimeout(15000, () => {
      req.destroy();
      reject(new Error(`Timeout downloading ${url}`));
    });
  });
}

// Map each post to its essential images (featured image + first 4 gallery images)
const tourImagesMap = {};

async function processAll() {
  for (const p of posts) {
    const feat = media[p.featured_media];
    const featUrl = feat ? feat.source_url : null;
    
    // find gallery images in content
    const allMatches = p.content.rendered.match(/https?:\/\/[^\s"'<>]+?\.(?:jpg|jpeg|png|webp)/gi) || [];
    const galleryUrls = [];
    if (featUrl) galleryUrls.push(featUrl);
    
    for (const u of allMatches) {
      if (!u.includes('logo') && !u.includes('icon') && !u.includes('elementor') && !galleryUrls.includes(u)) {
        galleryUrls.push(u);
      }
      if (galleryUrls.length >= 6) break; // max 6 images per tour
    }

    const localImages = [];
    for (let i = 0; i < galleryUrls.length; i++) {
      const imgUrl = galleryUrls[i];
      const ext = path.extname(new URL(imgUrl).pathname) || '.jpg';
      const cleanSlug = p.slug.replace(/[^a-z0-9_-]/gi, '-');
      const filename = `${cleanSlug}-${i + 1}${ext}`;
      const destPath = path.join(targetDir, filename);
      const relPath = `assets/img/tours/${filename}`;
      
      try {
        await downloadFile(imgUrl, destPath);
        localImages.push(relPath);
      } catch (err) {
        console.warn(`Failed image ${imgUrl}:`, err.message);
      }
    }
    
    tourImagesMap[p.id] = {
      featured: localImages[0] || '',
      gallery: localImages
    };
    console.log(`Processed images for Post #${p.id} (${p.slug}): ${localImages.length} images saved.`);
  }

  fs.writeFileSync('wp_tour_local_images.json', JSON.stringify(tourImagesMap, null, 2));
  console.log('Finished saving all tour images to assets/img/tours/ and mapped to wp_tour_local_images.json');
}

processAll();
