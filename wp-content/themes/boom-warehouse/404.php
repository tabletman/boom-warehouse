<?php get_header(); ?>

<main class="bw-main">
    <div class="bw-container" style="padding: 4rem 0; text-align: center;">
        <h1 style="font-size: 4rem; color: var(--bw-orange);">404</h1>
        <h2>Page Not Found</h2>
        <p style="margin: 1rem 0 2rem; color: var(--bw-text-muted);">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="bw-btn bw-btn--primary">
            Browse Products
        </a>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="bw-btn bw-btn--navy" style="margin-left: 0.5rem;">
            Go Home
        </a>
    </div>
</main>

<?php get_footer(); ?>
