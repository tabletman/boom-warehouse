#!/bin/bash
set -euo pipefail

# Boom Warehouse — WooCommerce Foundation Setup
# Run via WP-CLI on Hostinger (SSH or hPanel terminal)
# Prerequisites: WordPress already installed, WP-CLI available

echo "=== Boom Warehouse: WooCommerce Foundation Setup ==="

# 1. Install and activate WooCommerce
echo "[1/6] Installing WooCommerce..."
wp plugin install woocommerce --activate

# 2. Install core plugins
echo "[2/6] Installing core plugins..."
wp plugin install woocommerce-gateway-stripe --activate
wp plugin install wordpress-seo --activate           # Yoast SEO
wp plugin install wordfence --activate

# 3. Configure WooCommerce general settings
echo "[3/6] Configuring WooCommerce settings..."
wp option update woocommerce_store_address "4554 Renaissance Pkwy"
wp option update woocommerce_store_address_2 ""
wp option update woocommerce_store_city "Warrensville Heights"
wp option update woocommerce_default_country "US:OH"
wp option update woocommerce_store_postcode "44128"
wp option update woocommerce_currency "USD"
wp option update woocommerce_price_thousand_sep ","
wp option update woocommerce_price_decimal_sep "."
wp option update woocommerce_price_num_decimals "2"

# Enable stock management
wp option update woocommerce_manage_stock "yes"
wp option update woocommerce_notify_low_stock "yes"
wp option update woocommerce_notify_no_stock "yes"
wp option update woocommerce_stock_email_recipient "admin@boomwarehouse.com"
wp option update woocommerce_notify_low_stock_amount "3"
wp option update woocommerce_notify_no_stock_amount "0"

# Enable tax
wp option update woocommerce_calc_taxes "yes"

# Currency display
wp option update woocommerce_currency_pos "left"

# Checkout settings
wp option update woocommerce_enable_guest_checkout "yes"
wp option update woocommerce_enable_checkout_login_reminder "yes"
wp option update woocommerce_enable_signup_and_login_from_checkout "yes"

# Weight/dimension units
wp option update woocommerce_weight_unit "lbs"
wp option update woocommerce_dimension_unit "in"

# Create WooCommerce pages
echo "[4/6] Creating WooCommerce pages..."
wp wc tool run install_pages --user=1 2>/dev/null || echo "Pages may already exist"

# 5. Set permalink structure (required for WC REST API)
echo "[5/6] Setting permalink structure..."
wp rewrite structure '/%postname%/'
wp rewrite flush

# 6. Set timezone
echo "[6/6] Setting timezone..."
wp option update timezone_string "America/New_York"
wp option update date_format "F j, Y"
wp option update time_format "g:i a"

echo ""
echo "=== WooCommerce foundation installed ==="
echo "Next: Run wp-configure-categories.sh"
