<?php
/**
 * Boom Warehouse Theme Functions
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

define('BW_VERSION', '1.0.0');
define('BW_DIR', get_template_directory());
define('BW_URI', get_template_directory_uri());

// --------------------------------------------------------------------------
// Theme Setup
// --------------------------------------------------------------------------
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo', ['width' => 300, 'height' => 80, 'flex-width' => true]);

    register_nav_menus([
        'primary'   => __('Primary Navigation', 'boom-warehouse'),
        'footer'    => __('Footer Navigation', 'boom-warehouse'),
        'mobile'    => __('Mobile Navigation', 'boom-warehouse'),
    ]);

    add_image_size('product-card', 400, 400, true);
    add_image_size('product-hero', 800, 800, false);
});

// --------------------------------------------------------------------------
// Enqueue Assets
// --------------------------------------------------------------------------
add_action('wp_enqueue_scripts', function () {
    // Google Fonts: Oswald + Inter
    wp_enqueue_style(
        'bw-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@400;500;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style('bw-style', get_stylesheet_uri(), ['bw-google-fonts'], BW_VERSION);
    wp_enqueue_script('bw-main', BW_URI . '/assets/js/main.js', [], BW_VERSION, true);

    wp_localize_script('bw-main', 'bwData', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('bw_nonce'),
    ]);
});

// --------------------------------------------------------------------------
// Security Hardening
// --------------------------------------------------------------------------
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
add_filter('the_generator', '__return_empty_string');

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// --------------------------------------------------------------------------
// WooCommerce Hooks
// --------------------------------------------------------------------------
require_once BW_DIR . '/inc/wc-hooks.php';
require_once BW_DIR . '/inc/acima-helpers.php';

// --------------------------------------------------------------------------
// Custom Product Attribute Helpers
// --------------------------------------------------------------------------
function bw_get_product_condition($product) {
    if (!$product) return '';
    $condition = $product->get_attribute('pa_condition');
    if (!$condition) {
        $condition = $product->get_attribute('condition');
    }
    return $condition;
}

function bw_condition_badge_class($condition) {
    $condition = strtolower(trim($condition));
    $map = [
        'new'         => 'bw-badge--new',
        'refurbished' => 'bw-badge--refurbished',
        'open box'    => 'bw-badge--open-box',
        'open-box'    => 'bw-badge--open-box',
    ];
    return $map[$condition] ?? 'bw-badge--refurbished';
}

function bw_get_stock_indicator($product) {
    if (!$product->is_in_stock()) {
        return ['class' => 'bw-stock--out', 'text' => __('Out of Stock', 'boom-warehouse')];
    }
    $qty = $product->get_stock_quantity();
    if ($qty !== null && $qty <= 3) {
        return [
            'class' => 'bw-stock--low',
            'text'  => sprintf(__('Low Stock — Only %d left', 'boom-warehouse'), $qty),
        ];
    }
    return ['class' => 'bw-stock--in', 'text' => __('In Stock', 'boom-warehouse')];
}

function bw_get_acima_monthly($price) {
    if ($price <= 0) return 0;
    return ceil($price / 12);
}

function bw_get_savings_percentage($regular, $sale) {
    if (!$regular || !$sale || $regular <= $sale) return 0;
    return round((($regular - $sale) / $regular) * 100);
}

// --------------------------------------------------------------------------
// Widget Areas
// --------------------------------------------------------------------------
add_action('widgets_init', function () {
    register_sidebar([
        'name'          => __('Shop Sidebar', 'boom-warehouse'),
        'id'            => 'shop-sidebar',
        'description'   => __('Sidebar for product archive pages', 'boom-warehouse'),
        'before_widget' => '<div class="bw-filter-group">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="bw-filter-group__title">',
        'after_title'   => '</h3>',
    ]);

    register_sidebar([
        'name'          => __('Footer Widgets', 'boom-warehouse'),
        'id'            => 'footer-widgets',
        'before_widget' => '<div class="bw-footer__widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ]);
});

// --------------------------------------------------------------------------
// JSON-LD Structured Data Enhancement
// --------------------------------------------------------------------------
add_action('wp_head', function () {
    if (!is_product()) return;

    global $product;
    if (!$product) return;

    $condition_val = bw_get_product_condition($product);
    $condition_map = [
        'new'         => 'https://schema.org/NewCondition',
        'refurbished' => 'https://schema.org/RefurbishedCondition',
        'open box'    => 'https://schema.org/UsedCondition',
        'open-box'    => 'https://schema.org/UsedCondition',
    ];

    $schema_condition = $condition_map[strtolower(trim($condition_val))] ?? 'https://schema.org/UsedCondition';

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $product->get_name(),
        'description' => wp_strip_all_tags($product->get_short_description()),
        'sku'         => $product->get_sku(),
        'image'       => wp_get_attachment_url($product->get_image_id()),
        'brand'       => [
            '@type' => 'Brand',
            'name'  => 'Boom Warehouse',
        ],
        'offers'      => [
            '@type'           => 'Offer',
            'url'             => get_permalink(),
            'priceCurrency'   => 'USD',
            'price'           => $product->get_price(),
            'availability'    => $product->is_in_stock()
                ? 'https://schema.org/InStock'
                : 'https://schema.org/OutOfStock',
            'itemCondition'   => $schema_condition,
            'seller'          => [
                '@type' => 'Organization',
                'name'  => 'Boom Warehouse',
            ],
        ],
    ];

    if ($product->get_sale_price()) {
        $schema['offers']['priceValidUntil'] = date('Y-12-31');
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>' . "\n";
});
