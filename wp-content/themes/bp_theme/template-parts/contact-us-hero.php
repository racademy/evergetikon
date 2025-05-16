<?php
$description = get_field('contact_us_description');
$bg_image_id = get_field('contact_us_background_image');
$bg_image_url = wp_get_attachment_image_url($bg_image_id, 'full');
$contacts = get_field('contact_us_co');
?>

<section class="contact-us-hero">
    <img class="contact-bg-img" src="<?= esc_url($bg_image_url); ?>" alt="Background image">
    <div class="container">
        <div class="contact-us-hero__overlay">

            <div class="contact-us-hero__overlay--titles">
                <h1><?= esc_html(get_the_title()); ?></h1>

                <?php if ($description): ?>
                    <p class="body_one_regular"><?= esc_html($description); ?></p>
                <?php endif; ?>
            </div>

            <?php if (!empty($contacts)): ?>
                <div class="contact-us-hero__contacts">
                    <?php foreach ($contacts as $contact): ?>
                        <div class="contact-us-hero__contacts--item">
                            <?php if (!empty($contact['icon'])): ?>
                                <div class="contact-image">
                                    <img src="<?= esc_url($contact['icon']); ?>" alt="Icon" />
                                </div>
                            <?php endif; ?>

                            <div class="contact-info">
                                <?php if (!empty($contact['contact_us_label'])): ?>
                                    <span class="body_one_semibold">
                                        <?= esc_html($contact['contact_us_label']); ?>
                                    </span>
                                <?php endif; ?>
                                <?php if (!empty($contact['contact_us_text'])): ?>
                                    <div class="body_one_light">
                                        <?= esc_html($contact['contact_us_text']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>