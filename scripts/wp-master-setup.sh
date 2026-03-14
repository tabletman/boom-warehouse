#!/bin/bash
set -euo pipefail

# Boom Warehouse — Master Setup Script
# Runs all WP-CLI configuration scripts in order
# Usage: bash scripts/wp-master-setup.sh

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "============================================"
echo "  BOOM WAREHOUSE — Full WooCommerce Setup"
echo "============================================"
echo ""
echo "This will configure:"
echo "  1. WooCommerce + core plugins"
echo "  2. Product categories + condition attribute"
echo "  3. Shipping zones (local pickup + delivery)"
echo "  4. Ohio / Cuyahoga County sales tax (7.5%)"
echo "  5. Stripe payment gateway (test mode)"
echo "  6. Security hardening"
echo ""

# Check WP-CLI is available
if ! command -v wp &>/dev/null; then
  echo "ERROR: WP-CLI not found. Install it first:"
  echo "  curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar"
  echo "  chmod +x wp-cli.phar && sudo mv wp-cli.phar /usr/local/bin/wp"
  exit 1
fi

# Check WordPress is installed
if ! wp core is-installed 2>/dev/null; then
  echo "ERROR: WordPress is not installed at this location."
  echo "Run this script from the WordPress root directory, or specify --path="
  exit 1
fi

echo "WordPress detected: $(wp core version)"
echo ""

# Run each script in order
bash "$SCRIPT_DIR/wp-install-woocommerce.sh"
echo ""
bash "$SCRIPT_DIR/wp-configure-categories.sh"
echo ""
bash "$SCRIPT_DIR/wp-configure-shipping.sh"
echo ""
bash "$SCRIPT_DIR/wp-configure-tax.sh"
echo ""
bash "$SCRIPT_DIR/wp-configure-stripe.sh"
echo ""
bash "$SCRIPT_DIR/wp-configure-security.sh"

echo ""
echo "============================================"
echo "  SETUP COMPLETE"
echo "============================================"
echo ""
echo "Store: https://boomwarehouse.com"
echo "Admin: https://boomwarehouse.com/wp-admin/"
echo ""
echo "REMAINING MANUAL STEPS:"
echo "  1. Set Stripe test API keys in WP Admin > WooCommerce > Settings > Payments"
echo "  2. Configure Wordfence email alerts"
echo "  3. Complete Yoast SEO initial setup wizard"
echo "  4. Upload the boom-warehouse theme"
echo "  5. Install Acima plugin (Milestone 3)"
