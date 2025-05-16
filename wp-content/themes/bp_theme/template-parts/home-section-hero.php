<?php

$hero_section_title = get_field('hero_section_title');
$hero_section_description = get_field('hero_section_description');
$hero_section_check_products = get_field('hero_section_check_products');
$hero_section_background_image_id = get_field('hero_section_background_image');

if ($hero_section_background_image_id) {
    $hero_section_background_image_url = wp_get_attachment_image_url($hero_section_background_image_id, 'full');
}

?>
<section class="home-section-hero">
    <div class="home-section-hero__inner"
        style="background: url('<?= esc_url($hero_section_background_image_url); ?>');">
        <div class="container">
            <div class="hero-inner">
                <div class="hero-inner__holder">
                    <?php if ($hero_section_title): ?>
                        <h1><?= esc_html($hero_section_title); ?></h1>
                    <?php endif; ?>

                    <?php if ($hero_section_description): ?>
                        <p class="subtitle_m_light"><?= esc_html($hero_section_description); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($hero_section_check_products): ?>
                    <div class="theme-buttons">

                        <a href="<?= esc_url($hero_section_check_products['url']); ?>" class="theme-buttons__brown">
                            <?= esc_html($hero_section_check_products['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>