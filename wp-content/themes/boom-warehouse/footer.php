<footer class="bm-footer">
    <!-- Main Footer -->
    <div class="bm-footer__main">
        <div class="bm-container">
            <div class="bm-footer__grid">
                <!-- Brand Column -->
                <div class="bm-footer__brand">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="bm-footer__logo">
                        <?php if (has_custom_logo()): ?>
                            <?php the_custom_logo(); ?>
                        <?php else: ?>
                            <span class="bm-logo__text">Boom<span>Warehouse</span></span>
                        <?php endif; ?>
                    </a>
                    <p class="bm-footer__tagline">
                        Quality refurbished electronics at the best prices. 
                        Professionally inspected, tested, and certified with 24-month warranty.
                    </p>
                    <div class="bm-footer__badges">
                        <div class="bm-badge">
                            <span class="bm-badge__icon">&#10003;</span>
                            <span class="bm-badge__text">Certified</span>
                        </div>
                        <div class="bm-badge">
                            <span class="bm-badge__icon">&#10003;</span>
                            <span class="bm-badge__text">Warranty</span>
                        </div>
                        <div class="bm-badge">
                            <span class="bm-badge__icon">&#10003;</span>
                            <span class="bm-badge__text">Eco-Friendly</span>
                        </div>
                    </div>
                </div>

                <!-- Shop Links -->
                <div class="bm-footer__links-col">
                    <h4>Shop</h4>
                    <ul class="bm-footer__links">
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>">All Products</a></li>
                        <?php
                        $cats = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false, 'parent' => 0, 'number' => 6]);
                        if (!is_wp_error($cats)):
                            foreach ($cats as $cat):
                                echo '<li><a href="' . esc_url(get_term_link($cat)) . '">' . esc_html($cat->name) . '</a></li>';
                            endforeach;
                        endif;
                        ?>
                    </ul>
                </div>

                <!-- Help Links -->
                <div class="bm-footer__links-col">
                    <h4>Help</h4>
                    <ul class="bm-footer__links">
                        <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">My Account</a></li>
                        <li><a href="<?php echo esc_url(wc_get_cart_url()); ?>">Shopping Cart</a></li>
                        <li><a href="/acima-financing/">Financing</a></li>
                        <li><a href="/shipping-returns/">Shipping & Returns</a></li>
                        <li><a href="/contact/">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="bm-footer__contact">
                    <h4>Contact</h4>
                    <div class="bm-footer__contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <a href="tel:+121****4119">(216) 342-4119</a>
                    </div>
                    <div class="bm-footer__contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <span>Warrensville Heights, OH</span>
                    </div>
                    <div class="bm-footer__contact-item">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Mon-Sat: 10am - 7pm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trust Strip -->
    <div class="bm-footer__trust">
        <div class="bm-container">
            <div class="bm-footer__trust-items">
                <div class="bm-trust-item">
                    <span class="bm-trust-item__icon">&#127793;</span>
                    <span>Save up to 60% vs. new</span>
                </div>
                <div class="bm-trust-item">
                    <span class="bm-trust-item__icon">&#10003;</span>
                    <span>Professionally inspected</span>
                </div>
                <div class="bm-trust-item">
                    <span class="bm-trust-item__icon">&#128737;</span>
                    <span>24-month warranty</span>
                </div>
                <div class="bm-trust-item">
                    <span class="bm-trust-item__icon">&#128722;</span>
                    <span>Free shipping over $50</span>
                </div>
                <div class="bm-trust-item">
                    <span class="bm-trust-item__icon">&#128293;</span>
                    <span>30-day money back</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bm-footer__bottom">
        <div class="bm-container">
            <div class="bm-footer__bottom-inner">
                <span>&copy; <?php echo date('Y'); ?> Back Market. All rights reserved.</span>
                <div class="bm-footer__legal">
                    <a href="/privacy-policy/">Privacy Policy</a>
                    <a href="/terms-of-service/">Terms of Service</a>
                    <a href="/environmental-commitment/">Environmental Commitment</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
