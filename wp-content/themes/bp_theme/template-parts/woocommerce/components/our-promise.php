<?php
$section_title = get_field('our_promise_title', 'option');
$our_promises = get_field('our_promises_rep', 'option');

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