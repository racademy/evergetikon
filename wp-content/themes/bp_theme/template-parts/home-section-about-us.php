<?php
$title = get_field('about_us_title');
$description = get_field('about_us_description');
$read_link = get_field('about_us_read');
$signature = get_field('signature');
$bg_image_id = get_field('about_us_bg_image');
$bg_image_url = $bg_image_id ? wp_get_attachment_image_url($bg_image_id, 'large') : '';
?>

<section class="home-section-about-us">
    <div class="container">
        <div class="home-section-about-us__content">
            <div class="home-section-about-us__content--text">
                <?php if ($title): ?>
                    <h2><?= esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <div class="body_one_light"><?= wp_kses_post(nl2br($description)); ?></div>
                <?php endif; ?>

                <?php if ($read_link): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($read_link['url']); ?>"
                            target="<?= esc_attr($read_link['target'] ?: '_self'); ?>" class="theme-buttons__neutral">
                            <?= esc_html($read_link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="home-section-about-us__content--signature">
                <span class="signature"><?= esc_html($signature) ?></span>
            </div>
        </div>
    </div>
    <img src="<?= $bg_image_url ?>" alt="background image" class="about-background">
</section>