<?php
/**
 * Hero Section — Homepage
 *
 * @package BoomWarehouse
 */
?>
<section class="bm-hero">
    <div class="bm-container bm-hero__content">
        <h1>Real Deals. <span>Real Savings.</span></h1>
        <p class="bm-hero__subtitle">
            Cleveland's warehouse for quality refurbished electronics, appliances, and more.
            Save 30-60% off retail — with Acima financing available.
        </p>
        <div class="bm-hero__ctas">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bm-btn bm-btn--primary bm-btn--lg">
                Shop All Deals
            </a>
            <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>" class="bm-btn bm-btn--secondary bm-btn--lg" target="_blank" rel="noopener">
                Pre-Qualify for Financing
            </a>
        </div>
    </div>
</section>
