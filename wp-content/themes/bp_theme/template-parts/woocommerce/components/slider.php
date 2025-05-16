<?php

$current_product_id = get_the_ID();

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 10,
    'post__not_in' => array($current_product_id),
    'orderby' => 'rand',
    'no_found_rows' => true,
);

$related_products = new WP_Query($args);
?>
<?php if ($related_products->have_posts()): ?>
    <section class="product-slider-related">
        <div class="container">
            <div class="section-similar-products__titles">
                <h2><?= esc_attr_e('SUITABLE TOGETHER', 'bp_theme'); ?></h2>
            </div>
            <div class="product-slider-related splide" aria-label="Product Slider">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        $count = 0;
                        while ($related_products->have_posts()):
                            $related_products->the_post();
                            $count++;
                            $product_id = get_the_ID();
                            $product_obj = wc_get_product($product_id);
                            $product_title = get_the_title();
                            $product_link = get_permalink();
                            $thumbnail = get_the_post_thumbnail_url($product_id, 'medium');
                            $price_html = $product_obj ? $product_obj->get_price_html() : '';
                            $extra = get_field('product_extra_text', $product_id);
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
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php

$history_items = get_field('our_history', $current_product_id);

if (!empty($history_items) && is_array($history_items)): ?>
    <section class="timeline-section-product">

        <?php $index = 0; ?>
        <?php foreach ($history_items as $item):
            $layout_side = !empty($item['layout_side']) ? $item['layout_side'] : 'left';
            $semi_title = !empty($item['semi_title']) ? $item['semi_title'] : '';
            $title = !empty($item['title']) ? $item['title'] : '';
            $description = !empty($item['description']) ? $item['description'] : '';
            $link = !empty($item['link']) ? $item['link'] : null;
            $image = !empty($item['image']) ? $item['image'] : '';
            ?>
            <div class="timeline-block <?= esc_attr($layout_side) ?>" data-index="<?= esc_attr($index) ?>">
                <div class="timeline-content">
                    <div class="timeline-text">
                        <div class="timeline-text__holder">
                            <?php if ($semi_title): ?>
                                <span class="caption_l"><?= esc_html($semi_title) ?></span>
                            <?php endif; ?>

                            <?php if ($title): ?>
                                <h2><?= esc_html($title) ?></h2>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <div class="subtitle_s_light"><?= wp_kses_post($description) ?></div>
                            <?php endif; ?>

                            <?php if (!empty($link['url']) && !empty($link['title'])): ?>
                                <div class="theme-buttons">
                                    <a href="<?= esc_url($link['url']) ?>" class="theme-buttons__neutral">
                                        <?= esc_html($link['title']) ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($image): ?>
                        <div class="timeline-image">
                            <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php $index++; ?>
        <?php endforeach; ?>
    </section>
<?php endif; ?>