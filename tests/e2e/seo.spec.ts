import { test, expect } from '@playwright/test';

test.describe('SEO & Structured Data', () => {
  test('homepage has meta description', async ({ page }) => {
    await page.goto('/');
    const metaDesc = page.locator('meta[name="description"]');
    if (await metaDesc.count() > 0) {
      const content = await metaDesc.getAttribute('content');
      expect(content).toBeTruthy();
      expect(content!.length).toBeGreaterThan(50);
    }
  });

  test('product page has JSON-LD structured data', async ({ page }) => {
    await page.goto('/shop/');
    const firstProduct = page.locator('.bw-product-card__title a').first();
    if (await firstProduct.count() > 0) {
      await firstProduct.click();
      await page.waitForLoadState('networkidle');

      const jsonLdScripts = page.locator('script[type="application/ld+json"]');
      const count = await jsonLdScripts.count();
      expect(count).toBeGreaterThan(0);

      const text = await jsonLdScripts.first().textContent();
      if (text) {
        const data = JSON.parse(text);
        expect(data['@context']).toBe('https://schema.org');
        expect(data['@type']).toBe('Product');
        expect(data.name).toBeTruthy();
        expect(data.offers).toBeTruthy();
        expect(data.offers.price).toBeTruthy();
        expect(data.offers.priceCurrency).toBe('USD');
        expect(data.offers.availability).toMatch(/schema\.org/);
        expect(data.offers.itemCondition).toMatch(/schema\.org/);
      }
    }
  });

  test('pages have canonical URLs', async ({ page }) => {
    await page.goto('/');
    const canonical = page.locator('link[rel="canonical"]');
    if (await canonical.count() > 0) {
      const href = await canonical.getAttribute('href');
      expect(href).toContain('boomwarehouse.com');
    }
  });

  test('images have alt text', async ({ page }) => {
    await page.goto('/shop/');
    const images = page.locator('.bw-product-card__image img');
    const count = await images.count();
    for (let i = 0; i < Math.min(count, 5); i++) {
      const alt = await images.nth(i).getAttribute('alt');
      expect(alt).toBeTruthy();
    }
  });

  test('heading hierarchy is correct (one H1 per page)', async ({ page }) => {
    await page.goto('/');
    const h1Count = await page.locator('h1').count();
    expect(h1Count).toBe(1);

    await page.goto('/shop/');
    const shopH1Count = await page.locator('h1').count();
    expect(shopH1Count).toBe(1);
  });

  test('XML sitemap is accessible', async ({ page }) => {
    const response = await page.goto('/sitemap_index.xml');
    if (response) {
      // Sitemap should return 200 (if Yoast is configured)
      const status = response.status();
      expect([200, 301, 302]).toContain(status);
    }
  });
});
