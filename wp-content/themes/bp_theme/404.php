<?php
get_header();

$title = get_field('title_not_found', 'options');
$description = get_field('description_not_found', 'options');
$link_products = get_field('link_products', 'options');
$link_history = get_field('link_history', 'options');
?>

<section class="not-found">
    <div class="container">
        <div class="text">
            <?php if ($title): ?>
                <h1><?= esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if ($description): ?>
                <span class="subtitle_s_light"><?= esc_html($description); ?></span>
            <?php endif; ?>

            <div class="not-found__links">
                <?php if ($link_products): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($link_products['url']); ?>" class="theme-buttons__brown">
                            <?= esc_html($link_products['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($link_history): ?>
                    <div class="theme-buttons">
                        <a href="<?= esc_url($link_history['url']); ?>" class="theme-buttons__white">
                            <?= esc_html($link_history['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="vector-bg-not-found"></div>
</section>

<?php
$section_title = get_field('our_promise_title', 'options');
$our_promises = get_field('our_promises_rep', 'options');

if ($section_title || $our_promises): ?>
    <section class="our-promises">
        <div class="container">
            <?php if ($section_title): ?>
                <h2><?= esc_html($section_title); ?></h2>
            <?php endif; ?>

            <?php if ($our_promises && is_array($our_promises)): ?>
                <div class="our-promises__list">
                    <?php foreach ($our_promises as $promise):
                        $title = $promise['title'] ?? '';
                        $description = $promise['description'] ?? '';
                        $link = $promise['link'] ?? null;
                        ?>
                        <div class="our-promises__list--item">
                            <?php if ($title): ?>
                                <span class="title"><?= esc_html($title); ?></span>
                            <?php endif; ?>

                            <?php if ($description): ?>
                                <p class="body_one_light"><?= esc_html($description); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($link['url'])): ?>
                                <div class="theme-buttons">
                                    <a class="theme-buttons__neutral" href="<?= esc_url($link['url']); ?>"
                                        target="<?= esc_attr($link['target'] ?? '_self'); ?>">
                                        <?= esc_html($link['title']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>

<?php get_footer() ?>