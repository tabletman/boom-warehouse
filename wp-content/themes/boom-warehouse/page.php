<?php get_header(); ?>

<main class="bw-main">
    <div class="bw-container" style="padding-top: 2rem; padding-bottom: 3rem;">
        <?php while (have_posts()): the_post(); ?>
            <article>
                <h1><?php the_title(); ?></h1>
                <div class="bw-page-content" style="margin-top: 1rem; line-height: 1.8;">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
