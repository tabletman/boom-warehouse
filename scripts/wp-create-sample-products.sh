#!/bin/bash
set -euo pipefail

# Boom Warehouse — Create 10 Sample Products
# Run via WP-CLI after categories and attributes are set up

echo "=== Boom Warehouse: Creating Sample Products ==="

# Helper function to create a product
create_product() {
  local name="$1"
  local sku="$2"
  local regular="$3"
  local sale="$4"
  local desc="$5"
  local short="$6"
  local cat_slug="$7"
  local condition="$8"
  local stock="$9"
  local location="${10}"

  echo "Creating: $name..."

  local PRODUCT_ID
  PRODUCT_ID=$(wp wc product create \
    --name="$name" \
    --sku="$sku" \
    --regular_price="$regular" \
    --description="$desc" \
    --short_description="$short" \
    --manage_stock=true \
    --stock_quantity="$stock" \
    --status=publish \
    --user=1 \
    --porcelain 2>/dev/null)

  if [ -n "$sale" ] && [ "$sale" != "0" ]; then
    wp wc product update "$PRODUCT_ID" --sale_price="$sale" --user=1 2>/dev/null
  fi

  # Set condition attribute
  wp eval "
    \$p = wc_get_product($PRODUCT_ID);
    if (\$p) {
      \$p->set_attributes([
        'pa_condition' => (new WC_Product_Attribute())->set_id(wc_attribute_taxonomy_id_by_name('condition'))->set_name('pa_condition')->set_options(['$condition'])->set_visible(true)->set_variation(false)
      ]);
      \$p->save();
    }
  " 2>/dev/null || true

  # Set location meta
  wp post meta update "$PRODUCT_ID" _bw_location "$location" 2>/dev/null || true

  echo "  Created product #$PRODUCT_ID"
}

# Product 1: TV
create_product \
  "Samsung 55\" Crystal UHD 4K Smart TV" \
  "BW-TV-001" \
  "699.99" \
  "349.99" \
  "Experience stunning 4K resolution with Samsung's Crystal UHD technology. This 55-inch smart TV features HDR support, built-in streaming apps (Netflix, Hulu, Disney+), and a sleek design. Professionally tested and certified by Boom Warehouse." \
  "Refurbished Samsung 55\" 4K Smart TV — tested, cleaned, and ready for your living room." \
  "tvs-displays" \
  "Refurbished" \
  "8" \
  "Both Locations"

# Product 2: Laptop
create_product \
  "Dell Latitude 5520 Laptop — Intel i5, 16GB RAM, 256GB SSD" \
  "BW-PC-001" \
  "599.99" \
  "349.99" \
  "Powerful business laptop with Intel Core i5-1145G7 processor, 16GB DDR4 RAM, and 256GB NVMe SSD. 15.6\" Full HD display. Windows 11 Pro installed. Perfect for work or school. Tested and certified by Boom Warehouse." \
  "Refurbished Dell Latitude 5520 business laptop. Fast, reliable, and budget-friendly." \
  "computers-laptops" \
  "Refurbished" \
  "12" \
  "Renaissance Pkwy"

# Product 3: Washer
create_product \
  "LG 4.5 Cu Ft Front Load Washer — White" \
  "BW-AP-001" \
  "899.99" \
  "499.99" \
  "LG front-load washer with 4.5 cubic feet capacity. Features TurboWash technology, 6Motion wash, and SmartThinQ WiFi connectivity. Energy Star certified. Opened, inspected — never used. Full manufacturer warranty." \
  "Open box LG 4.5 cu ft front load washer. Unused, fully functional, with warranty." \
  "appliances" \
  "Open Box" \
  "3" \
  "Emery Rd"

# Product 4: Office Desk
create_product \
  "Adjustable Standing Desk — 48\" x 24\" Electric" \
  "BW-FR-001" \
  "299.99" \
  "0" \
  "Electric sit-stand desk with programmable height presets. 48\" x 24\" desktop with cable management tray. Steel frame supports up to 154 lbs. Smooth, quiet motor with anti-collision technology. New in box." \
  "Brand new 48\" electric standing desk with programmable height presets." \
  "furniture" \
  "New" \
  "15" \
  "Both Locations"

# Product 5: iPad
create_product \
  "Apple iPad 9th Gen 64GB WiFi — Space Gray" \
  "BW-SE-001" \
  "329.99" \
  "219.99" \
  "Apple iPad 9th generation with 10.2\" Retina display, A13 Bionic chip, and 64GB storage. WiFi model. Includes charger. iPadOS updated to latest version. Professionally tested — battery health 95%+." \
  "Refurbished iPad 9th Gen 64GB. Great condition, tested battery health 95%+." \
  "small-electronics" \
  "Refurbished" \
  "6" \
  "Renaissance Pkwy"

# Product 6: Microwave
create_product \
  "Panasonic Inverter Microwave — 1.3 Cu Ft, 1100W" \
  "BW-HH-001" \
  "149.99" \
  "89.99" \
  "Panasonic inverter microwave oven with 1.3 cubic feet capacity and 1100 watts of power. Inverter technology delivers consistent, even cooking. Includes turntable, sensor cooking, and 10 power levels." \
  "Refurbished Panasonic 1100W inverter microwave. Cooks evenly, works perfectly." \
  "household-goods" \
  "Refurbished" \
  "20" \
  "Both Locations"

# Product 7: TV (budget)
create_product \
  "Vizio 32\" D-Series HD Smart TV" \
  "BW-TV-002" \
  "199.99" \
  "99.99" \
  "Compact 32-inch Vizio smart TV with built-in Chromecast, Apple AirPlay, and SmartCast. HD resolution — perfect for bedrooms, kitchens, or dorms. Tested and fully functional." \
  "Refurbished Vizio 32\" Smart TV. Great for small rooms. Streaming apps built in." \
  "tvs-displays" \
  "Refurbished" \
  "5" \
  "Both Locations"

# Product 8: Chromebook
create_product \
  "HP Chromebook 14 — Intel Celeron, 4GB RAM, 32GB eMMC" \
  "BW-PC-002" \
  "249.99" \
  "129.99" \
  "Lightweight HP Chromebook 14 with Intel Celeron N4020, 4GB RAM, and 32GB eMMC storage. 14\" HD display. Chrome OS auto-updates. Ideal for browsing, email, and school. Battery lasts up to 10 hours." \
  "Refurbished HP Chromebook 14. Fast boot, long battery life. Perfect for students." \
  "computers-laptops" \
  "Refurbished" \
  "18" \
  "Both Locations"

# Product 9: Dryer (new)
create_product \
  "Samsung 7.4 Cu Ft Electric Dryer with Sensor Dry" \
  "BW-AP-002" \
  "799.99" \
  "599.99" \
  "Samsung electric dryer with 7.4 cubic feet capacity. Sensor Dry technology detects moisture levels and stops automatically. 12 preset drying cycles. Wrinkle Prevent option. New — factory sealed with full warranty." \
  "New Samsung 7.4 cu ft electric dryer. Factory sealed. Full warranty included." \
  "appliances" \
  "New" \
  "2" \
  "Renaissance Pkwy"

# Product 10: Bluetooth Speaker
create_product \
  "JBL Charge 5 Portable Bluetooth Speaker — Black" \
  "BW-SE-002" \
  "179.99" \
  "109.99" \
  "JBL Charge 5 with powerful JBL Pro Sound, deep bass, and IP67 waterproof rating. 20 hours of playtime. Built-in power bank to charge your devices. Open box — includes original packaging and USB-C cable." \
  "Open box JBL Charge 5 Bluetooth speaker. 20hr battery, waterproof, powerful bass." \
  "small-electronics" \
  "Open Box" \
  "7" \
  "Emery Rd"

echo ""
echo "=== 10 sample products created ==="
echo "Visit WP Admin > Products to review and add images."
