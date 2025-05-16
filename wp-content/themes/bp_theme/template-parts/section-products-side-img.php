<?php
$title = get_field('section_title');
$link = get_field('section_link');
$layout = get_field('layout_type') ?: 'slider_only';
$side_image_id = get_field('side_image');
$product_source = get_field('product_source');
$manual_products = get_field('manual_products');
$category_id = get_field('product_category');

$side_image_url = $side_image_id ? wp_get_attachment_image_url($side_image_id, 'large') : '';

$products = [];

if ($product_source === 'manual' && $manual_products) {
    $products = $manual_products;
} elseif ($product_source === 'category' && $category_id) {
    $query = new WP_Query([
        'post_type' => 'product',
        'posts_per_page' => 10,
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $category_id,
            ]
        ],
    ]);
    $products = $query->have_posts() ? $query->posts : [];
}

if (!$products)
    return;
?>

<section class="section-products-side-img <?= esc_attr($layout); ?>">
    <div class="section-products-side-img__wrapper">
        <?php if ($layout === 'slider_right' && $side_image_url): ?>
            <div class="side-image">
                <img src="<?= esc_url($side_image_url); ?>" alt="">
            </div>
        <?php endif; ?>

        <div class="slider-container splide" aria-label="Product Slider">
            <?php if ($title || $link): ?>
                <div class="section-header">
                    <?php if ($title): ?>
                        <h2><?= esc_html($title); ?></h2>
                    <?php endif; ?>
                    <?php if ($link): ?>
                        <div class="theme-buttons">
                            <a href="<?= esc_url($link['url']); ?>" target="<?= esc_attr($link['target'] ?: '_self'); ?>"
                                class="theme-buttons__neutral"><?= esc_html($link['title']); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($products as $product):
                        $product_id = is_object($product) ? $product->ID : $product;
                        $product_obj = wc_get_product($product_id);
                        if (!$product_obj)
                            continue;

                        $thumbnail = get_the_post_thumbnail_url($product_id, 'medium');
                        $product_title = get_the_title($product_id);
                        $product_link = get_permalink($product_id);
                        $extra = get_field('extra_product_tag', $product_id);
                        $price_html = $product_obj->get_price_html();
                        ?>
                        <li class="splide__slide">
                            <div class="product-card">
                                <?php if (is_product_new($product_id, 14)): ?>
                                    <span class="badge-new caption_m"><?= esc_attr_e('New', 'bp_theme') ?></span>
                                <?php endif; ?>

                                <?php if (function_exists('YITH_WCWL')): ?>
                                    <div class="yith-wcwl-add-button">
                                        <?= do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . esc_attr($product_id) . '"]'); ?>
                                    </div>
                                <?php endif; ?>

                                <a class="product-card__content" href="<?= esc_url($product_link); ?>">
                                    <?php if ($thumbnail): ?>
                                        <div class="product-card__image-wrapper">
                                            <img src="<?= esc_url($thumbnail); ?>" alt="<?= esc_attr($product_title); ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="product-card__image-wrapper">
                                            <img src="/wp-content/uploads/woocommerce-placeholder.png" alt="Default image">
                                        </div>
                                    <?php endif; ?>
                                    <div class="caption_s"><?= esc_html($extra); ?></div>
                                    <div class="body_one_regular"><?= esc_html($product_title); ?></div>
                                    <?php if ($price_html): ?>
                                        <div class="body_one_semibold"><?= $price_html; ?></div>
                                    <?php endif; ?>
                                </a>

                                <?php if ($product_obj->is_purchasable() && $product_obj->is_in_stock()): ?>
                                    <div class="theme-buttons">
                                        <a href="?add-to-cart=<?= esc_attr($product_id); ?>" data-quantity="1"
                                            data-product_id="<?= esc_attr($product_id); ?>"
                                            data-product_sku="<?= esc_attr($product_obj->get_sku()); ?>"
                                            class="theme-buttons__neutral ajax_add_to_cart add_to_cart_button" rel="nofollow">
                                            <?= esc_attr_e('ADD TO CART', 'bp_theme') ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <?php if ($layout === 'slider_left' && $side_image_url): ?>
            <div class="side-image">
                <img src="<?= esc_url($side_image_url); ?>" alt="">
            </div>
        <?php endif; ?>
    </div>
</section>