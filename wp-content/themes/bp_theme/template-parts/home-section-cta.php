<?php
$title = get_field('cta_title');
$description = get_field('cta_description');
$link = get_field('cta_link');
$bg_id = get_field('cta_bg');
$bg_url = $bg_id ? wp_get_attachment_image_url($bg_id, 'full') : '';
?>

<section class="home-section-cta">
    <div class="home-section-cta__holder" style="background-image: url('<?= esc_url($bg_url); ?>');">
        <div class="container">
            <div class="home-section-cta__content">
                <div class="home-section-cta__content--text">
                    <?php if ($title): ?>
                        <h2 class="h1_extra"><?= esc_html($title); ?></h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <p class="subtitle_m_light"><?= esc_html($description); ?></p>
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