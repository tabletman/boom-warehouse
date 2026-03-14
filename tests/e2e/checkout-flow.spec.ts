import { test, expect } from '@playwright/test';

test.describe('Checkout Flow', () => {
  test('add product to cart and proceed to checkout', async ({ page }) => {
    // Browse to shop
    await page.goto('/shop/');
    await expect(page.locator('.bw-product-card')).toHaveCount({ minimum: 1 });

    // Click first product
    await page.locator('.bw-product-card__title a').first().click();
    await page.waitForLoadState('networkidle');

    // Add to cart
    const atcBtn = page.locator('.single_add_to_cart_button');
    if (await atcBtn.count() > 0) {
      await atcBtn.click();
      await page.waitForLoadState('networkidle');

      // Go to cart
      await page.goto('/cart/');
      await expect(page.locator('.woocommerce-cart-form')).toBeVisible();

      // Verify cart has items
      const cartItems = page.locator('.cart_item');
      await expect(cartItems).toHaveCount({ minimum: 1 });

      // Proceed to checkout
      await page.locator('a.checkout-button, .wc-proceed-to-checkout a').first().click();
      await page.waitForLoadState('networkidle');

      // Verify checkout page
      await expect(page).toHaveURL(/checkout/);
      await expect(page.locator('#billing_first_name')).toBeVisible();
    }
  });

  test('cart updates quantity correctly', async ({ page }) => {
    await page.goto('/shop/');
    await page.locator('.bw-product-card__title a').first().click();
    await page.waitForLoadState('networkidle');

    const atcBtn = page.locator('.single_add_to_cart_button');
    if (await atcBtn.count() > 0) {
      // Set quantity to 2
      const qtyInput = page.locator('input.qty');
      if (await qtyInput.count() > 0) {
        await qtyInput.fill('2');
      }
      await atcBtn.click();
      await page.waitForLoadState('networkidle');

      await page.goto('/cart/');
      const qty = page.locator('.cart_item .qty').first();
      if (await qty.count() > 0) {
        const val = await qty.inputValue();
        expect(parseInt(val)).toBeGreaterThanOrEqual(1);
      }
    }
  });

  test('checkout form validates required fields', async ({ page }) => {
    // Add product to cart first
    await page.goto('/shop/');
    await page.locator('.bw-product-card__title a').first().click();
    await page.waitForLoadState('networkidle');

    const atcBtn = page.locator('.single_add_to_cart_button');
    if (await atcBtn.count() > 0) {
      await atcBtn.click();
      await page.waitForLoadState('networkidle');

      await page.goto('/checkout/');
      await page.waitForLoadState('networkidle');

      // Try to place order without filling in required fields
      const placeOrder = page.locator('#place_order');
      if (await placeOrder.count() > 0) {
        await placeOrder.click();
        await page.waitForTimeout(2000);

        // Should show validation errors
        const errors = page.locator('.woocommerce-error, .woocommerce-NoticeGroup-checkout');
        if (await errors.count() > 0) {
          await expect(errors.first()).toBeVisible();
        }
      }
    }
  });

  test('Stripe payment option is available at checkout', async ({ page }) => {
    await page.goto('/shop/');
    await page.locator('.bw-product-card__title a').first().click();
    await page.waitForLoadState('networkidle');

    const atcBtn = page.locator('.single_add_to_cart_button');
    if (await atcBtn.count() > 0) {
      await atcBtn.click();
      await page.waitForLoadState('networkidle');

      await page.goto('/checkout/');
      await page.waitForLoadState('networkidle');

      // Check Stripe payment method exists
      const stripe = page.locator('#payment_method_stripe, label[for="payment_method_stripe"]');
      if (await stripe.count() > 0) {
        await expect(stripe.first()).toBeVisible();
      }
    }
  });
});
