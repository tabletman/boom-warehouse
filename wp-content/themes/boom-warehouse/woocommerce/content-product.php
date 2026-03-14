<?php
/**
 * Product Card in Shop Loop
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

global $product;
if (!$product) return;

$condition = bw_get_product_condition($product);
$stock     = bw_get_stock_indicator($product);
$price     = (float) $product->get_price();
$location  = $product->get_meta('_bw_location') ?: 'Both Locations';
?>

<div <?php wc_product_class('bw-product-card', $product); ?>>
    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="bw-product-card__image">
        <?php if ($condition): ?>
            <div class="bw-product-card__badges">
                <span class="bw-badge <?php echo esc_attr(bw_condition_badge_class($condition)); ?>">
                    <?php echo esc_html($condition); ?>
                </span>
                <?php if ($product->is_on_sale()):
                    $savings = bw_get_savings_percentage(
                        (float) $product->get_regular_price(),
                        (float) $product->get_sale_price()
                    );
                    if ($savings > 0): ?>
                        <span class="bw-badge bw-badge--sale">Save <?php echo esc_html($savings); ?>%</span>
                    <?php endif;
                endif; ?>
            </div>
        <?php endif; ?>

        <?php echo $product->get_image('product-card'); ?>
    </a>

    <div class="bw-product-card__body">
        <h3 class="bw-product-card__title">
            <a href="<?php echo esc_url($product->get_permalink()); ?>">
                <?php echo esc_html($product->get_name()); ?>
            </a>
        </h3>

        <div class="bw-product-card__price">
            <?php echo $product->get_price_html(); ?>
        </div>

        <div class="<?php echo esc_attr($stock['class']); ?> bw-stock">
            <?php echo esc_html($stock['text']); ?>
        </div>

        <?php if ($price >= 50 && $price <= 5000): ?>
            <div class="bw-product-card__acima">
                As low as <strong>$<?php echo esc_html(bw_get_acima_monthly($price)); ?>/mo</strong> with Acima
            </div>
        <?php endif; ?>

        <div class="bw-product-card__location">
            <svg class="bw-location__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
            </svg>
            <?php echo esc_html($location); ?>
        </div>
    </div>
</div>
