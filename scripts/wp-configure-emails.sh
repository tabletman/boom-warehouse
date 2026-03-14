#!/bin/bash
set -euo pipefail

# Boom Warehouse — Transactional Email Configuration

echo "=== Boom Warehouse: Email Configuration ==="

# Set WooCommerce email sender
wp option update woocommerce_email_from_name "Boom Warehouse"
wp option update woocommerce_email_from_address "shop@boomwarehouse.com"

# Email template colors (matches brand)
wp option update woocommerce_email_header_image "" # Can set logo URL later
wp option update woocommerce_email_base_color "#1B3A5C"
wp option update woocommerce_email_background_color "#F5F5F0"
wp option update woocommerce_email_body_background_color "#ffffff"
wp option update woocommerce_email_text_color "#2D2D2D"
wp option update woocommerce_email_footer_text "Boom Warehouse — Cleveland's source for quality refurbished electronics and appliances."

echo ""
echo "WooCommerce sends these transactional emails automatically:"
echo "  ✓ New order (to admin)"
echo "  ✓ Order on-hold"
echo "  ✓ Processing order (to customer)"
echo "  ✓ Completed order (to customer)"
echo "  ✓ Refunded order (to customer)"
echo "  ✓ Customer note"
echo "  ✓ Password reset"
echo "  ✓ New account"
echo ""
echo "SMTP CONFIGURATION:"
echo "  Install WP Mail SMTP plugin for reliable delivery:"
echo "  wp plugin install wp-mail-smtp --activate"
echo ""
echo "  Configure with Hostinger SMTP:"
echo "    Host: smtp.hostinger.com"
echo "    Port: 465 (SSL)"
echo "    Username: shop@boomwarehouse.com"
echo "    Password: (email account password)"
echo ""
echo "  Or use SendGrid free tier (100 emails/day):"
echo "    Get API key at https://sendgrid.com"
echo ""
echo "N8N WEBHOOK SETUP (for custom notifications):"
echo "  WP Admin > WooCommerce > Settings > Advanced > Webhooks"
echo ""
echo "  Create these webhooks:"
echo "  1. Name: New Order Notification"
echo "     Status: Active"
echo "     Topic: Order created"
echo "     Delivery URL: https://n8n.boomwarehouse.com/webhook/wc-new-order"
echo ""
echo "  2. Name: Stock Updated"
echo "     Status: Active"
echo "     Topic: Product updated"
echo "     Delivery URL: https://n8n.boomwarehouse.com/webhook/wc-product-updated"
echo ""
echo "=== Email configuration complete ==="
