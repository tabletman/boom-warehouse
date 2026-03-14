<?php
/**
 * Category Tiles — Homepage
 *
 * @package BoomWarehouse
 */

$categories = [
    ['slug' => 'tvs-displays',       'name' => 'TVs & Displays',       'icon' => '&#128250;'],
    ['slug' => 'computers-laptops',   'name' => 'Computers & Laptops',  'icon' => '&#128187;'],
    ['slug' => 'appliances',          'name' => 'Appliances',           'icon' => '&#129513;'],
    ['slug' => 'furniture',           'name' => 'Furniture',            'icon' => '&#129681;'],
    ['slug' => 'small-electronics',   'name' => 'Small Electronics',    'icon' => '&#127911;'],
    ['slug' => 'household-goods',     'name' => 'Household Goods',      'icon' => '&#128722;'],
];
?>

<section class="bw-categories">
    <div class="bw-container">
        <div class="bw-section-heading">
            <h2>Shop by Category</h2>
        </div>
        <div class="bw-categories__grid">
            <?php foreach ($categories as $cat):
                $term = get_term_by('slug', $cat['slug'], 'product_cat');
                $url = $term ? get_term_link($term) : wc_get_page_permalink('shop');
            ?>
                <a href="<?php echo esc_url($url); ?>" class="bw-category-tile">
                    <div class="bw-category-tile__icon"><?php echo $cat['icon']; ?></div>
                    <div class="bw-category-tile__name"><?php echo esc_html($cat['name']); ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
