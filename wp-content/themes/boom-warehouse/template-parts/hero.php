<?php
/**
 * Hero Section — Homepage
 * Back Market style: full-width lifestyle image with dark overlay
 *
 * @package BoomWarehouse
 */
?>
<section class="bm-hero">
    <div class="bm-hero__bg">
        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1600&q=80"
             alt="Refurbished electronics and appliances"
             class="bm-hero__bg-img">
        <div class="bm-hero__bg-overlay"></div>
    </div>
    <div class="bm-container bm-hero__content">
        <div class="bm-hero__badge">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#D7FF5F" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
            30-60% off retail prices
        </div>
        <h1>Cleveland's warehouse<br>for <span class="bm-hero__highlight">quality tech</span><br>at half the price.</h1>
        <p class="bm-hero__subtitle">
            Refurbished electronics, appliances & more — professionally inspected,
            backed by a 24-month warranty. Acima financing available.
        </p>
        <div class="bm-hero__ctas">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bm-btn bm-btn--primary bm-btn--lg">
                Shop All Deals
            </a>
            <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>" class="bm-btn bm-btn--outline-light bm-btn--lg" target="_blank" rel="noopener">
                Pre-Qualify for Financing
            </a>
        </div>
        <div class="bm-hero__trust">
            <span>✓ Tested & Certified</span>
            <span>✓ 30-Day Returns</span>
            <span>✓ 24-Month Warranty</span>
            <span>✓ Acima Financing</span>
        </div>
    </div>
</section>
