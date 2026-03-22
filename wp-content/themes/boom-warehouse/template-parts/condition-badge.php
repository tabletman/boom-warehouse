<?php
/**
 * Condition Badge Component
 *
 * @package BoomWarehouse
 */

$condition = $args['condition'] ?? '';
if (!$condition) return;
?>
<span class="bm-badge <?php echo esc_attr(bw_condition_badge_class($condition)); ?>">
    <?php echo esc_html($condition); ?>
</span>
