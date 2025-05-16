<?php
global $product;

$thumbnail = get_the_post_thumbnail_url($product->get_id(), 'medium');
$product_obj = wc_get_product($product->get_id());
$product_title = get_the_title($product->get_id());
$product_link = get_permalink($product->get_id());
$extra = get_field('extra_product_tag', $product->get_id());
$price_html = $product_obj->get_price_html();
?>
<li <?php post_class('product_card'); ?>>
    <div class="product-card">
        <?php if (is_product_new($product->get_id(), 14)): ?>
            <span class="badge-new caption_m"><?= esc_attr_e('New', 'bp_theme') ?></span>
        <?php endif; ?>

        <?php if (function_exists('YITH_WCWL')): ?>
            <div class="yith-wcwl-add-button">
                <?= do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . esc_attr($product->get_id()) . '"]'); ?>
            </div>
        <?php endif; ?>

        <a class="product-card__content" href="<?= esc_url($product_link); ?>">
            <?php if ($thumbnail): ?>
                <div class="product-card__image-wrapper">
                    <img src="<?= esc_url($thumbnail); ?>" alt="<?= esc_attr($product_title); ?>">
                </div>
            <?php endif; ?>
            <div class="caption_s"><?= esc_html($extra); ?></div>
            <div class="body_one_regular"><?= esc_html($product_title); ?></div>
            <?php if ($price_html): ?>
                <div class="body_one_semibold"><?= $price_html; ?></div>
            <?php endif; ?>
        </a>

        <?php if ($product_obj->is_purchasable() && $product_obj->is_in_stock()): ?>
            <div class="theme-buttons">
                <a href="?add-to-cart=<?= esc_attr($product->get_id()); ?>" data-quantity="1"
                    data-product_id="<?= esc_attr($product->get_id()); ?>"
                    data-product_sku="<?= esc_attr($product_obj->get_sku()); ?>"
                    class="theme-buttons__neutral ajax_add_to_cart add_to_cart_button" rel="nofollow">
                    <?= esc_html__('ADD TO CART', 'bp_theme'); ?>
                </a>
            </div>
        <?php else: ?>
            <div class="theme-buttons">
                <span class="theme-buttons__out-of-stock">
                    <?= esc_html__('Out of stock', 'bp_theme'); ?>
                </span>
            </div>
        <?php endif; ?>
    </div>
</li>