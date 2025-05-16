<?php
$parent_category_id = get_field('category');
$parent_category = get_term($parent_category_id, 'product_cat');

if ($parent_category && !is_wp_error($parent_category)) {
    $child_categories = get_terms([
        'taxonomy' => 'product_cat',
        'parent' => $parent_category->term_id,
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => true,
    ]);

    if (!empty($child_categories) && !is_wp_error($child_categories)):
        ?>

        <section class="product-category-slider">
            <div class="product-category-slider__holder">
                <div class="product-category-slider__holder--top">
                    <div class="cat-titles">
                        <span class="camption_l"><?= esc_attr_e('Category', 'bp_theme'); ?></span>
                        <h2><?= esc_html($parent_category->name); ?></h2>
                    </div>
                    <div class="theme-buttons">
                        <a href="<?= esc_url(get_term_link($parent_category)); ?>"
                            class="theme-buttons__neutral"><?= esc_attr_e('SEE ALL PRODUCTS', 'bp_theme') ?></a>
                    </div>
                </div>

                <div class="splide" id="category-slider" aria-label="Child Category Slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php
                            foreach ($child_categories as $child_category):
                                $child_category_link = get_term_link($child_category);
                                $child_category_image = get_term_meta($child_category->term_id, 'thumbnail_id', true);
                                $image_url = $child_category_image ? wp_get_attachment_image_url($child_category_image, 'medium') : '';
                                ?>
                                <li class="splide__slide">
                                    <div class="category-card">
                                        <div class="category-card__content">
                                            <?php if ($image_url): ?>
                                                <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($child_category->name); ?>">
                                            <?php endif; ?>
                                            <span class="body_one_regular"><?= esc_html($child_category->name); ?></span>
                                        </div>
                                        <div class="theme-buttons">
                                            <a href="<?= esc_url($child_category_link); ?>"
                                                class="theme-buttons__neutral"><?= esc_attr_e('SEE PRODUCTS', 'bp_theme'); ?></a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <?php
    endif;
}
?>