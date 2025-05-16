<?php
/**
 * The Template for displaying product archives, including the main shop page
 *
 * Create this file at: your-theme/woocommerce/archive-product.php
 */

defined('ABSPATH') || exit;

get_header('shop');

?>
<div class="shop-page">
    <!-- Shop heading -->
    <?php get_template_part('template-parts/woocommerce/shop/section-heading'); ?>

    <!-- Main information of product -->
    <?php get_template_part('template-parts/woocommerce/shop/section-products'); ?>

    <!-- Testimonials -->
    <?php get_template_part('template-parts/woocommerce/components/testimonials'); ?>

    <!-- Faq -->
    <?php get_template_part('template-parts/woocommerce/components/faq'); ?>

    <!-- Slider from options -->
    <?php get_template_part('template-parts/woocommerce/components/slider-option'); ?>

    <!-- Our promise -->
    <?php get_template_part('template-parts/woocommerce/components/our-promise'); ?>
</div>

<?php
get_footer('shop');