<?php
get_header(); ?>

<main id="primary" class="search-results">
    <div class="container">
        <h1 class="page-title">
            <?php
            printf(esc_html__('Search Results for: %s', 'bp_theme'), '<span>' . get_search_query() . '</span>');
            ?>
        </h1>

        <div class="search-results">
            <?php if (have_posts()): ?>
                <?php
                $paged = max(1, get_query_var('paged'));
                $posts_per_page = get_query_var('posts_per_page') ?: get_option('posts_per_page');
                $total_products = $wp_query->found_posts;
                $start_post = ($paged - 1) * $posts_per_page + 1;
                $end_post = min($start_post + $posts_per_page - 1, $total_products);
                ?>

                <div class="products-list">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <?php if ('product' === get_post_type()):
                            global $product;
                            if (!$product instanceof WC_Product) {
                                $product = wc_get_product(get_the_ID());
                            }

                            $product_id = $product->get_id();
                            $product_link = get_permalink($product_id);
                            $thumbnail = get_the_post_thumbnail_url($product_id, 'medium');
                            $product_title = get_the_title($product_id);
                            $price_html = $product->get_price_html();
                            $extra = '';
                            ?>
                            <div class="product-card">
                                <?php if (function_exists('is_product_new') && is_product_new($product_id, 14)): ?>
                                    <span class="badge-new caption_m"><?= esc_html__('New', 'bp_theme'); ?></span>
                                <?php endif; ?>

                                <?php if (function_exists('YITH_WCWL')): ?>
                                    <div class="yith-wcwl-add-button">
                                        <?= do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . esc_attr($product_id) . '"]'); ?>
                                    </div>
                                <?php endif; ?>

                                <a class="product-card__content" href="<?= esc_url($product_link); ?>">
                                    <?php if ($thumbnail): ?>
                                        <div class="product-card__image-wrapper">
                                            <img src="<?= esc_url($thumbnail); ?>" alt="<?= esc_attr($product_title); ?>">
                                        </div>
                                    <?php else: ?>
                                        <div class="product-card__image-wrapper">
                                            <img src="/wp-content/uploads/woocommerce-placeholder.png" alt="Default image">
                                        </div>
                                    <?php endif; ?>
                                    <div class="caption_s"><?= esc_html($extra); ?></div>
                                    <div class="body_one_regular"><?= esc_html($product_title); ?></div>
                                    <?php if ($price_html): ?>
                                        <div class="body_one_semibold"><?= $price_html; ?></div>
                                    <?php endif; ?>
                                </a>

                                <?php if ($product->is_purchasable() && $product->is_in_stock()): ?>
                                    <div class="theme-buttons">
                                        <a href="?add-to-cart=<?= esc_attr($product_id); ?>" data-quantity="1"
                                            data-product_id="<?= esc_attr($product_id); ?>"
                                            data-product_sku="<?= esc_attr($product->get_sku()); ?>"
                                            class="theme-buttons__neutral ajax_add_to_cart add_to_cart_button" rel="nofollow">
                                            <?= esc_html__('ADD TO CART', 'bp_theme'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

                <div class="blog-archive__info-pagination-wrapper">
                    <div class="blog-archive__info">
                        <?= sprintf(__('SHOWING %d–%d OF %d', 'bp_theme'), $start_post, $end_post, $total_products); ?>
                    </div>
                    <div class="blog-archive__pagination">
                        <?php
                        the_posts_pagination([
                            'mid_size' => 2,
                            'prev_text' => __('<svg width="24" height="24"><path d="M15.9999 21.308L6.69189 12L15.9999 2.69199L17.0639 3.75599L8.81889 12L17.0629 20.244L15.9999 21.308Z" fill="black"/></svg>', 'bp_theme'),
                            'next_text' => __('<svg width="44" height="41"><path d="M18.0064 29.8079L16.9424 28.7439L25.1874 20.4999L16.9424 12.2559L18.0064 11.1919L27.3144 20.4999L18.0064 29.8079Z" fill="black"/></svg>', 'bp_theme'),
                        ]);
                        ?>
                    </div>
                </div>

                <?php
            else:
                echo '<p>' . esc_html__('No results found', 'bp_theme') . '</p>';
            endif;
            ?>
        </div>
    </div>
</main>
<?php
get_footer();
