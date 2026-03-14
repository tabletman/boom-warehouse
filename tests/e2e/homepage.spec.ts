import { test, expect } from '@playwright/test';

test.describe('Homepage', () => {
  test('loads with correct title and branding', async ({ page }) => {
    await page.goto('/');
    await expect(page).toHaveTitle(/Boom Warehouse/i);
    await expect(page.locator('.bw-logo')).toBeVisible();
  });

  test('displays category tiles', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('.bw-category-tile')).toHaveCount(6);
  });

  test('displays USP bar', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('.bw-usp-bar')).toBeVisible();
    await expect(page.locator('.bw-usp-bar')).toContainText('Acima Financing');
  });

  test('hero section has CTAs', async ({ page }) => {
    await page.goto('/');
    await expect(page.locator('.bw-hero')).toBeVisible();
    await expect(page.getByRole('link', { name: /shop all deals/i })).toBeVisible();
    await expect(page.getByRole('link', { name: /pre-qualify/i })).toBeVisible();
  });

  test('navigation links to product categories', async ({ page }) => {
    await page.goto('/');
    const nav = page.locator('.bw-nav');
    await expect(nav).toBeVisible();
    await expect(nav.locator('a')).toHaveCount({ minimum: 1 });
  });

  test('search form is present', async ({ page }) => {
    await page.goto('/');
    const searchInput = page.locator('.bw-search__input').first();
    await expect(searchInput).toBeVisible();
  });

  test('footer displays both locations', async ({ page }) => {
    await page.goto('/');
    const footer = page.locator('.bw-footer');
    await expect(footer).toContainText('Renaissance Pkwy');
    await expect(footer).toContainText('Emery Rd');
  });
});
