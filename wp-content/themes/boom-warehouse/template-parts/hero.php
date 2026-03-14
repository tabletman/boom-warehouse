<?php
/**
 * Hero Section — Homepage
 *
 * @package BoomWarehouse
 */
?>
<section class="bw-hero">
    <div class="bw-container bw-hero__content">
        <h1>Real Deals. <span>Real Savings.</span></h1>
        <p class="bw-hero__subtitle">
            Cleveland's warehouse for quality refurbished electronics, appliances, and more.
            Save 30-60% off retail — with Acima financing available.
        </p>
        <div class="bw-hero__ctas">
            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bw-btn bw-btn--primary bw-btn--lg">
                Shop All Deals
            </a>
            <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>" class="bw-btn bw-btn--secondary bw-btn--lg" target="_blank" rel="noopener">
                Pre-Qualify for Financing
            </a>
        </div>
    </div>
</section>
