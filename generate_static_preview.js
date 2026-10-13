const fs = require('fs');
const path = require('path');

const publicPages = [
  { url: 'http://localhost:8000/', dest: 'index.html' },
  { url: 'http://localhost:8000/escursioni.php', dest: 'escursioni.html' },
  { url: 'http://localhost:8000/tour.php', dest: 'tour.html' },
  { url: 'http://localhost:8000/personalizza-tour.php', dest: 'personalizza-tour.html' },
  { url: 'http://localhost:8000/chi-siamo.php', dest: 'chi-siamo.html' },
  { url: 'http://localhost:8000/contatti.php', dest: 'contatti.html' },
  { url: 'http://localhost:8000/magazine.php', dest: 'magazine.html' },
  { url: 'http://localhost:8000/articolo.php?slug=guida-ebike-etna-percorsi-consigli', dest: 'articolo.html' },
  { url: 'http://localhost:8000/tour-dettaglio.php?slug=etna-summit-vulcano-avventura', dest: 'tour-dettaglio.html' }
];

async function generateStaticSite() {
  console.log('--- GENERAZIONE ANTEPRIMA STATICA (FRONTEND & BACKEND) ---');

  // 1. GENERAZIONE PAGINE FRONTEND
  for (const p of publicPages) {
    try {
      console.log(`Fetching ${p.url}...`);
      const res = await fetch(p.url);
      let html = await res.text();

      // Sostituzione link interni PHP -> HTML statico
      html = html.replace(/href=["'](?:\/|\.\/)?index\.php["']/g, 'href="index.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?escursioni\.php["']/g, 'href="escursioni.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?tour\.php["']/g, 'href="tour.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?personalizza-tour\.php["']/g, 'href="personalizza-tour.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?chi-siamo\.php["']/g, 'href="chi-siamo.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?contatti\.php["']/g, 'href="contatti.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?magazine\.php["']/g, 'href="magazine.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?articolo\.php\?slug=([^"']+)["']/g, 'href="articolo.html"');
      html = html.replace(/href=["'](?:\/|\.\/)?tour-dettaglio\.php\?slug=([^"']+)["']/g, 'href="tour-dettaglio.html"');
      html = html.replace(/href=["']\/["']/g, 'href="index.html"');
      html = html.replace(/href=["']\/(#\w+)["']/g, 'href="$1"');

      // Link Area Gestione / Admin
      html = html.replace(/href=["'](?:\/|\.\/)?admin\/(?:index\.php)?["']/g, 'href="admin/index.html"');
      html = html.replace(/href=["']\/admin\/["']/g, 'href="admin/index.html"');

      // Javascript redirects
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*escursioni\.php\?area=['"]\s*\+\s*this\.selectedArea/g, "window.location.href = 'escursioni.html'");
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*tour\.php\?area=['"]\s*\+\s*this\.selectedArea/g, "window.location.href = 'tour.html'");
      html = html.replace(/window\.location\.href\s*=\s*['"][^'"]*#esperienze['"]/g, "window.location.href = '#esperienze'");

      // Percorsi relativi per assets
      html = html.replace(/src=["']\/assets\//g, 'src="assets/');
      html = html.replace(/href=["']\/assets\//g, 'href="assets/');
      html = html.replace(/"image": "\/assets\//g, '"image": "assets/');

      // Form interattivi senza server
      html = html.replace(/<form\s+([^>]*?)method=["']POST["']([^>]*?)>/gi, (match) => {
        return `<form ${match.slice(6, -1)} onsubmit="event.preventDefault(); alert('Grazie per la richiesta! In questa anteprima statica GitHub Pages i dati non vengono inviati. Sul server PHP live le email arrivano istantaneamente.'); return false;">`;
      });

      fs.writeFileSync(p.dest, html, 'utf8');
      console.log(`-> Salvato con successo: ${p.dest}`);
    } catch (e) {
      console.error(`Errore durante la generazione di ${p.dest}:`, e.message);
    }
  }

  // 2. GENERAZIONE ANTEPRIMA STATICA BACKEND (ADMIN DASHBOARD)
  try {
    console.log('Fetching admin dashboard: http://localhost:8000/admin/?preview_export=1...');
    const adminRes = await fetch('http://localhost:8000/admin/?preview_export=1');
    let adminHtml = await adminRes.text();

    const bannerAdmin = `
    <!-- NOTICE BANNER ANTEPRIMA STATICA -->
    <div style="background: linear-gradient(90deg, #184449, #059669); color: #ffffff; padding: 0.65rem 1.25rem; font-size: 0.88rem; font-weight: 600; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 99999; box-shadow: 0 2px 10px rgba(0,0,0,0.15); flex-wrap: wrap; gap: 0.5rem;">
        <div style="display: flex; align-items: center; gap: 0.65rem;">
            <i class="fa-solid fa-circle-check" style="color: #6ee7b7; font-size: 1.15rem;"></i>
            <span><strong>Anteprima Statica Backend (GitHub Pages)</strong> &mdash; Esplora liberamente tutti i pannelli, categorie, tour, configuratore e menu reattivi in Alpine.js!</span>
        </div>
        <a href="__SITE_URL__" style="background: rgba(255,255,255,0.2); color: #fff; padding: 0.28rem 0.85rem; border-radius: 6px; text-decoration: none; font-size: 0.82rem; border: 1px solid rgba(255,255,255,0.4); display: inline-flex; align-items: center; gap: 0.4rem;">
            <i class="fa-solid fa-arrow-left"></i> Torna al Sito Pubblico
        </a>
    </div>
    `;

    // Aggiungi banner subito dopo <body>
    adminHtml = adminHtml.replace(/<body([^>]*)>/i, `<body$1>\n${bannerAdmin}`);

    // Disabilita salvataggi POST reali con alert esplicativo
    adminHtml = adminHtml.replace(/<form\s+([^>]*?)method=["']POST["']([^>]*?)>/gi, (match) => {
      return `<form ${match.slice(6, -1)} onsubmit="event.preventDefault(); alert('Anteprima Statica Backend: le modifiche nell\\'interfaccia sono interattive, ma per salvare i file su disco avviare il server PHP locale.'); return false;">`;
    });

    // Versione 1: admin/index.html (percorso interno a /admin/)
    let adminSubHtml = adminHtml;
    adminSubHtml = adminSubHtml.replace(/__SITE_URL__/g, '../index.html');
    adminSubHtml = adminSubHtml.replace(/href=["']\/assets\//g, 'href="../assets/');
    adminSubHtml = adminSubHtml.replace(/src=["']\/assets\//g, 'src="../assets/');
    adminSubHtml = adminSubHtml.replace(/href=["']assets\//g, 'href="../assets/');
    adminSubHtml = adminSubHtml.replace(/src=["']assets\//g, 'src="../assets/');
    adminSubHtml = adminSubHtml.replace(/href=["'](?:\/|\.\/)?index\.php["']/g, 'href="../index.html"');
    adminSubHtml = adminSubHtml.replace(/href=["']\/(?:index\.html)?["']/g, 'href="../index.html"');
    adminSubHtml = adminSubHtml.replace(/href=["'][^"']*\/admin\/\?logout=1["']/g, 'href="../index.html"');

    // Ensure directory admin exists
    if (!fs.existsSync('admin')) {
      fs.mkdirSync('admin', { recursive: true });
    }
    fs.writeFileSync('admin/index.html', adminSubHtml, 'utf8');
    console.log('-> Salvato con successo: admin/index.html');

    // Versione 2: admin.html (livello root per comodità)
    let adminRootHtml = adminHtml;
    adminRootHtml = adminRootHtml.replace(/__SITE_URL__/g, 'index.html');
    adminRootHtml = adminRootHtml.replace(/href=["']\/assets\//g, 'href="assets/');
    adminRootHtml = adminRootHtml.replace(/src=["']\/assets\//g, 'src="assets/');
    adminRootHtml = adminRootHtml.replace(/href=["'](?:\/|\.\/)?index\.php["']/g, 'href="index.html"');
    adminRootHtml = adminRootHtml.replace(/href=["']\/(?:index\.html)?["']/g, 'href="index.html"');
    adminRootHtml = adminRootHtml.replace(/href=["'][^"']*\/admin\/\?logout=1["']/g, 'href="index.html"');

    fs.writeFileSync('admin.html', adminRootHtml, 'utf8');
    console.log('-> Salvato con successo: admin.html');

  } catch (e) {
    console.error('Errore durante la generazione dell\'admin:', e.message);
  }

  // 3. CREA .nojekyll
  fs.writeFileSync('.nojekyll', '', 'utf8');
  console.log('-> Creato file .nojekyll per GitHub Pages');

  console.log('--- GENERAZIONE COMPLETATA CON SUCCESSO! ---');
}

generateStaticSite();
