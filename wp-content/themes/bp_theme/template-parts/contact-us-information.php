<?php
$title = get_field('req_title');
$semi_title = get_field('req_semi_title');
$information = get_field('req_information');
$form_id = get_field('req_selected_form');
?>

<section class="contact-us-information">
    <div class="container">
        <div class="contact-us-information__holder">
            <div class="contact-us-information__holder--content">
                <div class="contact-us-information__holder--titles">
                    <?php if ($title): ?>
                        <h2 class="h2_alternative"><?= esc_html($title); ?></h2>
                    <?php endif; ?>

                    <?php if ($semi_title): ?>
                        <p class="body_one_regular"><?= esc_html($semi_title); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($information)): ?>
                    <div class="contact-us-information__items">
                        <?php foreach ($information as $info): ?>
                            <div class="contact-us-information__items--item">
                                <div class="body_one_semibold"><?= esc_html($info['what_info']); ?>
                                </div>
                                <span><?= esc_html($info['info_text']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($form_id): ?>
                <div class="contact-us-information__holder--form">
                    <?= do_shortcode('[contact-form-7 id="' . intval($form_id) . '"]'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>