<?php
$show = get_field('shop_add_show', 'option');
$semi_title = get_field('shop_add_semi', 'option');
$title = get_field('shop_add_title', 'option');
$cta = get_field('shop_add_cta', 'option');
$image = get_field('shop_add_side_img', 'option');

if ($show && ($title || $semi_title || $cta || $image)):
    ?>
    <section class="shop-add">
        <div class="container shop-add__container">
            <div class="shop-add__content">
                <?php if ($semi_title): ?>
                    <p class="caption_m"><?= esc_html($semi_title); ?></p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="h2_alternative"><?= esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($cta && isset($cta['url'])): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($cta['url']); ?>" class="theme-buttons__neutral">
                            <?= esc_html($cta['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($image): ?>
                <div class="shop-add__image">
                    <img src="<?= esc_url($image); ?>" alt="<?= esc_attr($title ?: 'Shop Banner'); ?>">
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>