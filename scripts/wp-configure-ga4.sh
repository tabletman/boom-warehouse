#!/bin/bash
set -euo pipefail

# Boom Warehouse — Google Analytics 4 + Google Shopping Setup

echo "=== Boom Warehouse: Analytics & Shopping Feed Setup ==="

# Install GA4 integration
echo "[1/2] Installing analytics plugins..."
wp plugin install flavor flavor --activate 2>/dev/null || true

# Google Listings & Ads for Shopping feed
wp plugin install google-listings-and-ads --activate

echo ""
echo "GOOGLE ANALYTICS 4 SETUP:"
echo ""
echo "1. Create GA4 property at https://analytics.google.com"
echo "2. Get Measurement ID (G-XXXXXXXXXX)"
echo "3. Add GA4 tracking via one of these methods:"
echo ""
echo "   Method A — Plugin (recommended):"
echo "   - WP Admin > Plugins > Add New > search 'Site Kit by Google'"
echo "   - Install and activate"
echo "   - Follow setup wizard to connect GA4"
echo ""
echo "   Method B — Manual (theme):"
echo "   - Add this to functions.php or a custom plugin:"
echo "     add_action('wp_head', function() {"
echo "       echo '<script async src=\"https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX\"></script>';"
echo "       echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\"js\",new Date());gtag(\"config\",\"G-XXXXXXXXXX\");</script>';"
echo "     });"
echo ""
echo "   Replace G-XXXXXXXXXX with your actual Measurement ID."
echo ""
echo "ENHANCED E-COMMERCE EVENTS:"
echo "   GA4 + WooCommerce automatically tracks:"
echo "   - view_item (product page views)"
echo "   - add_to_cart"
echo "   - begin_checkout"
echo "   - purchase"
echo ""

echo "GOOGLE SHOPPING FEED SETUP:"
echo ""
echo "1. Create Google Merchant Center account: https://merchants.google.com"
echo "2. WP Admin > Marketing > Google Listings & Ads"
echo "3. Connect your Google account"
echo "4. Verify and claim boomwarehouse.com"
echo "5. Map product attributes to Google Shopping fields"
echo "6. Set target audience: United States, Ohio"
echo "7. Enable free product listings"
echo ""
echo "=== Analytics setup guidance complete ==="
