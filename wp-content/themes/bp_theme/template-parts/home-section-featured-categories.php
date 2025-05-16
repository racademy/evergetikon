<?php
$section_title = get_field('section_title');
$section_link = get_field('section_link');
?>

<section class="home-section-featured-categories">
    <div class="container">
        <?php if ($section_title || $section_link): ?>
            <div class="home-section-featured-categories__titles">
                <?php if ($section_title): ?>
                    <h2><?= esc_html($section_title); ?></h2>
                <?php endif; ?>
                <?php if ($section_link): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($section_link['url']); ?>"
                            target="<?= esc_attr($section_link['target'] ?: '_self'); ?>"
                            class="theme-buttons__neutral"><?= esc_html($section_link['title']); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php
        $featured_categories = get_field('featured_categories');
        if (!$featured_categories)
            return;
        ?>

        <div class="categories-grid">
            <?php foreach ($featured_categories as $item):
                $term_id = $item['category'];
                $term = get_term($term_id, 'product_cat');
                $term_link = get_term_link($term);

                $image_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : 'https://via.placeholder.com/300';
                ?>
                <a href="<?= esc_url($term_link); ?>" class="categories-grid__category-card">
                    <div class="categories-grid__image-wrapper">
                        <img src="<?= esc_url($image_url); ?>" alt="<?= esc_attr($term->name); ?>">
                    </div>
                    <div class="body_two_regular"><?= esc_html($term->name); ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>