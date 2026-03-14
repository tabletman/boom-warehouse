<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1B3A5C">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bw-header">
    <!-- Top Bar -->
    <div class="bw-header__top-bar">
        <div class="bw-container bw-header__top-bar-inner">
            <div>
                <a href="tel:+12165551234">&#9742; (216) 555-1234</a>
                &nbsp;&middot;&nbsp;
                <span>Cleveland &amp; Warrensville Heights, OH</span>
            </div>
            <div>
                <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>" target="_blank" rel="noopener">
                    Acima Financing — Pre-Qualify Now
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="bw-header__main">
        <div class="bw-container bw-header__main-inner">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="bw-logo">
                <?php if (has_custom_logo()): ?>
                    <?php the_custom_logo(); ?>
                <?php else: ?>
                    Boom<span>Warehouse</span>
                <?php endif; ?>
            </a>

            <!-- Search (desktop) -->
            <div class="bw-search">
                <form class="bw-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="hidden" name="post_type" value="product">
                    <input class="bw-search__input" type="search" name="s"
                           placeholder="Search TVs, laptops, appliances..."
                           value="<?php echo esc_attr(get_search_query()); ?>">
                    <button class="bw-search__btn" type="submit">Search</button>
                </form>
            </div>

            <!-- Actions -->
            <div class="bw-header__actions">
                <?php if (is_user_logged_in()): ?>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('dashboard')); ?>">
                        &#128100; Account
                    </a>
                <?php else: ?>
                    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">
                        &#128100; Sign In
                    </a>
                <?php endif; ?>

                <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    &#128722; Cart
                    <?php $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                    <?php if ($count > 0): ?>
                        <span class="bw-cart-count"><?php echo esc_html($count); ?></span>
                    <?php endif; ?>
                </a>

                <button class="bw-menu-toggle" aria-label="Menu" aria-expanded="false">
                    &#9776;
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bw-nav" aria-label="<?php esc_attr_e('Primary Navigation', 'boom-warehouse'); ?>">
        <div class="bw-container">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'bw-nav__list',
                'fallback_cb'    => 'bw_fallback_nav',
                'depth'          => 1,
            ]);
            ?>
        </div>
    </nav>

    <!-- Mobile Nav -->
    <div class="bw-mobile-nav" id="bw-mobile-nav">
        <div class="bw-search">
            <form class="bw-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="hidden" name="post_type" value="product">
                <input class="bw-search__input" type="search" name="s"
                       placeholder="Search products..."
                       value="<?php echo esc_attr(get_search_query()); ?>">
                <button class="bw-search__btn" type="submit">Search</button>
            </form>
        </div>
        <?php
        wp_nav_menu([
            'theme_location' => 'mobile',
            'container'      => false,
            'menu_class'     => 'bw-nav__list',
            'fallback_cb'    => 'bw_fallback_nav',
            'depth'          => 1,
        ]);
        ?>
    </div>
</header>

<!-- USP Bar -->
<div class="bw-usp-bar">
    <div class="bw-container">
        <ul class="bw-usp-bar__list">
            <li>&#9889; Tested &amp; Certified</li>
            <li>&#128176; Acima Financing Available</li>
            <li>&#127968; 2 Cleveland Locations</li>
            <li>&#128666; Local Pickup &amp; Delivery</li>
        </ul>
    </div>
</div>

<?php

function bw_fallback_nav() {
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
        'parent'     => 0,
    ]);

    if (empty($categories) || is_wp_error($categories)) return;

    echo '<ul class="bw-nav__list">';
    echo '<li><a href="' . esc_url(wc_get_page_permalink('shop')) . '">All Products</a></li>';
    foreach ($categories as $cat) {
        echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
    }
    echo '</ul>';
}
