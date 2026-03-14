#!/bin/bash
set -euo pipefail

# Boom Warehouse — ATUM Inventory Management Configuration
# Requires: ATUM Inventory Management for WooCommerce plugin

echo "=== Boom Warehouse: Inventory Management Setup ==="

# 1. Install ATUM
echo "[1/4] Installing ATUM Inventory Management..."
wp plugin install atum-stock-manager-for-woocommerce --activate

# 2. Configure ATUM settings
echo "[2/4] Configuring ATUM settings..."
wp option update atum_settings '{
  "enable_ajax_filter": "yes",
  "enhanced_suppliers_support": "yes",
  "show_totals": "yes",
  "enable_admin_bar_menu": "yes",
  "stock_quantity_decimals": 0,
  "out_stock_threshold": 0,
  "unmanaged_counters": "yes",
  "stock_negatives": "no"
}' --format=json 2>/dev/null || echo "  Set ATUM options manually"

# 3. Configure low stock notification thresholds
echo "[3/4] Setting reorder points..."
cat << 'EOF'
REORDER POINTS (set per product in ATUM Stock Central):
  - Electronics (TVs, Computers, Small Electronics): 3 units
  - Appliances: 2 units
  - Accessories / Household Goods: 5 units
  - Furniture: 2 units

To set in bulk:
  WP Admin > ATUM Inventory > Stock Central
  Select products > Bulk Actions > Set Reorder Point
EOF

# 4. Multi-location setup info
echo ""
echo "[4/4] Multi-Location Inventory..."
cat << 'EOF'

MULTI-LOCATION SETUP:
ATUM Multi-Inventory add-on is required for true multi-location management.
Alternative: Use the built-in WooCommerce product meta (_bw_location) that our 
theme already supports.

LOCATIONS TO CREATE (in ATUM > Settings > Multi-Inventory):
  1. Name: Renaissance Pkwy
     Address: 4554 Renaissance Pkwy, Warrensville Heights, OH 44128
     Primary: Yes
  
  2. Name: Emery Rd
     Address: 26055 Emery Rd B-1, Cleveland, OH 44128
     Primary: No

BARCODE SCANNING WORKFLOW:
  1. Install ATUM barcode scanner app (iOS/Android) or use browser-based scanner
  2. Assign SKU/barcode to each product during intake
  3. Scan items to:
     - Add to inventory (receive shipment)
     - Transfer between locations
     - Pick for order fulfillment
  
  Our product SKU convention: BW-{CATEGORY}-{NUMBER}
    TV: BW-TV-XXX
    PC: BW-PC-XXX
    AP: BW-AP-XXX (appliances)
    FR: BW-FR-XXX (furniture)
    SE: BW-SE-XXX (small electronics)
    HH: BW-HH-XXX (household)

STOCK TRANSFER WORKFLOW:
  1. ATUM > Stock Central > select product
  2. Transfer Stock > From Location > To Location > Quantity
  3. Transfer is logged with timestamp and user
  4. Stock levels update on storefront automatically

EOF

echo "=== Inventory management configured ==="
echo "Review: WP Admin > ATUM Inventory > Stock Central"
