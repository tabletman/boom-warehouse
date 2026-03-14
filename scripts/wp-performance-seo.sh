#!/bin/bash
set -euo pipefail

# Boom Warehouse — Performance & SEO Optimization

echo "=== Boom Warehouse: Performance & SEO ==="

# 1. Caching plugin
echo "[1/5] Installing caching plugin..."
wp plugin install litespeed-cache --activate 2>/dev/null || {
  echo "  LiteSpeed Cache not compatible — trying WP Super Cache..."
  wp plugin install wp-super-cache --activate 2>/dev/null || echo "  Install caching plugin manually"
}

# 2. Image optimization
echo "[2/5] Installing image optimization..."
wp plugin install imagify --activate 2>/dev/null || {
  echo "  Imagify not available — trying ShortPixel..."
  wp plugin install shortpixel-image-optimiser --activate 2>/dev/null || echo "  Install image optimizer manually"
}

# 3. Lazy loading (native in WP 5.5+, but ensure enabled)
echo "[3/5] Enabling lazy loading..."
wp option update wp_lazy_loading_enabled 1 2>/dev/null || true

# 4. Yoast SEO configuration
echo "[4/5] Configuring Yoast SEO..."

# Set SEO title templates
wp option update wpseo_titles '{
  "title-home-wpseo": "Boom Warehouse — Refurbished Electronics & Appliances | Cleveland, OH",
  "metadesc-home-wpseo": "Save 30-60% on quality refurbished TVs, laptops, appliances, and more at Boom Warehouse. Two Cleveland locations. Acima financing available — no credit needed.",
  "title-product": "%%title%% — %%primary_category%% | Boom Warehouse",
  "metadesc-product": "%%excerpt%% Shop at Boom Warehouse Cleveland. Acima lease-to-own financing available.",
  "title-product_cat": "%%term_title%% — Buy Refurbished | Boom Warehouse",
  "metadesc-product_cat": "Shop quality refurbished and open box %%term_title%% at Boom Warehouse Cleveland. Save 30-60% off retail. Acima financing available.",
  "title-post": "%%title%% | Boom Warehouse",
  "title-page": "%%title%% | Boom Warehouse"
}' --format=json 2>/dev/null || echo "  Configure Yoast SEO titles manually"

# 5. Sitemap
echo "[5/5] Enabling XML Sitemap..."
wp option update wpseo '{
  "enable_xml_sitemap": true,
  "enablexmlsitemap": true
}' --format=json 2>/dev/null || echo "  Enable sitemap in Yoast SEO settings"

echo ""
echo "ROBOTS.TXT CONTENT (create at site root or via Yoast):"
echo "---"
cat << 'EOF'
User-agent: *
Allow: /
Disallow: /wp-admin/
Disallow: /cart/
Disallow: /checkout/
Disallow: /my-account/
Disallow: /?s=
Disallow: /search/

Sitemap: https://boomwarehouse.com/sitemap_index.xml
EOF
echo "---"

echo ""
echo "PERFORMANCE CHECKLIST:"
echo "  [ ] Enable Cloudflare CDN caching (done if DNS setup complete)"
echo "  [ ] Enable browser caching (Cloudflare handles this)"
echo "  [ ] Minify CSS/JS (Cloudflare auto-minify or caching plugin)"
echo "  [ ] Optimize images (Imagify or ShortPixel — run after product photos uploaded)"
echo "  [ ] Enable lazy loading for images (built into WP)"
echo "  [ ] Test with: https://pagespeed.web.dev/ — target score > 80 mobile"
echo "  [ ] Test with: https://www.webpagetest.org/ — target LCP < 2.5s"
echo ""
echo "SEO CHECKLIST:"
echo "  [ ] All products have meta descriptions (Yoast green light)"
echo "  [ ] JSON-LD structured data on product pages (handled by theme)"
echo "  [ ] XML sitemap submitted to Google Search Console"
echo "  [ ] robots.txt configured"
echo "  [ ] Open Graph tags for social sharing (Yoast handles this)"
echo "  [ ] Canonical URLs set (Yoast handles this)"
echo "  [ ] 301 redirects for any old URLs"
echo ""
echo "=== Performance & SEO configuration complete ==="
