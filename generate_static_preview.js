const fs = require('fs');
const path = require('path');

const pagesToFetch = [
  { url: 'http://127.0.0.1:8000/', dest: 'index.html' },
  { url: 'http://127.0.0.1:8000/escursioni.php', dest: 'escursioni.html' },
  { url: 'http://127.0.0.1:8000/tour.php', dest: 'tour.html' },
  { url: 'http://127.0.0.1:8000/personalizza-tour.php', dest: 'personalizza-tour.html' },
  { url: 'http://127.0.0.1:8000/chi-siamo.php', dest: 'chi-siamo.html' },
  { url: 'http://127.0.0.1:8000/contatti.php', dest: 'contatti.html' },
  { url: 'http://127.0.0.1:8000/tour-dettaglio.php?slug=etna-summit-vulcano-avventura', dest: 'tour-dettaglio.html' }
];

async function generateStaticSite() {
  console.log('Generating static HTML files for GitHub Pages...');
  
  for (const p of pagesToFetch) {
    try {
      const res = await fetch(p.url);
      let html = await res.text();

      // Transform PHP links to static HTML links
      html = html.replace(/href=["'](?:\/|\.\/)?index\.php["']/g, 'href="index.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?escursioni\.php["']/g, 'href="escursioni.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?tour\.php["']/g, 'href="tour.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?personalizza-tour\.php["']/g, 'href="personalizza-tour.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?chi-siamo\.php["']/g, 'href="chi-siamo.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?contatti\.php["']/g, 'href="contatti.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?tour-dettaglio\.php\?slug=([^"']+)["']/g, 'href="tour-dettaglio.html"');
      html = html.replace(/href=["']\/["']/g, 'href="index.html"');
      html = html.replace(/href=["']\/(#\w+)["']/g, 'href="$1"');

      // Fix javascript location redirects
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*escursioni\.php\?area=['"]\s*\+\s*this\.selectedArea/g, "window.location.href = 'escursioni.html'");
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*tour\.php\?area=['"]\s*\+\s*this\.selectedArea/g, "window.location.href = 'tour.html'");
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*#esperienze['"]/g, "window.location.href = '#esperienze'");

      // Fix image and asset paths
      html = html.replace(/src=["']\/assets\//g, 'src="assets/');
      html = html.replace(/href=["']\/assets\//g, 'href="assets/');
      html = html.replace(/"image": "\/assets\//g, '"image": "assets/');

      fs.writeFileSync(p.dest, html);
      console.log(`Saved: ${p.dest}`);
    } catch (e) {
      console.error(`Error generating ${p.dest}:`, e);
    }
  }

  // Create .nojekyll for GitHub Pages
  fs.writeFileSync('.nojekyll', '');
  console.log('Created .nojekyll');
}

generateStaticSite();
