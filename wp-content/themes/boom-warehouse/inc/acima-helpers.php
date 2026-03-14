<?php
/**
 * Acima Lease-to-Own Helper Functions
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

function bw_is_acima_eligible($product) {
    if (!$product) return false;
    $price = (float) $product->get_price();
    return $price >= 50 && $price <= 5000 && $product->is_in_stock();
}

function bw_acima_monthly_estimate($price, $term_months = 12) {
    if ($price <= 0 || $term_months <= 0) return 0;
    return ceil($price / $term_months);
}

function bw_acima_prequalify_url() {
    return 'https://www.acima.com/prequalify';
}

/**
 * Display Acima badge in checkout if the Acima plugin isn't handling it
 */
add_action('woocommerce_review_order_before_payment', function () {
    $total = (float) WC()->cart->get_total('edit');
    if ($total < 50 || $total > 5000) return;

    $monthly = bw_acima_monthly_estimate($total);
    ?>
    <div class="bw-acima-checkout-notice">
        <p>
            <strong>Lease-to-own available!</strong>
            As low as <strong>$<?php echo esc_html($monthly); ?>/mo</strong> with Acima.
            No credit needed — instant approval decision.
        </p>
    </div>
    <?php
});
