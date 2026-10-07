const fs = require('fs');
const https = require('https');

https.get('https://unpkg.com/alpinejs@3.14.8/dist/cdn.min.js', (res) => {
  let data = '';
  res.on('data', chunk => data += chunk);
  res.on('end', () => {
    fs.writeFileSync('assets/js/alpine.min.js', data);
    console.log('Alpine.js v3 downloaded successfully. Size:', data.length);
  });
}).on('error', err => console.error('Failed to download Alpine:', err));
