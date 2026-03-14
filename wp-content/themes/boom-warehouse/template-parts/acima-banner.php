<?php
/**
 * Acima Financing Banner — Homepage
 *
 * @package BoomWarehouse
 */
?>
<section style="background: linear-gradient(135deg, var(--bw-navy) 0%, var(--bw-navy-dark) 100%); padding: 3rem 0; color: #fff;">
    <div class="bw-container" style="text-align: center;">
        <h2 style="color: #fff; margin-bottom: 0.75rem;">No Credit? No Problem.</h2>
        <p style="font-size: 1.1rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto 1.5rem;">
            Get approved for up to <strong style="color: var(--bw-orange);">$5,000</strong> in lease-to-own financing with Acima.
            Instant decision. No hard credit check.
        </p>
        <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>"
           class="bw-btn bw-btn--primary bw-btn--lg"
           target="_blank" rel="noopener">
            Pre-Qualify Now
        </a>
        <p style="margin-top: 0.75rem; font-size: 0.8rem; color: rgba(255,255,255,0.6);">
            Lease-to-own provided by Acima. Not available in all states. See terms for details.
        </p>
    </div>
</section>
