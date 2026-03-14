#!/bin/bash
set -euo pipefail

# Boom Warehouse — Stripe Gateway Configuration (Test Mode)
# Requires: WooCommerce Stripe Gateway plugin installed

echo "=== Boom Warehouse: Stripe Gateway Setup (Test Mode) ==="

# Enable Stripe gateway
wp option update woocommerce_stripe_settings '{
  "enabled": "yes",
  "title": "Credit / Debit Card",
  "description": "Pay securely with your credit or debit card via Stripe.",
  "testmode": "yes",
  "test_publishable_key": "REPLACE_WITH_STRIPE_TEST_PK",
  "test_secret_key": "REPLACE_WITH_STRIPE_TEST_SK",
  "publishable_key": "",
  "secret_key": "",
  "payment_request": "yes",
  "payment_request_button_type": "buy",
  "payment_request_button_theme": "dark",
  "saved_cards": "yes",
  "logging": "yes",
  "capture": "yes",
  "statement_descriptor": "BOOM WAREHOUSE"
}' --format=json

echo ""
echo "=== Stripe configured in TEST MODE ==="
echo ""
echo "REQUIRED: Replace test keys in WP Admin > WooCommerce > Settings > Payments > Stripe"
echo "  Test PK: pk_test_..."
echo "  Test SK: sk_test_..."
echo ""
echo "TO GO LIVE:"
echo "1. WP Admin > WooCommerce > Settings > Payments > Stripe"
echo '2. Uncheck "Enable test mode"'
echo "3. Enter live publishable and secret keys"
echo "4. Configure webhook: https://boomwarehouse.com/?wc-api=wc_stripe"
echo "   Events: payment_intent.succeeded, payment_intent.payment_failed, charge.refunded"
echo ""
echo "Test card numbers:"
echo "  Success: 4242 4242 4242 4242"
echo "  Decline: 4000 0000 0000 0002"
echo "  3D Secure: 4000 0027 6000 3184"
