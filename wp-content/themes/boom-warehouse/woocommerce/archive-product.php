<?php
/**
 * Product Archive / Shop Page
 *
 * @package BoomWarehouse
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="bw-main">
    <div class="bw-container">
        <!-- Breadcrumbs -->
        <?php woocommerce_breadcrumb(); ?>

        <header class="woocommerce-products-header" style="margin-bottom: 1.5rem;">
            <?php if (is_search()): ?>
                <h1>Search results for: "<?php echo esc_html(get_search_query()); ?>"</h1>
            <?php elseif (is_product_category()): ?>
                <h1><?php single_term_title(); ?></h1>
                <?php do_action('woocommerce_archive_description'); ?>
            <?php else: ?>
                <h1><?php woocommerce_page_title(); ?></h1>
            <?php endif; ?>
        </header>

        <div class="bw-shop-layout">
            <!-- Sidebar Filters -->
            <aside class="bw-sidebar">
                <!-- Condition Filter -->
                <div class="bw-filter-group">
                    <h3 class="bw-filter-group__title">Condition</h3>
                    <ul class="bw-filter-group__list">
                        <?php
                        $conditions = get_terms(['taxonomy' => 'pa_condition', 'hide_empty' => true]);
                        if (!is_wp_error($conditions)):
                            foreach ($conditions as $cond):
                                $active = isset($_GET['filter_condition']) && $_GET['filter_condition'] === $cond->slug;
                        ?>
                            <li>
                                <a href="<?php echo esc_url(add_query_arg('filter_condition', $cond->slug)); ?>"
                                   <?php if ($active): ?>style="color: var(--bw-orange); font-weight: 700;"<?php endif; ?>>
                                    <?php echo esc_html($cond->name); ?>
                                    <span class="count">(<?php echo esc_html($cond->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach;
                        endif; ?>
                    </ul>
                </div>

                <!-- Categories Filter -->
                <div class="bw-filter-group">
                    <h3 class="bw-filter-group__title">Categories</h3>
                    <ul class="bw-filter-group__list">
                        <?php
                        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true, 'parent' => 0]);
                        if (!is_wp_error($cats)):
                            foreach ($cats as $cat):
                                $active = is_product_category($cat->slug);
                        ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($cat)); ?>"
                                   <?php if ($active): ?>style="color: var(--bw-orange); font-weight: 700;"<?php endif; ?>>
                                    <?php echo esc_html($cat->name); ?>
                                    <span class="count">(<?php echo esc_html($cat->count); ?>)</span>
                                </a>
                            </li>
                        <?php endforeach;
                        endif; ?>
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="bw-filter-group">
                    <h3 class="bw-filter-group__title">Price Range</h3>
                    <ul class="bw-filter-group__list">
                        <li><a href="<?php echo esc_url(add_query_arg(['min_price' => 0, 'max_price' => 100])); ?>">Under $100</a></li>
                        <li><a href="<?php echo esc_url(add_query_arg(['min_price' => 100, 'max_price' => 300])); ?>">$100 - $300</a></li>
                        <li><a href="<?php echo esc_url(add_query_arg(['min_price' => 300, 'max_price' => 500])); ?>">$300 - $500</a></li>
                        <li><a href="<?php echo esc_url(add_query_arg(['min_price' => 500, 'max_price' => 1000])); ?>">$500 - $1,000</a></li>
                        <li><a href="<?php echo esc_url(add_query_arg(['min_price' => 1000, 'max_price' => ''])); ?>">$1,000+</a></li>
                    </ul>
                </div>

                <?php if (is_active_sidebar('shop-sidebar')): ?>
                    <?php dynamic_sidebar('shop-sidebar'); ?>
                <?php endif; ?>
            </aside>

            <!-- Product Grid -->
            <div class="bw-shop-content">
                <?php if (woocommerce_product_loop()): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <?php woocommerce_result_count(); ?>
                        <?php woocommerce_catalog_ordering(); ?>
                    </div>

                    <?php woocommerce_product_loop_start(); ?>
                    <?php while (have_posts()): the_post();
                        wc_get_template_part('content', 'product');
                    endwhile; ?>
                    <?php woocommerce_product_loop_end(); ?>

                    <?php woocommerce_pagination(); ?>
                <?php else: ?>
                    <div style="text-align: center; padding: 3rem;">
                        <h2>No products found</h2>
                        <p style="color: var(--bw-text-muted); margin-top: 0.5rem;">
                            Try adjusting your filters or search terms.
                        </p>
                        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bw-btn bw-btn--primary bw-mt-2">
                            View All Products
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
