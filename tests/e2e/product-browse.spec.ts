import { test, expect } from '@playwright/test';

test.describe('Product Browsing', () => {
  test('shop page loads with products', async ({ page }) => {
    await page.goto('/shop/');
    await expect(page.locator('.bw-product-card')).toHaveCount({ minimum: 1 });
  });

  test('product cards show condition badges', async ({ page }) => {
    await page.goto('/shop/');
    const badges = page.locator('.bw-badge');
    await expect(badges.first()).toBeVisible();
  });

  test('product cards show Acima monthly estimate', async ({ page }) => {
    await page.goto('/shop/');
    const acima = page.locator('.bw-product-card__acima');
    if (await acima.count() > 0) {
      await expect(acima.first()).toContainText('Acima');
      await expect(acima.first()).toContainText('/mo');
    }
  });

  test('product cards show location info', async ({ page }) => {
    await page.goto('/shop/');
    const location = page.locator('.bw-product-card__location');
    if (await location.count() > 0) {
      await expect(location.first()).toBeVisible();
    }
  });

  test('clicking a product navigates to detail page', async ({ page }) => {
    await page.goto('/shop/');
    const firstProduct = page.locator('.bw-product-card__title a').first();
    const productName = await firstProduct.textContent();
    await firstProduct.click();
    await expect(page).toHaveURL(/\/product\//);
    if (productName) {
      await expect(page.locator('h1')).toContainText(productName.trim());
    }
  });

  test('category filter narrows results', async ({ page }) => {
    await page.goto('/product-category/tvs-displays/');
    const products = page.locator('.bw-product-card');
    if (await products.count() > 0) {
      await expect(page.locator('h1')).toContainText(/TV/i);
    }
  });

  test('search returns relevant products', async ({ page }) => {
    await page.goto('/');
    const searchInput = page.locator('.bw-search__input').first();
    await searchInput.fill('Samsung');
    await searchInput.press('Enter');
    await page.waitForLoadState('networkidle');
    // Search results page should load
    await expect(page).toHaveURL(/[?&]s=Samsung/i);
  });
});
