<?php
$title = get_field('about_us_title');
$description = get_field('about_us_description');
$image = get_field('about_us_background_image');
$image_url = wp_get_attachment_image_url($image, 'full');
?>

<section class="about-us-hero">
    <div class="about-us-hero__holder">
        <div class="about-us-hero__holder--image-side">
            <?php if ($image_url): ?>
                <img src="<?= esc_url($image_url); ?>" alt="About Us">
            <?php endif; ?>
        </div>
        <div class="about-us-hero__holder--content">
            <?php if ($title): ?>
                <h1><?= esc_html($title); ?></h1>
            <?php endif; ?>
            <?php if ($description): ?>
                <span class="subtitle_s_light"><?= esc_html($description); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>