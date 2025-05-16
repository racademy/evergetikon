<?php
$slider_title = get_field('testimonial_slider_title');
$testimonials = get_field('home_testimonials_slider');
$colab_title = get_field('colab_title');
$colabs = get_field('colab');
?>

<section class="home-testimonial-slider">
    <div class="container">
        <?php if ($slider_title): ?>
            <h2><?= esc_html($slider_title); ?></h2>
        <?php endif; ?>

        <?php if ($testimonials): ?>
            <div class="splide testimonial-splide" aria-label="Testimonials">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <li class="splide__slide">
                                <div class="testimonial-card">
                                    <?php if ($testimonial['home_testimonials_title']): ?>
                                        <span class="title"><?= esc_html($testimonial['home_testimonials_title']); ?></span>
                                    <?php endif; ?>
                                    <?php if ($testimonial['home_testimonials_description']): ?>
                                        <p class="body_one_light">
                                            <?= esc_html($testimonial['home_testimonials_description']); ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="testimonial-card__author">
                                        <?php if ($testimonial['home_testimonials_initials']): ?>
                                            <span
                                                class="testimonial-card__author--initials"><?= esc_html($testimonial['home_testimonials_initials']); ?></span>
                                        <?php endif; ?>
                                        <?php if ($testimonial['home_testimonials_author']): ?>
                                            <span
                                                class="body_one_semibold"><?= esc_html($testimonial['home_testimonials_author']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($colab_title): ?>
            <h2 class="colab-title"><?= esc_html($colab_title); ?></h2>
        <?php endif; ?>

        <?php if ($colabs): ?>
            <div class="colab__logos">
                <?php foreach ($colabs as $colab):
                    $img_url = wp_get_attachment_image_url($colab['colab_img'], 'medium');
                    ?>
                    <?php if ($img_url): ?>
                        <div class="colab__logos--item">
                            <img src="<?= esc_url($img_url); ?>" alt="Colab Logo">
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>