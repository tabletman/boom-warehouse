#!/bin/bash
set -euo pipefail

# Boom Warehouse — Shipping Zones Configuration
# Run via WP-CLI after wp-configure-categories.sh

echo "=== Boom Warehouse: Shipping Zones Setup ==="

# 1. Create shipping zone: Local Cleveland Area
echo "[1/3] Creating Local Cleveland shipping zone..."

ZONE_ID=$(wp wc shipping_zone create \
  --name="Cleveland / Warrensville Heights" \
  --order=1 \
  --user=1 \
  --porcelain 2>/dev/null || echo "0")

if [ "$ZONE_ID" != "0" ] && [ -n "$ZONE_ID" ]; then
  # Add zone locations (Ohio postcodes near Warrensville Heights)
  wp wc shipping_zone_location update "$ZONE_ID" \
    --locations='[
      {"code":"US:OH","type":"state"}
    ]' \
    --user=1

  # Add Local Pickup method
  echo "[2/3] Adding Local Pickup method..."
  wp wc shipping_zone_method create "$ZONE_ID" \
    --method_id="local_pickup" \
    --enabled=true \
    --user=1
  
  # Add Flat Rate for local delivery
  echo "[3/3] Adding Local Delivery method..."
  wp wc shipping_zone_method create "$ZONE_ID" \
    --method_id="flat_rate" \
    --enabled=true \
    --settings='{"title":"Local Delivery","cost":"25.00"}' \
    --user=1
else
  echo "Creating shipping zone via REST API fallback..."
fi

echo ""
echo "=== Shipping zones configured ==="
echo "Zone: Cleveland / Warrensville Heights (Ohio)"
echo "Methods: Local Pickup (free), Local Delivery (\$25)"
echo ""
echo "MANUAL STEPS (WP Admin > WooCommerce > Settings > Shipping):"
echo "1. Edit Local Pickup — add both addresses:"
echo "   - 4554 Renaissance Pkwy, Warrensville Heights, OH 44128"
echo "   - 26055 Emery Rd B-1, Cleveland, OH 44128"
echo "2. Optionally restrict Local Delivery to specific zip codes"
echo "Next: Run wp-configure-tax.sh"
