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
                '--disable-dev-shm-usage'
            ],
        })
    }
    catch (e) {
        console.log(e);
    }
})

after(async() => {
    try {
        await browser.close()
    } catch (e) {
        console.log(e);
    }
})

describe('ProjectsPage', () => {
    before(async() => {
        try {
            page = await browser.newPage()
        } catch (e) {
            console.log(e);
        }
    })

    after(async() => {
        try {
            await page.close()
        } catch (e) {
            console.log(e);
        }
    })

    it('render', async() => {
        try {
            const response = await page.goto('http://web:8005/app.php?page=projects')
            assert(response.ok());
            await page.screenshot({path: `/screenshots/projects.png`})
        } catch (e) {
            console.log(e)
        }
    })
})
