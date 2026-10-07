const fs = require('fs');
const path = require('path');

const dirs = [
  'assets/css',
  'assets/js',
  'assets/img/logo',
  'assets/img/tours',
  'assets/img/gallery',
  'config',
  'data',
  'includes',
  'admin'
];

dirs.forEach(d => {
  if (!fs.existsSync(d)) fs.mkdirSync(d, { recursive: true });
});

// Copy logos
if (fs.existsSync('Materiale/Logo/Logo.png')) {
  fs.copyFileSync('Materiale/Logo/Logo.png', 'assets/img/logo/logo.png');
}
if (fs.existsSync('Materiale/Logo/Logo-light.png')) {
  fs.copyFileSync('Materiale/Logo/Logo-light.png', 'assets/img/logo/logo-light.png');
}

// Copy images from Materiale/IMG
if (fs.existsSync('Materiale/IMG')) {
  const files = fs.readdirSync('Materiale/IMG');
  files.forEach(f => {
    const src = path.join('Materiale/IMG', f);
    if (fs.statSync(src).isFile()) {
      fs.copyFileSync(src, path.join('assets/img/gallery', f));
    }
  });
}

console.log('Folders created and local assets copied successfully.');
