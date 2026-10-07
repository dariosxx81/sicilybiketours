const ffmpeg = require('ffmpeg-static');
const { execSync } = require('child_process');
const path = require('path');

const inputPath = path.resolve('Materiale', 'Audio', 'specifiche_new_site.amr');
const outputPathMp3 = path.resolve('Materiale', 'Audio', 'specifiche_new_site.mp3');
const outputPathWav = path.resolve('Materiale', 'Audio', 'specifiche_new_site.wav');

try {
  execSync(`"${ffmpeg}" -y -i "${inputPath}" "${outputPathMp3}"`, { stdio: 'inherit' });
  execSync(`"${ffmpeg}" -y -i "${inputPath}" "${outputPathWav}"`, { stdio: 'inherit' });
  console.log('Conversion completed successfully!');
} catch (e) {
  console.error('Error during conversion:', e);
}
