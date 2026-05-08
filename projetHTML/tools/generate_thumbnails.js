const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer');

(async () => {
  try {
    const levelsDir = path.resolve(__dirname, '..', 'levels');
    const outDir = path.resolve(__dirname, '..', 'img');

    if (!fs.existsSync(outDir)) fs.mkdirSync(outDir, { recursive: true });
    if (!fs.existsSync(levelsDir)) {
      console.error('Levels directory not found:', levelsDir);
      process.exit(1);
    }

    const files = fs.readdirSync(levelsDir).filter(f => f.endsWith('.json'));
    if (files.length === 0) {
      console.log('Aucun fichier JSON trouvé dans', levelsDir);
      process.exit(0);
    }

    const browser = await puppeteer.launch({ headless: true, args: ['--no-sandbox','--disable-setuid-sandbox'] });
    const page = await browser.newPage();
    await page.setViewport({ width: 1280, height: 720 });

    // Navigate to the game page
    const gameUrl = 'https://ex-a01.github.io/ARCH-JS/';
    await page.goto(gameUrl, { waitUntil: 'networkidle2' });

    for (const file of files) {
      const filePath = path.join(levelsDir, file);
      const jsonText = fs.readFileSync(filePath, 'utf8');

      console.log('Processing', file);

      // Send the level JSON to the page (game listens for LOAD_LEVEL messages)
      await page.evaluate((data) => {
        window.postMessage({ type: 'LOAD_LEVEL', data }, '*');
      }, jsonText);

      // Wait a bit for the game to parse/load/render the level
      await page.waitForTimeout(2000); // 2s (adjust if needed)

      // Optionally wait for a specific selector (canvas) to appear
      // const canvas = await page.$('canvas');
      // if (canvas) await canvas.screenshot({ path: outPath });

      // Save a screenshot of the viewport
      const levelId = path.basename(file, '.json');
      const outPath = path.join(outDir, `${levelId}.png`);
      await page.screenshot({ path: outPath, fullPage: false });
      console.log('Saved', outPath);

      // small pause between levels
      await page.waitForTimeout(500);
    }

    await browser.close();
    console.log('Done.');
  } catch (err) {
    console.error('Error:', err);
    process.exit(1);
  }
})();
