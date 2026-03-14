<?php
/**
 * Single Product Page
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="bw-main bw-single-product">
    <div class="bw-container">
        <?php woocommerce_breadcrumb(); ?>

        <?php while (have_posts()): the_post(); ?>
            <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
                <div class="bw-single-product__layout">
                    <!-- Gallery -->
                    <div class="bw-single-product__gallery">
                        <?php woocommerce_show_product_images(); ?>
                    </div>

                    <!-- Product Info -->
                    <div class="bw-single-product__info">
                        <?php woocommerce_template_single_title(); ?>

                        <?php
                        /**
                         * Hook: woocommerce_single_product_summary
                         * Our custom hooks (from wc-hooks.php) add:
                         * - SKU (priority 6)
                         * - Condition badge + stock indicator (priority 7)
                         * Default WC hooks:
                         * - Price (priority 10)
                         * - Excerpt (priority 20)
                         * Our hooks continue:
                         * - Acima CTA (priority 25)
                         * - Add to cart form (priority 30)
                         * - Location (priority 35)
                         */
                        do_action('woocommerce_single_product_summary');
                        ?>
                    </div>
                </div>

                <!-- Tabs (Description, Additional Info, Reviews) -->
                <?php woocommerce_output_product_data_tabs(); ?>

                <!-- Related Products -->
                <?php woocommerce_output_related_products(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<!-- Sticky Add to Cart (Mobile) -->
<?php
global $product;
if ($product && $product->is_in_stock()):
?>
<div class="bw-sticky-atc" id="bw-sticky-atc">
    <div>
        <div class="bw-sticky-atc__price"><?php echo $product->get_price_html(); ?></div>
    </div>
    <div class="bw-sticky-atc__btn">
        <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
           class="bw-btn bw-btn--primary bw-btn--sm"
           data-product_id="<?php echo esc_attr($product->get_id()); ?>">
            Add to Cart
        </a>
    </div>
</div>
<?php endif; ?>

<?php get_footer(); ?>
