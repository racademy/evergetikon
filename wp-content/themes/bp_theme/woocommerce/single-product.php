<?php
/**
 * Custom Single Product Template
 *
 * @package     YourTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header('shop');
?>

<!-- Extra shipping information over top -->

<!-- Main information of product -->
<div class="product-page">
    <div class="product-page__holder">
        <!-- Products content -->
        <?php get_template_part('template-parts/woocommerce/product/section-content'); ?>

        <!-- Slider related products -->
        <?php get_template_part('template-parts/woocommerce/components/slider'); ?>

        <!-- Testimonials -->
        <?php get_template_part('template-parts/woocommerce/components/testimonials'); ?>

        <!-- Faq -->
        <?php get_template_part('template-parts/woocommerce/components/faq'); ?>

        <!-- Slider from options -->
        <?php get_template_part('template-parts/woocommerce/components/slider-option'); ?>

        <!-- Our promise -->
        <?php get_template_part('template-parts/woocommerce/components/our-promise'); ?>
    </div>
</div>

<?php get_footer('shop');