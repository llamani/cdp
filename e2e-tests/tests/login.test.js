const assert = require('assert')
const puppeteer = require('puppeteer')

let browser
let page

before(async() => {
    try {
        browser = await puppeteer.launch({
            args: [
                // Required for Docker version of Puppeteer
                '--no-sandbox',
                '--disable-setuid-sandbox',
                // This will write shared memory files into /tmp instead of /dev/shm,
                // because Docker’s default for /dev/shm is 64MB
                '--disable-dev-shm-usage',
                '--disable-web-security'
            ],
        })
    }
    catch (e) {
        console.log(e);
    }
})

after(async() => {
    try {
        //await browser.close()
    } catch (e) {
        console.log(e);
    }
})

describe('LoginPage', () => {
    before(async() => {
        try {
            page = await browser.newPage()
        } catch (e) {
            console.log(e);
        }
    })

    after(async() => {
        try {
            //await page.close()
        } catch (e) {
            console.log(e);
        }
    })

    it('render', async() => {
        try {
            const response = await page.goto('http://web:8005/login.php')
            assert(response.ok());
            await page.screenshot({path: `/screenshots/login.png`})
        } catch (e) {
            console.log(e)
        }
    })

    it('login_fail', async () => {
        try {
            await page.goto('http://web:8005/login.php')
            await page.type('#username', 'johndoe@example.com');
            await page.type('#password', 'testfalse');
            await page.keyboard.press('Enter');

            const ERROR_SELECTOR = '#login-err-msg.active-msg';
            let error;
            await page.waitFor(ERROR_SELECTOR);
            error = await page.$eval(ERROR_SELECTOR, error => error.innerText);
            assert.equal(error, 'Erreur de connexion');
            await page.screenshot({ path: `/screenshots/login_fail.png` })
        } catch (e) {
            console.log(e)
        }
    })
    it('login_success', async () => {
        try {
            //fill login form and submit
            await page.goto('http://web:8005/login.php')
            await page.type('#username', 'johndoe@example.com');
            await page.type('#password', 'test');
            await page.screenshot({ path: `/screenshots/login_1.png` })


           /* await page.on('console', msg => console.log('PAGE LOG: ', msg.text))
            await page.on('pageerror', error => console.log(error.message))
            await page.on('response', response => console.log(response.status, response.url))
            await page.on('requestfailed', request => console.log(request.failure().errorText, request.url))*/
            await page.keyboard.press('Enter')
            await page.screenshot({ path: `/screenshots/login_2.png` })

            //await page.waitFor('#response-ajax-content')
            /*await Promise.race([
                page.waitForNavigation({waitUntil:"load"}),
                page.waitFor('#response-ajax-content'),
                //page.waitFor('#app-body'),
            ]);*/

            await page.screenshot({ path: `/screenshots/login_success.png` })

            /* const HEADING_SELECTOR = 'h1';
             let heading;
             await page.waitFor(HEADING_SELECTOR);
             heading = await page.$eval(HEADING_SELECTOR, heading => heading.innerText);
             assert.equal(heading, 'Projets');
             assert.equal(page.url(), "http://web:8005/app.php");*/

        } catch (e) {
            console.log(e)
        }
    })
})
