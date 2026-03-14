#!/bin/bash
set -euo pipefail

# Boom Warehouse — Ohio Sales Tax Configuration
# Cuyahoga County: 5.75% (Ohio state) + 1.75% (county) = 7.5%

echo "=== Boom Warehouse: Tax Configuration ==="

# Enable taxes
wp option update woocommerce_calc_taxes "yes"
wp option update woocommerce_prices_include_tax "no"
wp option update woocommerce_tax_based_on "shipping"
wp option update woocommerce_shipping_tax_class ""
wp option update woocommerce_tax_round_at_subtotal "no"
wp option update woocommerce_tax_display_shop "excl"
wp option update woocommerce_tax_display_cart "excl"
wp option update woocommerce_price_display_suffix "+ tax"
wp option update woocommerce_tax_total_display "itemized"

# Insert Ohio / Cuyahoga County tax rate
# WooCommerce tax rates are stored in wp_woocommerce_tax_rates table
echo "Creating Ohio sales tax rate (7.5% — Cuyahoga County)..."

wp db query "
INSERT INTO $(wp db prefix)woocommerce_tax_rates 
  (tax_rate_country, tax_rate_state, tax_rate, tax_rate_name, tax_rate_priority, tax_rate_compound, tax_rate_shipping, tax_rate_order, tax_rate_class)
VALUES 
  ('US', 'OH', '7.5000', 'OH Sales Tax (Cuyahoga Co.)', 1, 0, 1, 1, '')
ON DUPLICATE KEY UPDATE tax_rate = '7.5000';
"

# Add tax rate postcode locations for Cuyahoga County area
TAX_RATE_ID=$(wp db query "SELECT tax_rate_id FROM $(wp db prefix)woocommerce_tax_rates WHERE tax_rate_state='OH' AND tax_rate_name LIKE '%Cuyahoga%' LIMIT 1" --skip-column-names 2>/dev/null || echo "")

if [ -n "$TAX_RATE_ID" ]; then
  echo "Tax rate created with ID: $TAX_RATE_ID"
  # Add postcode ranges for Cuyahoga County
  wp db query "
  INSERT IGNORE INTO $(wp db prefix)woocommerce_tax_rate_locations 
    (tax_rate_id, location_code, location_type)
  VALUES 
    ($TAX_RATE_ID, '44128', 'postcode'),
    ($TAX_RATE_ID, '44122', 'postcode'),
    ($TAX_RATE_ID, '44124', 'postcode'),
    ($TAX_RATE_ID, '44125', 'postcode'),
    ($TAX_RATE_ID, '44127', 'postcode'),
    ($TAX_RATE_ID, '44137', 'postcode'),
    ($TAX_RATE_ID, '44139', 'postcode');
  "
fi

echo ""
echo "=== Tax configuration complete ==="
echo "Rate: 7.5% (Ohio 5.75% + Cuyahoga County 1.75%)"
echo "Applied to: Shipping address, excludes from displayed prices"
echo ""
echo "VERIFY: WP Admin > WooCommerce > Settings > Tax > Standard rates"
echo "Next: Run wp-configure-stripe.sh"
