<?php
$slider = get_field('featured_slider');
if (!$slider)
    return;
?>
<section class="">
    <div class="container">
        <div class="splide featured-slider">
            <div class="splide__track">
                <ul class="splide__list">
                    <?php foreach ($slider as $slide): ?>
                        <?php
                        $link = $slide['slide_link'];
                        $link_url = $link['url'] ?? '#';
                        $link_target = $link['target'] ?? '_self';
                        $link_title = $link['title'] ?? 'Learn more';
                        $bg_url = wp_get_attachment_image_url($slide['slide_bg'], 'large');
                        ?>
                        <li class="splide__slide">
                            <a href="<?= esc_url($link_url); ?>" target="<?= esc_attr($link_target); ?>"
                                <?= $link_target === '_blank' ? 'rel="noopener"' : ''; ?> class="slide-inner">
                                <div class="slide-bg" style="background-image: url('<?= esc_url($bg_url); ?>');"></div>
                                <div class="slide-overlay">
                                    <h3 class="title"><?= esc_html($slide['slide_title']); ?></h3>
                                    <div class="theme-buttons">
                                        <span class="theme-buttons__neutral"><?= esc_html($link_title); ?></span>
                                    </div>

                                </div>
                            </a>

                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</section>