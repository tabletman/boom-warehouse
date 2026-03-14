<?php
/**
 * WooCommerce Hook Customizations
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

// --------------------------------------------------------------------------
// Remove default WooCommerce wrappers, use our own
// --------------------------------------------------------------------------
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', function () {
    echo '<main class="bw-main"><div class="bw-container">';
}, 10);

add_action('woocommerce_after_main_content', function () {
    echo '</div></main>';
}, 10);

// --------------------------------------------------------------------------
// Remove default sidebar, we use our own
// --------------------------------------------------------------------------
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// --------------------------------------------------------------------------
// Product Loop: Add condition badge
// --------------------------------------------------------------------------
add_action('woocommerce_before_shop_loop_item_title', function () {
    global $product;
    $condition = bw_get_product_condition($product);
    if ($condition) {
        echo '<div class="bw-product-card__badges">';
        echo '<span class="bw-badge ' . esc_attr(bw_condition_badge_class($condition)) . '">';
        echo esc_html($condition);
        echo '</span>';

        if ($product->is_on_sale()) {
            $savings = bw_get_savings_percentage(
                (float) $product->get_regular_price(),
                (float) $product->get_sale_price()
            );
            if ($savings > 0) {
                echo '<span class="bw-badge bw-badge--sale">Save ' . esc_html($savings) . '%</span>';
            }
        }

        echo '</div>';
    }
}, 15);

// --------------------------------------------------------------------------
// Product Loop: Add stock indicator
// --------------------------------------------------------------------------
add_action('woocommerce_after_shop_loop_item_title', function () {
    global $product;
    $stock = bw_get_stock_indicator($product);
    echo '<div class="' . esc_attr($stock['class']) . ' bw-stock">' . esc_html($stock['text']) . '</div>';
}, 15);

// --------------------------------------------------------------------------
// Product Loop: Add Acima CTA
// --------------------------------------------------------------------------
add_action('woocommerce_after_shop_loop_item_title', function () {
    global $product;
    $price = (float) $product->get_price();
    if ($price >= 50 && $price <= 5000) {
        $monthly = bw_get_acima_monthly($price);
        echo '<div class="bw-product-card__acima">';
        echo 'As low as <strong>$' . esc_html($monthly) . '/mo</strong> with Acima';
        echo '</div>';
    }
}, 20);

// --------------------------------------------------------------------------
// Product Loop: Add location display
// --------------------------------------------------------------------------
add_action('woocommerce_after_shop_loop_item_title', function () {
    global $product;
    $location = $product->get_meta('_bw_location');
    if (!$location) $location = 'Both Locations';

    echo '<div class="bw-product-card__location">';
    echo '<svg class="bw-location__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
    echo '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>';
    echo '</svg>';
    echo esc_html($location);
    echo '</div>';
}, 25);

// --------------------------------------------------------------------------
// Single Product: Add condition badge + stock
// --------------------------------------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    global $product;

    echo '<div class="bw-single-product__meta">';

    $condition = bw_get_product_condition($product);
    if ($condition) {
        echo '<span class="bw-badge ' . esc_attr(bw_condition_badge_class($condition)) . '">';
        echo esc_html($condition);
        echo '</span>';
    }

    $stock = bw_get_stock_indicator($product);
    echo '<span class="' . esc_attr($stock['class']) . ' bw-stock">' . esc_html($stock['text']) . '</span>';

    echo '</div>';
}, 7);

// --------------------------------------------------------------------------
// Single Product: SKU display
// --------------------------------------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    global $product;
    if ($product->get_sku()) {
        echo '<div class="bw-single-product__sku">SKU: ' . esc_html($product->get_sku()) . '</div>';
    }
}, 6);

// --------------------------------------------------------------------------
// Single Product: Add Acima CTA
// --------------------------------------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    global $product;
    $price = (float) $product->get_price();
    if ($price >= 50 && $price <= 5000) {
        $monthly = bw_get_acima_monthly($price);
        get_template_part('template-parts/acima-cta', null, [
            'monthly' => $monthly,
            'price'   => $price,
        ]);
    }
}, 25);

// --------------------------------------------------------------------------
// Single Product: Location availability
// --------------------------------------------------------------------------
add_action('woocommerce_single_product_summary', function () {
    global $product;
    $location = $product->get_meta('_bw_location');
    if (!$location) $location = 'Both Locations';

    echo '<div class="bw-location bw-location--available">';
    echo '<svg class="bw-location__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">';
    echo '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>';
    echo '</svg>';
    echo 'Available at: <strong>' . esc_html($location) . '</strong>';
    echo '</div>';
}, 35);

// --------------------------------------------------------------------------
// Single Product: Savings tag on price
// --------------------------------------------------------------------------
add_filter('woocommerce_get_price_html', function ($price_html, $product) {
    if (!is_product() || !$product->is_on_sale()) return $price_html;

    $savings = bw_get_savings_percentage(
        (float) $product->get_regular_price(),
        (float) $product->get_sale_price()
    );

    if ($savings > 0) {
        $price_html .= ' <span class="bw-savings-tag">Save ' . esc_html($savings) . '%</span>';
    }

    return $price_html;
}, 10, 2);

// --------------------------------------------------------------------------
// Products per page
// --------------------------------------------------------------------------
add_filter('loop_shop_per_page', function () {
    return 24;
});

// --------------------------------------------------------------------------
// Add product location meta box in admin
// --------------------------------------------------------------------------
add_action('woocommerce_product_options_general_product_data', function () {
    woocommerce_wp_select([
        'id'      => '_bw_location',
        'label'   => __('Store Location', 'boom-warehouse'),
        'options' => [
            ''                => __('Both Locations', 'boom-warehouse'),
            'Renaissance Pkwy' => __('Renaissance Pkwy Only', 'boom-warehouse'),
            'Emery Rd'         => __('Emery Rd Only', 'boom-warehouse'),
            'Both Locations'   => __('Both Locations', 'boom-warehouse'),
        ],
        'desc_tip' => true,
        'description' => __('Which store location has this product in stock.', 'boom-warehouse'),
    ]);
});

add_action('woocommerce_process_product_meta', function ($post_id) {
    if (isset($_POST['_bw_location'])) {
        update_post_meta($post_id, '_bw_location', sanitize_text_field($_POST['_bw_location']));
    }
});

// --------------------------------------------------------------------------
// Change "Add to cart" button text
// --------------------------------------------------------------------------
add_filter('woocommerce_product_single_add_to_cart_text', function () {
    return __('Add to Cart', 'boom-warehouse');
});

add_filter('woocommerce_product_add_to_cart_text', function () {
    return __('Add to Cart', 'boom-warehouse');
});
