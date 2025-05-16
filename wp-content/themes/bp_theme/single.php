<?php get_header(); ?>

<div id="scrollProgressBar"></div>

<section class="post-hero">
    <div class="post-hero__holder">
        <div class="post-hero__holder--image-side">
            <?php if (has_post_thumbnail()): ?>
                <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>"
                    alt="<?php the_title_attribute(); ?>">
            <?php endif; ?>
        </div>

        <div class="post-hero__holder--content">
            <?php if (get_the_title()): ?>
                <h1><?= esc_html(get_the_title()); ?></h1>
            <?php endif; ?>

            <div class="post-hero__meta">
                <?php
                $post_content = get_post_field('post_content', get_the_ID());
                $blocks = parse_blocks($post_content);

                $total_words = 0;

                foreach ($blocks as $block) {
                    if (isset($block['attrs']['data']['content'])) {
                        $block_text = wp_strip_all_tags($block['attrs']['data']['content']);
                        $total_words += str_word_count($block_text);
                    }
                }

                $read_time = ceil($total_words / 200);
                ?>

                <span
                    class="post-hero__read-time"><?= esc_html($read_time); ?><?= esc_attr_e('min read', 'bp_theme'); ?></span>
                <svg width="5" height="4" viewBox="0 0 5 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2.606 3.721C2.298 3.721 2.018 3.651 1.766 3.511C1.514 3.36633 1.31333 3.17033 1.164 2.923C1.01467 2.67567 0.94 2.398 0.94 2.09C0.94 1.77733 1.01467 1.49733 1.164 1.25C1.31333 1.00267 1.514 0.809 1.766 0.669C2.018 0.529 2.298 0.459 2.606 0.459C2.89533 0.459 3.16133 0.529 3.404 0.669C3.64667 0.809 3.84033 1.00267 3.985 1.25C4.13433 1.49733 4.209 1.77733 4.209 2.09C4.209 2.398 4.13433 2.67567 3.985 2.923C3.84033 3.17033 3.64667 3.36633 3.404 3.511C3.16133 3.651 2.89533 3.721 2.606 3.721Z"
                        fill="white" />
                </svg>
                <span class="post-hero__date"><?= esc_html(get_the_date('Y-m-d')); ?></span>
            </div>
        </div>
    </div>
</section>

<section id="blog-single">
    <div>
        <?php if (have_posts()):
            while (have_posts()):
                the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-single__post'); ?>>
                    <div class="blog-back-button">
                        <a href="<?= get_post_type_archive_link('post'); ?>" class="blog-single__back">
                            <?php esc_attr_e('Back to list', 'bp_theme'); ?>
                        </a>
                    </div>

                    <div class="blog-single__content">
                        <div class="blog-single__blocks">
                            <?php
                            $blocks = parse_blocks(get_post_field('post_content', get_the_ID()));
                            foreach ($blocks as $block) {
                                echo render_block($block);
                            }
                            ?>
                        </div>

                        <?php
                        $post_question = get_field('post_q');
                        if (!empty($post_question)): ?>
                            <div class="blog-single__question">
                                <h2 class="h2_alternative"><?= esc_html($post_question); ?></h2>
                            </div>
                        <?php endif; ?>

                        <?php if (have_rows('post_source')): ?>
                            <div class="blog-single__sources">
                                <h2><?php esc_attr_e('Sources', 'bp_theme'); ?></h2>
                                <ul class="blog-single__sources-list">
                                    <?php while (have_rows('post_source')):
                                        the_row();
                                        $source_link = get_sub_field('s_link');
                                        if (!empty($source_link)): ?>
                                            <li class="blog-single__source-item">
                                                <a href="<?= esc_url($source_link['url']); ?>"
                                                    target="<?= esc_attr($source_link['target'] ?: '_self'); ?>" class="body_one_regular">
                                                    <?= esc_html($source_link['title']); ?>
                                                </a>
                                            </li>
                                        <?php endif;
                                    endwhile; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; else: ?>
            <p class="blog-single__no-posts"><?php esc_attr_e('Sorry, no content available.', 'bp_theme'); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="section-posts-slider">
    <div class="container">
        <div class="section-products-side-img__wrapper">
            <div class="slider-container-second splide posts-slider-second" aria-label="Product Slider">
                <?php
                $current_post_id = get_the_ID();

                $args = [
                    'posts_per_page' => 10,
                    'post__not_in' => [$current_post_id],
                    'post_type' => 'post',
                    'orderby' => 'date',
                    'order' => 'DESC',
                ];

                $posts = get_posts($args);

                if ($posts): ?>
                    <div class="section-header">
                        <h2><?= esc_attr_e('Other posts', 'bp_theme'); ?></h2>
                    </div>

                    <div class="splide__track">
                        <ul class="splide__list">
                            <?php foreach ($posts as $post):
                                setup_postdata($post); ?>
                                <li class="splide__slide">
                                    <div class="product-card">
                                        <a class="product-card__content" href="<?= esc_url(get_permalink($post->ID)); ?>">
                                            <?php if (has_post_thumbnail($post->ID)): ?>
                                                <div class="product-card__image-wrapper">
                                                    <?= get_the_post_thumbnail($post->ID, 'medium'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="title"><?= esc_html(get_the_title($post->ID)); ?>
                                                <div class="theme-buttons">
                                                    <span
                                                        class="theme-buttons__neutral"><?= esc_attr_e('READ POST', 'bp_theme'); ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            <?php endforeach;
                            wp_reset_postdata(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
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
<script>
    document.addEventListener("scroll", function () {
        const scrollBar = document.getElementById("scrollProgressBar");
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const docHeight =
            document.documentElement.scrollHeight -
            document.documentElement.clientHeight;
        const scrolled = (scrollTop / docHeight) * 100;
        scrollBar.style.width = scrolled + "%";
    });
</script>
<?php get_footer(); ?>