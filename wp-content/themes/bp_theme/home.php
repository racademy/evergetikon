<?php get_header(); ?>

<?php
$title = get_field('about_us_title', 'option');
$description = get_field('about_us_description', 'option');
$image = get_field('about_us_background_image', 'option');
$image_url = wp_get_attachment_image_url($image, 'full', 'option');
?>

<section class="post-hero">
    <div class="post-hero__holder">
        <div class="post-hero__holder--image-side">
            <?php if ($image_url): ?>
                <img src="<?= esc_url($image_url); ?>" alt="Post hero image">
            <?php endif; ?>
        </div>
        <div class="post-hero__holder--content">
            <?php if ($title): ?>
                <h1><?= esc_html($title); ?></h1>
            <?php endif; ?>
            <?php if ($description): ?>
                <span class="subtitle_s_light"><?= esc_html($description); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="blog-archive">
    <div class="blog-archive__container">
        <div class="blog-archive__list">
            <?php
            if (have_posts()):
                $total_posts = $wp_query->found_posts;
                $current_page = max(1, get_query_var('paged'));
                $posts_per_page = get_query_var('posts_per_page') ?: get_option('posts_per_page');
                $start_post = ($current_page - 1) * $posts_per_page + 1;
                $end_post = min($start_post + $posts_per_page - 1, $total_posts);

                while (have_posts()):
                    the_post();
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('blog-archive__item'); ?>>
                        <?php if ($image_url): ?>
                            <div class="blog-archive__image" style="background-image: url('<?= esc_url($image_url); ?>');">
                            </div>
                        <?php endif; ?>

                        <div class="blog-archive__content">
                            <div class="blog-archive__categories">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)):
                                    foreach ($categories as $category):
                                        echo '<span class="caption_m">' . esc_html($category->name) . '</span>';
                                    endforeach;
                                endif;
                                ?>
                            </div>

                            <h2 class="h2_alternative">
                                <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                            </h2>

                            <div class="subtitle_s_light">
                                <?php
                                $post_content = get_post_field('post_content', get_the_ID());
                                $blocks = parse_blocks($post_content);

                                foreach ($blocks as $block) {
                                    if ($block['blockName'] === 'acf/section-content') {
                                        $acf_content = isset($block['attrs']['data']['content']) ? $block['attrs']['data']['content'] : '';
                                        if (!empty($acf_content)) {
                                            $excerpt = wp_trim_words(wp_strip_all_tags($acf_content), 40, '...');
                                            echo wp_kses_post($excerpt);
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="theme-buttons">
                                <a href="<?php the_permalink(); ?>" class="theme-buttons__neutral">
                                    <?php esc_attr_e('READ POST', 'bp_theme'); ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>

                <div class="blog-archive__info-pagination-wrapper">
                    <div class="blog-archive__info">
                        <?= sprintf(__('SHOWING %d–%d OF %d', 'bp_theme'), $start_post, $end_post, $total_posts); ?>
                    </div>

                    <div class="blog-archive__pagination">
                        <?php
                        the_posts_pagination([
                            'mid_size' => 2,
                            'prev_text' => __('<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.9999 21.308L6.69189 12L15.9999 2.69199L17.0639 3.75599L8.81889 12L17.0629 20.244L15.9999 21.308Z" fill="black"/>
                                </svg>
                            '),
                            'next_text' => __('<svg width="44" height="41" viewBox="0 0 44 41" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18.0064 29.8079L16.9424 28.7439L25.1874 20.4999L16.9424 12.2559L18.0064 11.1919L27.3144 20.4999L18.0064 29.8079Z" fill="black"/>
                            </svg>'
                            ),
                        ]);
                        ?>
                    </div>
                </div>

            <?php else: ?>
                <p class="blog-archive__no-posts"><?php esc_attr_e('Sorry, no posts found.', 'bp_theme'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>