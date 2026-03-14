<?php get_header(); ?>

<main class="bw-main">
    <?php if (is_front_page()): ?>
        <?php get_template_part('template-parts/hero'); ?>
        <?php get_template_part('template-parts/category-tiles'); ?>
        <?php get_template_part('template-parts/featured-products'); ?>
        <?php get_template_part('template-parts/acima-banner'); ?>
    <?php else: ?>
        <div class="bw-container">
            <?php if (have_posts()): ?>
                <?php while (have_posts()): the_post(); ?>
                    <article>
                        <h1><?php the_title(); ?></h1>
                        <div><?php the_content(); ?></div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p><?php esc_html_e('No content found.', 'boom-warehouse'); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
