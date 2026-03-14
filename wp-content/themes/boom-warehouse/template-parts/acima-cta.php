<?php
/**
 * Acima CTA Block — Single Product Page
 *
 * @package BoomWarehouse
 */

$monthly = $args['monthly'] ?? 0;
$price   = $args['price'] ?? 0;

if (!$monthly) return;
?>

<div class="bw-acima-cta">
    <div class="bw-acima-cta__icon">
        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="32" height="32" rx="6" fill="#1B3A5C"/>
            <text x="16" y="21" text-anchor="middle" fill="#E8792B" font-size="14" font-weight="bold">$</text>
        </svg>
    </div>
    <div class="bw-acima-cta__text">
        <div>
            As low as <span class="bw-acima-cta__amount">$<?php echo esc_html($monthly); ?>/mo</span> with Acima
        </div>
        <div>
            <a href="<?php echo esc_url(bw_acima_prequalify_url()); ?>"
               class="bw-acima-cta__link"
               target="_blank" rel="noopener">
                Pre-qualify now — no hard credit check
            </a>
        </div>
    </div>
</div>
