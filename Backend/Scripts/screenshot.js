#!/usr/bin/env node
const puppeteer = require("../../tools/node_modules/puppeteer");
const fs = require("fs");
const path = require("path");
const os = require("os");

async function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function generateScreenshot(levelId) {
    const jsonPath = path.join(__dirname, "../../levels", `${levelId}.json`);
    const outputPath = path.join(__dirname, "../../levels", `${levelId}.png`);
    
    if (!fs.existsSync(jsonPath)) {
        console.error(`Level JSON not found: ${jsonPath}`);
        process.exit(1);
    }
    
    let levelJson;
    try {
        levelJson = JSON.parse(fs.readFileSync(jsonPath, "utf8"));
    } catch (err) {
        console.error(`Failed to parse JSON: ${err.message}`);
        process.exit(1);
    }
    
    const sandboxDir = path.join(os.tmpdir(), `chromium-sandbox-${process.getuid()}`);
    const profileDir = path.join(sandboxDir, "profile");

    fs.mkdirSync(sandboxDir, { recursive: true });
    fs.mkdirSync(profileDir, { recursive: true });

    try { fs.chmodSync(sandboxDir, 0o755); } catch (_) {}
    try { fs.chmodSync(profileDir, 0o755); } catch (_) {}

    process.env.CHROME_DEVEL_SANDBOX = "";
    process.env.HOME = sandboxDir;
    process.env.TMPDIR = sandboxDir;
    process.env.XDG_CONFIG_HOME = sandboxDir;
    
    let browser;
    try {
        browser = await puppeteer.launch({
            headless: "new",
            executablePath: "/var/www/dev-project/tools/chromium/linux-1632269/chrome-linux/chrome",
            args: [
                "--no-sandbox",
                "--disable-setuid-sandbox",
                "--disable-gpu",
                "--disable-dev-shm-usage",
                "--disable-breakpad",
                "--disable-crash-reporter",
                "--disable-client-side-phishing-detection",
                "--disable-extensions",
                "--disable-sync",
                `--user-data-dir=${profileDir}`
            ],
            timeout: 30000
        });
        
        const page = await browser.newPage();
        await page.setViewport({ width: 800, height: 600 });
        
        await page.goto("http://localhost:8000/GamePage.php?screenshot=1", {
            waitUntil: "domcontentloaded",
            timeout: 30000
        });
        
        // Attendre que la page soit bien chargée avant de commencer
        await sleep(2000);
        
        // Envoyer le niveau à charger
        await page.evaluate((jsonData) => {
            const iframe = document.querySelector("iframe");
            if (iframe) {
                iframe.contentWindow.postMessage({type: "LOAD_LEVEL", data: jsonData}, "*");
            }
        }, levelJson);
        
        // Laisser le moteur WASM charger le niveau avant la capture
        await sleep(10000);
        
        // Attendre que le canvas ou le jeu soit visible
        try {
            await page.waitForFunction(() => {
                const canvas = document.querySelector("canvas");
                return canvas && canvas.width > 0 && canvas.height > 0;
            }, { timeout: 5000 });
        } catch (e) {
            // Continue même si le timeout est atteint - le jeu a peut-être quand même chargé
        }
        
        // Attendre un peu plus pour que tout se stabilise
        await sleep(2000);

        // Ne jamais enregistrer l'ecran de chargement comme miniature valide.
        await page.waitForSelector("#loading-overlay.is-hidden", {
            timeout: 30000
        });
        
        await page.screenshot({path: outputPath, fullPage: false, type: "png"});
        
        if (!fs.existsSync(outputPath)) throw new Error("Screenshot file not created");
        console.log(`OK: ${outputPath}`);
        await browser.close();
        process.exit(0);
    } catch (error) {
        console.error(`ERROR: ${error.message}`);
        if (browser) {try{await browser.close();}catch(e){}}
        process.exit(1);
    }
}

const levelId = process.argv[2];
if (!levelId || !/^[a-zA-Z0-9_-]+$/.test(levelId)) {
    console.error("Invalid levelId");
    process.exit(1);
}
generateScreenshot(levelId);
