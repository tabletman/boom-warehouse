<?php
/**
 * Category Tiles — Homepage
 * Back Market style: real product photos with lime overlay and labels
 *
 * @package BoomWarehouse
 */

$categories = [
    [
        'slug'  => 'tvs-displays',
        'name'  => 'TVs & Displays',
        'image' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?w=600&q=80',
        'label' => '65" 4K Smart TVs from $299',
    ],
    [
        'slug'  => 'computers-laptops',
        'name'  => 'Computers & Laptops',
        'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&q=80',
        'label' => 'MacBooks, ThinkPads, iMacs',
    ],
    [
        'slug'  => 'appliances',
        'name'  => 'Appliances',
        'image' => 'https://images.unsplash.com/photo-1571175443880-49e1d25b2bc5?w=600&q=80',
        'label' => 'Washers, Dryers, Fridges',
    ],
    [
        'slug'  => 'furniture',
        'name'  => 'Furniture',
        'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600&q=80',
        'label' => 'Sofas, Chairs, Tables',
    ],
    [
        'slug'  => 'small-electronics',
        'name'  => 'Small Electronics',
        'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
        'label' => 'Headphones, Speakers, Tablets',
    ],
    [
        'slug'  => 'household-goods',
        'name'  => 'Household Goods',
        'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
        'label' => 'Kitchen, Bedding, Decor',
    ],
];
?>

<section class="bm-categories">
    <div class="bm-container">
        <div class="bm-section-heading">
            <h2>Shop by Category</h2>
        </div>
        <div class="bm-categories__grid">
            <?php foreach ($categories as $cat):
                $term = get_term_by('slug', $cat['slug'], 'product_cat');
                $url  = $term ? get_term_link($term) : wc_get_page_permalink('shop');
            ?>
                <a href="<?php echo esc_url($url); ?>" class="bm-category-tile">
                    <div class="bm-category-tile__image">
                        <img src="<?php echo esc_url($cat['image']); ?>"
                             alt="<?php echo esc_attr($cat['name']); ?>"
                             loading="lazy">
                        <div class="bm-category-tile__overlay"></div>
                    </div>
                    <div class="bm-category-tile__content">
                        <div class="bm-category-tile__name"><?php echo esc_html($cat['name']); ?></div>
                        <div class="bm-category-tile__sub"><?php echo esc_html($cat['label']); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
