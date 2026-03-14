#!/bin/bash
set -euo pipefail

# Boom Warehouse — Product Categories & Attributes
# Run via WP-CLI after wp-install-woocommerce.sh

echo "=== Boom Warehouse: Categories & Attributes Setup ==="

# 1. Create product categories
echo "[1/3] Creating product categories..."

wp wc product_cat create --name="TVs & Displays" --slug="tvs-displays" \
  --description="Samsung, LG, Vizio — new, refurbished, and open box televisions and monitors" \
  --user=1

wp wc product_cat create --name="Computers & Laptops" --slug="computers-laptops" \
  --description="Dell, HP, Lenovo — refurbished desktops, laptops, and Chromebooks" \
  --user=1

wp wc product_cat create --name="Appliances" --slug="appliances" \
  --description="Washers, dryers, refrigerators, microwaves, and more" \
  --user=1

wp wc product_cat create --name="Furniture" --slug="furniture" \
  --description="Desks, chairs, shelving, mattresses, and home furnishings" \
  --user=1

wp wc product_cat create --name="Small Electronics" --slug="small-electronics" \
  --description="Tablets, headphones, speakers, smart home devices, and accessories" \
  --user=1

wp wc product_cat create --name="Household Goods" --slug="household-goods" \
  --description="Kitchen, bathroom, cleaning, and storage essentials" \
  --user=1

# 2. Create product attribute: Condition
echo "[2/3] Creating Condition attribute..."

wp wc product_attribute create \
  --name="Condition" \
  --slug="condition" \
  --type="select" \
  --order_by="menu_order" \
  --has_archives=true \
  --user=1

# Add attribute terms
echo "[3/3] Adding Condition terms..."

# Get the attribute ID (taxonomy is pa_condition)
wp term create pa_condition "New" --slug="new" \
  --description="Factory sealed, full manufacturer warranty" 2>/dev/null || echo "Term 'New' may already exist"

wp term create pa_condition "Refurbished" --slug="refurbished" \
  --description="Professionally tested, cleaned, and restored. Limited warranty included." 2>/dev/null || echo "Term 'Refurbished' may already exist"

wp term create pa_condition "Open Box" --slug="open-box" \
  --description="Opened or returned item in original packaging. Fully functional." 2>/dev/null || echo "Term 'Open Box' may already exist"

echo ""
echo "=== Categories and attributes configured ==="
echo "Categories: TVs & Displays, Computers & Laptops, Appliances, Furniture, Small Electronics, Household Goods"
echo "Attribute: Condition (New / Refurbished / Open Box)"
echo "Next: Run wp-configure-shipping.sh"
