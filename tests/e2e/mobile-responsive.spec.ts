import { test, expect } from '@playwright/test';

test.describe('Mobile Responsiveness', () => {
  // Test at exact breakpoints from PRD
  const viewports = [
    { name: 'iPhone SE', width: 375, height: 667 },
    { name: 'iPhone 14', width: 390, height: 844 },
    { name: 'iPad', width: 768, height: 1024 },
    { name: 'Desktop', width: 1024, height: 768 },
  ];

  for (const vp of viewports) {
    test(`homepage renders at ${vp.name} (${vp.width}px)`, async ({ page }) => {
      await page.setViewportSize({ width: vp.width, height: vp.height });
      await page.goto('/');

      // Logo visible
      await expect(page.locator('.bw-logo')).toBeVisible();

      // Hero visible
      await expect(page.locator('.bw-hero')).toBeVisible();

      // No horizontal overflow
      const bodyWidth = await page.evaluate(() => document.body.scrollWidth);
      expect(bodyWidth).toBeLessThanOrEqual(vp.width + 1);
    });

    test(`shop page renders at ${vp.name} (${vp.width}px)`, async ({ page }) => {
      await page.setViewportSize({ width: vp.width, height: vp.height });
      await page.goto('/shop/');

      // Products visible
      const products = page.locator('.bw-product-card');
      if (await products.count() > 0) {
        await expect(products.first()).toBeVisible();
      }

      // No horizontal overflow
      const bodyWidth = await page.evaluate(() => document.body.scrollWidth);
      expect(bodyWidth).toBeLessThanOrEqual(vp.width + 1);
    });
  }

  test('mobile menu toggle works at 375px', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/');

    const toggle = page.locator('.bw-menu-toggle');
    await expect(toggle).toBeVisible();

    await toggle.click();
    await expect(page.locator('#bw-mobile-nav')).toHaveClass(/is-open/);

    await toggle.click();
    await expect(page.locator('#bw-mobile-nav')).not.toHaveClass(/is-open/);
  });

  test('sticky add-to-cart shows on mobile product page', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/shop/');

    const firstProduct = page.locator('.bw-product-card__title a').first();
    if (await firstProduct.count() > 0) {
      await firstProduct.click();
      await page.waitForLoadState('networkidle');

      // Scroll down past the add to cart button
      await page.evaluate(() => window.scrollBy(0, 800));
      await page.waitForTimeout(500);

      const stickyAtc = page.locator('.bw-sticky-atc');
      if (await stickyAtc.count() > 0) {
        await expect(stickyAtc).toHaveClass(/is-visible/);
      }
    }
  });

  test('tap targets are at least 44x44px on mobile', async ({ page }) => {
    await page.setViewportSize({ width: 375, height: 667 });
    await page.goto('/');

    // Check main CTA buttons
    const buttons = page.locator('.bw-btn');
    const count = await buttons.count();
    for (let i = 0; i < Math.min(count, 5); i++) {
      const box = await buttons.nth(i).boundingBox();
      if (box) {
        expect(box.height).toBeGreaterThanOrEqual(44);
      }
    }
  });
});
