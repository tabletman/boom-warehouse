#!/bin/bash
set -uo pipefail

# Boom Warehouse — Add Product Images
# Downloads free product images and attaches to WooCommerce products

cd ~/domains/boomwarehouse.com/public_html 2>/dev/null || cd ~/public_html 2>/dev/null || true

echo "=== Adding Product Images ==="

attach_image() {
  local SKU="$1"
  local URL="$2"
  local ALT="$3"

  PRODUCT_ID=$(wp db query "SELECT post_id FROM $(wp db prefix)postmeta WHERE meta_key='_sku' AND meta_value='$SKU' LIMIT 1" --skip-column-names 2>/dev/null | tr -d '[:space:]')

  if [ -z "$PRODUCT_ID" ]; then
    echo "  SKIP: Product $SKU not found"
    return
  fi

  echo "  Downloading image for $SKU (product #$PRODUCT_ID)..."
  ATTACH_ID=$(wp media import "$URL" --title="$ALT" --alt="$ALT" --post_id="$PRODUCT_ID" --porcelain 2>/dev/null)

  if [ -n "$ATTACH_ID" ]; then
    wp post meta update "$PRODUCT_ID" _thumbnail_id "$ATTACH_ID" 2>/dev/null
    echo "  OK: $ALT (attachment #$ATTACH_ID)"
  else
    echo "  FAIL: Could not download image for $SKU"
  fi
}

# Samsung 55" 4K TV
attach_image "BW-TV-001" \
  "https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=800&h=800&fit=crop" \
  "Samsung 55 inch Crystal UHD 4K Smart TV"

# Dell Latitude 5520
attach_image "BW-PC-001" \
  "https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=800&h=800&fit=crop" \
  "Dell Latitude 5520 Laptop"

# LG Front Load Washer
attach_image "BW-AP-001" \
  "https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?w=800&h=800&fit=crop" \
  "LG Front Load Washer White"

# Standing Desk
attach_image "BW-FR-001" \
  "https://images.unsplash.com/photo-1595515106969-1ce29566ff1c?w=800&h=800&fit=crop" \
  "Adjustable Electric Standing Desk"

# Apple iPad 9th Gen
attach_image "BW-SE-001" \
  "https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=800&h=800&fit=crop" \
  "Apple iPad 9th Generation Space Gray"

# Panasonic Microwave
attach_image "BW-HH-001" \
  "https://images.unsplash.com/photo-1585659722983-3a675dabf23d?w=800&h=800&fit=crop" \
  "Panasonic Inverter Microwave"

# Vizio 32" TV
attach_image "BW-TV-002" \
  "https://images.unsplash.com/photo-1461151304267-38535e780c79?w=800&h=800&fit=crop" \
  "Vizio 32 inch D-Series Smart TV"

# HP Chromebook 14
attach_image "BW-PC-002" \
  "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=800&h=800&fit=crop" \
  "HP Chromebook 14 Laptop"

# Samsung Dryer
attach_image "BW-AP-002" \
  "https://images.unsplash.com/photo-1610557892470-55d9e80c0eb2?w=800&h=800&fit=crop" \
  "Samsung Electric Dryer White"

# JBL Charge 5
attach_image "BW-SE-002" \
  "https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=800&h=800&fit=crop" \
  "JBL Charge 5 Bluetooth Speaker Black"

echo ""
echo "=== Done! Refresh the site to see images. ==="
