<?php
/**
 * Featured Products Section — Homepage
 *
 * @package BoomWarehouse
 */

$featured = wc_get_products([
    'featured' => true,
    'limit'    => 8,
    'status'   => 'publish',
    'orderby'  => 'date',
    'order'    => 'DESC',
]);

if (empty($featured)) {
    $featured = wc_get_products([
        'limit'   => 8,
        'status'  => 'publish',
        'orderby' => 'date',
        'order'   => 'DESC',
    ]);
}

if (empty($featured)) return;
?>

<section class="bw-featured" style="padding: 2.5rem 0;">
    <div class="bw-container">
        <div class="bw-section-heading">
            <h2>Featured Deals</h2>
        </div>

        <div class="bw-products-grid">
            <?php foreach ($featured as $product):
                setup_postdata($product->get_id());
                $condition = bw_get_product_condition($product);
                $stock = bw_get_stock_indicator($product);
                $price = (float) $product->get_price();
                $image = wp_get_attachment_image_src($product->get_image_id(), 'product-card');
            ?>
                <div class="bw-product-card">
                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="bw-product-card__image">
                        <?php if ($condition): ?>
                            <div class="bw-product-card__badges">
                                <span class="bw-badge <?php echo esc_attr(bw_condition_badge_class($condition)); ?>">
                                    <?php echo esc_html($condition); ?>
                                </span>
                                <?php if ($product->is_on_sale()):
                                    $savings = bw_get_savings_percentage((float) $product->get_regular_price(), (float) $product->get_sale_price());
                                    if ($savings > 0): ?>
                                        <span class="bw-badge bw-badge--sale">Save <?php echo esc_html($savings); ?>%</span>
                                    <?php endif;
                                endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($image): ?>
                            <img src="<?php echo esc_url($image[0]); ?>"
                                 alt="<?php echo esc_attr($product->get_name()); ?>"
                                 width="400" height="400" loading="lazy">
                        <?php else: ?>
                            <img src="<?php echo esc_url(wc_placeholder_img_src('product-card')); ?>"
                                 alt="<?php echo esc_attr($product->get_name()); ?>"
                                 width="400" height="400" loading="lazy">
                        <?php endif; ?>
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
                    </div>
                </div>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <div class="bw-text-center bw-mt-3">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bw-btn bw-btn--navy">
                View All Products
            </a>
        </div>
    </div>
</section>
