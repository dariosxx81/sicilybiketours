const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

function getPhpFiles(dir) {
  let results = [];
  const list = fs.readdirSync(dir);
  list.forEach(file => {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);
    if (stat && stat.isDirectory() && file !== 'node_modules' && file !== '.git') {
      results = results.concat(getPhpFiles(fullPath));
    } else if (file.endsWith('.php')) {
      results.push(fullPath);
    }
  });
  return results;
}

const phpFiles = getPhpFiles('.');
console.log(`Checking syntax for ${phpFiles.length} PHP files...`);

let hasError = false;
phpFiles.forEach(file => {
  try {
    const out = execSync(`"C:\\xampp\\php\\php.exe" -l "${file}"`, { encoding: 'utf-8' });
    console.log(out.trim());
  } catch (err) {
    console.error(`Error in ${file}:`, err.stdout || err.message);
    hasError = true;
  }
});

if (!hasError) {
  console.log('\nAll PHP files passed syntax check successfully!');
}
