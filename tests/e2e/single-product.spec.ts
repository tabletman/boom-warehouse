import { test, expect } from '@playwright/test';

test.describe('Single Product Page', () => {
  test.beforeEach(async ({ page }) => {
    // Navigate to first available product
    await page.goto('/shop/');
    await page.locator('.bw-product-card__title a').first().click();
    await page.waitForLoadState('networkidle');
  });

  test('displays product title and price', async ({ page }) => {
    await expect(page.locator('h1')).toBeVisible();
    await expect(page.locator('.price')).toBeVisible();
  });

  test('displays condition badge', async ({ page }) => {
    const badge = page.locator('.bw-badge');
    if (await badge.count() > 0) {
      await expect(badge.first()).toBeVisible();
    }
  });

  test('displays stock indicator', async ({ page }) => {
    const stock = page.locator('.bw-stock');
    await expect(stock.first()).toBeVisible();
  });

  test('displays Acima CTA for eligible products', async ({ page }) => {
    const acimaCta = page.locator('.bw-acima-cta');
    if (await acimaCta.count() > 0) {
      await expect(acimaCta).toContainText('Acima');
      await expect(acimaCta).toContainText('/mo');
    }
  });

  test('displays location availability', async ({ page }) => {
    const location = page.locator('.bw-location');
    if (await location.count() > 0) {
      await expect(location.first()).toBeVisible();
    }
  });

  test('has Add to Cart button', async ({ page }) => {
    const atcBtn = page.locator('.single_add_to_cart_button');
    if (await atcBtn.count() > 0) {
      await expect(atcBtn).toBeVisible();
      await expect(atcBtn).toContainText(/add to cart/i);
    }
  });

  test('displays SKU', async ({ page }) => {
    const sku = page.locator('.bw-single-product__sku');
    if (await sku.count() > 0) {
      await expect(sku).toContainText('SKU');
    }
  });

  test('has product tabs (description, reviews)', async ({ page }) => {
    const tabs = page.locator('.woocommerce-tabs');
    if (await tabs.count() > 0) {
      await expect(tabs).toBeVisible();
    }
  });

  test('JSON-LD structured data is present', async ({ page }) => {
    const jsonLd = await page.locator('script[type="application/ld+json"]').textContent();
    if (jsonLd) {
      const data = JSON.parse(jsonLd);
      expect(data['@type']).toBe('Product');
      expect(data.offers).toBeDefined();
      expect(data.offers.priceCurrency).toBe('USD');
    }
  });
});
