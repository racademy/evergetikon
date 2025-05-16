<?php
$title = get_field('title');
$description = get_field('description');
$our_values_repeater = get_field('our_values_repeater');
$read_all_story = get_field('read_all_story');
?>

<section class="home-our-values">
    <div class="container">
        <div class="home-our-values__holder">
            <div class="home-our-values__holder--titles">
                <h2><?= esc_html($title); ?></h2>
                <p class="body_one_light"><?= esc_html($description); ?></p>
            </div>

            <div class="home-our-values__holder--values">
                <?php if ($our_values_repeater): ?>
                    <?php foreach ($our_values_repeater as $value_item): ?>
                        <div class="values-item">
                            <img src="<?= esc_url($value_item['icon']); ?>" alt="">
                            <p><?= esc_html($value_item['text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if ($read_all_story): ?>
                <div class="theme-buttons">
                    <a href="<?= esc_url($read_all_story['url']); ?>" class="theme-buttons__neutral">
                        <?= esc_html($read_all_story['title']); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>