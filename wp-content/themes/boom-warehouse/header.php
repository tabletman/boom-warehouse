<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#D7FF5F">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Back Market Style Header -->
<header class="bm-header">
    <!-- Trust Bar -->
    <div class="bm-trust-bar">
        <div class="bm-container">
            <span>&#10003; 24-month warranty &nbsp;&bull;&nbsp; 30-day money back guarantee &nbsp;&bull;&nbsp; Free shipping over $50</span>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bm-header__main">
        <div class="bm-container bm-header__main-inner">
            <!-- Mobile Menu Toggle -->
            <button class="bm-menu-toggle" aria-label="Menu" aria-expanded="false">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="bm-logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                <span class="bm-logo__text">Boom<span>Warehouse</span></span>
                <?php endif; ?>
            </a>

            <!-- Search -->
            <div class="bm-search">
                <form class="bm-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product">
                    <input class="bm-search__input" type="search" name="s"
                           placeholder="Search laptops, phones, tablets..."
                           value="<?php echo esc_attr(get_search_query()); ?>">
                    <button class="bm-search__btn" type="submit">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Actions -->
            <div class="bm-header__actions">
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>" class="bm-action">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Account</span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="bm-action">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Sign In</span>
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="bm-action bm-cart">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <span>Cart</span>
                    <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <?php if ($count > 0): ?>
                        <span class="bm-cart__count"><?php echo esc_html($count); ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Category Navigation -->
    <nav class="bm-nav" aria-label="<?php esc_attr_e('Primary Navigation', 'boom-warehouse'); ?>">
        <div class="bm-container">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'bm-nav__list',
                'fallback_cb'    => 'bm_fallback_nav',
                'depth'          => 1,
            ]);
            ?>
        </div>
    </nav>

    <!-- Mobile Nav -->
    <div class="bm-mobile-nav" id="bm-mobile-nav">
        <div class="bm-mobile-nav__search">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="product">
                <input type="search" name="s" placeholder="Search products..."
                       value="<?php echo esc_attr(get_search_query()); ?>">
                <button type="submit">Search</button>
            </form>
        </div>
        <?php
        wp_nav_menu([
            'theme_location' => 'mobile',
            'container'      => false,
            'menu_class'     => 'bm-mobile-nav__list',
            'fallback_cb'    => 'bm_fallback_nav',
            'depth'          => 1,
        ]);
        ?>
    </div>
</header>

<!-- Category Bar -->
<div class="bm-category-bar">
    <div class="bm-container">
        <div class="bm-category-bar__inner">
            <span class="bm-category-bar__label">Shop by category:</span>
            <div class="bm-category-bar__links">
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">All</a>
                <?php
                $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0, 'number' => 6]);
                if (!is_wp_error($cats)):
                    foreach ($cats as $cat):
                        echo '<a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a>';
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php

function bm_fallback_nav() {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
    ]);

    if (empty($categories) || is_wp_error($categories)) return;

    echo '<ul class="bm-nav__list">';
    echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">All Products</a></li>';
    foreach ($categories as $cat) {
        echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
    }
    echo '</ul>';
}
