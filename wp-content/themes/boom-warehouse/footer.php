<footer class="bw-footer">
    <div class="bw-container">
        <div class="bw-footer__grid">
            <!-- About -->
            <div>
                <h4>Boom Warehouse</h4>
                <p class="bw-footer__about">
                    Cleveland's source for quality refurbished electronics, appliances, furniture, and more.
                    Save 30-60% off retail prices. Acima lease-to-own financing available — no credit needed.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4>Shop</h4>
                <ul class="bw-footer__links">
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

            <!-- Customer Service -->
            <div>
                <h4>Help</h4>
                <ul class="bw-footer__links">
                    <li><a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>">My Account</a></li>
                    <li><a href="<?php echo esc_url(wc_get_cart_url()); ?>">Shopping Cart</a></li>
                    <li><a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>" target="_blank" rel="noopener">Acima Financing</a></li>
                    <li><a href="/shipping-returns/">Shipping &amp; Returns</a></li>
                    <li><a href="/contact/">Contact Us</a></li>
                </ul>
            </div>

            <!-- Locations -->
            <div>
                <h4>Locations</h4>
                <div class="bw-footer__location">
                    <strong>Renaissance Pkwy</strong>
                    4554 Renaissance Pkwy<br>
                    Warrensville Heights, OH 44128
                </div>
                <div class="bw-footer__location">
                    <strong>Emery Rd</strong>
                    26055 Emery Rd B-1<br>
                    Cleveland, OH 44128
                </div>
                <p><a href="tel:+12165551234" style="color: var(--bw-orange);">&#9742; (216) 555-1234</a></p>
            </div>
        </div>

        <div class="bw-footer__bottom">
            <span>&copy; <?php echo date('Y'); ?> Boom Warehouse. All rights reserved.</span>
            <span>
                <a href="/privacy-policy/" style="color:rgba(255,255,255,0.6);">Privacy Policy</a>
                &middot;
                <a href="/terms-of-service/" style="color:rgba(255,255,255,0.6);">Terms of Service</a>
            </span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
