<?php
$title = get_field('section_title');
$link = get_field('section_link');
$post_source = get_field('post_source');
$manual_posts = get_field('manual_posts');

// Get posts based on selection
$posts = [];

if ($post_source === 'manual' && $manual_posts) {
    $posts = $manual_posts;
} else {
    $posts = get_posts([
        'post_type' => 'post',
        'posts_per_page' => 5, // You can make this dynamic later if needed
    ]);
}

// Start Output
if (!$posts)
    return;
?>
<section class="section-posts-slider">
    <div class="container">
        <div class="section-products-side-img__wrapper">
            <div class="slider-container-second splide" aria-label="Product Slider">
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
                        <?php foreach ($posts as $post):
                            setup_postdata($post); ?>
                            <li class="splide__slide">
                                <div class="product-card">
                                    <a class="product-card__content" href="<?= esc_url(get_permalink($post->ID)); ?>">
                                        <?php if (has_post_thumbnail($post->ID)): ?>
                                            <div class="product-card__image-wrapper">
                                                <?= get_the_post_thumbnail($post->ID, 'medium'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="title"><?= esc_html(get_the_title($post->ID)); ?>
                                            <div class="theme-buttons">
                                                <span
                                                    class="theme-buttons__neutral"><?= esc_attr_e('READ POST', 'bp_theme'); ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>