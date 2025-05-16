<?php
global $wp_query;

// Get total product count
$total_products = $wp_query->found_posts;

$shop_title = '';
$shop_description = '';

/* CTA section */
$title = get_field('cta_title', 'option');
$description = get_field('cta_description', 'option');
$link = get_field('cta_link', 'option');
$bg_id = get_field('cta_bg', 'option');
$bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';

/* Testimonials */
$slider_title = get_field('testimonial_slider_title', 'option');
$testimonials = get_field('home_testimonials_slider', 'option');
$colab_title = get_field('colab_title', 'option');
$colabs = get_field('colab', 'option');


if (is_product_category()) {
    $term = get_queried_object();
    $shop_title = $term->name ?? '';
    $shop_description = term_description($term->term_id, 'product_cat');
} else {
    $shop_page_id = wc_get_page_id('shop');
    $shop_title = get_the_title($shop_page_id);
    $shop_description = get_post_field('post_content', $shop_page_id);
}
?>

<div class="section-products">
    <div class="container">
        <!-- Header shop-->
        <div class="section-products__header">
            <div class="section-products__total-number">
                <h1><?= esc_html($shop_title); ?></h1>
                <span id="product-count" class="body_one_light">
                    <?= sprintf('(%d)', intval($total_products)); ?>
                </span>
            </div>
            <?php if (!empty($shop_description)): ?>
                <div class="shop-page-description">
                    <?= wp_kses_post($shop_description); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="section-products__content">
            <!-- Filters -->
            <aside id="filter" class="section-products__filter">
                <div class="category-filter">
                    <label class="caption_l"><?= esc_html__('Category', 'bp_theme'); ?></label>

                    <?php if (is_shop() && !is_product_category()): ?>
                        <div class="shop-category-grid">
                            <?php
                            $parent_cats = get_terms([
                                'taxonomy' => 'product_cat',
                                'parent' => 0,
                                'hide_empty' => true,
                            ]);
                            foreach ($parent_cats as $cat):
                                ?>
                                <a href="<?= esc_url(get_term_link($cat)); ?>" class="body_one_light">
                                    <?= esc_html($cat->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (is_product_category()):
                        $term = get_queried_object();
                        $children = get_terms([
                            'taxonomy' => 'product_cat',
                            'parent' => $term->term_id,
                            'hide_empty' => true,
                        ]);
                        ?>
                        <div class="shop-subcategory-header">
                            <a href="<?= esc_url(get_permalink(wc_get_page_id('shop'))); ?>"
                                class="shop-subcategory-header__back">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M10 4L6 8L10 12" stroke="black" stroke-linecap="square" />
                                </svg>
                                <?= esc_html($term->name); ?>
                            </a>
                        </div>

                        <?php if (!empty($children)): ?>
                            <div class="shop-subcategory-grid">
                                <?php foreach ($children as $child): ?>
                                    <a href="<?= esc_url(get_term_link($child)); ?>" class="shop-subcategory-grid__item">
                                        <?= esc_html($child->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- WOOF Filter -->
                <?= do_shortcode("[woof sid='generator_6819eb9fd4979' autohide='0' autosubmit='-1' is_ajax='0' ajax_redraw='0' start_filtering_btn='0' btn_position='b' dynamic_recount='-1' hide_terms_count_txt='0' mobile_mode='0']"); ?>
            </aside>

            <!-- Product List -->
            <div class="section-products__main">
                <div class="section-products__sorting">
                    <span class="position-order-word"><?= esc_html__('Ordering', 'bp_theme'); ?></span>
                    <?php woocommerce_catalog_ordering(); ?>
                </div>

                <div class="section-products__items">
                    <?php if (woocommerce_product_loop()): ?>
                        <?php
                        woocommerce_product_loop_start();
                        while (have_posts()) {
                            the_post();
                            do_action('woocommerce_shop_loop');
                            get_template_part('template-parts/woocommerce/components/product-card');
                        }
                        woocommerce_product_loop_end();

                        $total_products = wc_get_loop_prop('total');
                        $per_page = get_option('posts_per_page');
                        $current_page = max(1, get_query_var('paged'));
                        $start_post = (($current_page - 1) * $per_page) + 1;
                        $end_post = min($current_page * $per_page, $total_products);
                        ?>

                        <div class="blog-archive__info-pagination-wrapper">
                            <div class="blog-archive__info">
                                <?= sprintf(__('SHOWING %d–%d OF %d', 'bp_theme'), $start_post, $end_post, $total_products); ?>
                            </div>
                            <div class="blog-archive__pagination">
                                <?php
                                the_posts_pagination([
                                    'mid_size' => 2,
                                    'prev_text' => __('<svg width="24" height="24"><path d="M15.9999 21.308L6.69189 12L15.9999 2.69199L17.0639 3.75599L8.81889 12L17.0629 20.244L15.9999 21.308Z" fill="black"/></svg>'),
                                    'next_text' => __('<svg width="44" height="41"><path d="M18.0064 29.8079L16.9424 28.7439L25.1874 20.4999L16.9424 12.2559L18.0064 11.1919L27.3144 20.4999L18.0064 29.8079Z" fill="black"/></svg>'),
                                ]);
                                ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php do_action('woocommerce_no_products_found'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="shop-section-cta">
    <div class="shop-section-cta__holder" style="background-image: url('<?= esc_url($bg_url); ?>');">
        <div class="container">
            <div class="shop-section-cta__content">
                <div class="shop-section-cta__content--text">
                    <?php if ($title): ?>
                        <h2 class="h1_extra">
                            <?= esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <p class="subtitle_m_light">
                            <?= esc_html($description); ?>
                        </p>
                    <?php endif; ?>
                </div>
                <?php if ($link): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($link['url']); ?>" class="theme-buttons__brown">
                            <?= esc_html($link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    const resetButton = document.querySelector('.woof_reset_search_form');
    if (resetButton) {
        resetButton.textContent = '<?= esc_js(__('Reset filters', 'bp_theme')); ?>';
    }
</script>