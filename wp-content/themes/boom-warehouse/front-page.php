<?php
/**
 * Homepage Template
 *
 * @package BoomWarehouse
 */

get_header();
?>

<main class="bw-main">
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/category-tiles'); ?>
    <?php get_template_part('template-parts/featured-products'); ?>
    <?php get_template_part('template-parts/acima-banner'); ?>
</main>

<?php get_footer(); ?>
