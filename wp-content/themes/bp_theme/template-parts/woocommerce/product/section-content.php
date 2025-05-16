<?php
global $product;
$product_id = get_the_ID();

$product = wc_get_product($product_id);
$product_title = $product->get_name();
$product_short_description = wpautop($product->get_short_description());
$product_description = wpautop($product->get_description());

$product_images = $product->get_gallery_image_ids();
$product_categories = wc_get_product_category_list($product_id);
$product_tags = wc_get_product_tag_list($product_id);
$product_accordions = get_field('woocommerce_settings_accordion');
$extra = get_field('extra_product_tag', $product_id);
$price_extra = get_field('price_per_ml', $product_id);

// Get featured image
$featured_image_id = $product->get_image_id();
$featured_image_url = wp_get_attachment_image_url($featured_image_id, 'full');
$is_variable = $product->is_type('variable');

?>


<div class="single-product-section">
    <div class="container">
        <div class="single-product-section__row">
            <div class="single-product-section__left">
                <?php if (empty($product_images)): ?>
                    <?php if ($featured_image_url): ?>
                        <div class="single-image">
                            <img src="<?= esc_url($featured_image_url); ?>" alt="<?= esc_attr($product_title); ?>">
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="splide splide--main" id="main-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php if ($featured_image_url): ?>
                                    <li class="splide__slide">
                                        <a href="<?= esc_url($featured_image_url); ?>" data-lightbox="product-gallery">
                                            <img src="<?= esc_url($featured_image_url); ?>"
                                                alt="<?= esc_attr($product_title); ?>">
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php foreach ($product_images as $image_id):
                                    $full_image_url = wp_get_attachment_image_url($image_id, 'full');
                                    if ($full_image_url === $featured_image_url)
                                        continue;
                                    ?>
                                    <li class="splide__slide">
                                        <a href="<?= esc_url($full_image_url); ?>" data-lightbox="product-gallery">
                                            <img src="<?= esc_url($full_image_url); ?>" alt="<?= esc_attr($product_title); ?>">
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="splide splide--thumbs" id="thumbnail-slider">
                        <div class="splide__track">
                            <ul class="splide__list">
                                <?php if ($featured_image_url): ?>
                                    <li class="splide__slide">
                                        <img src="<?= esc_url($featured_image_url); ?>"
                                            alt="<?= esc_attr($product_title); ?> thumbnail">
                                    </li>
                                <?php endif; ?>
                                <?php foreach ($product_images as $image_id):
                                    $thumb_url = wp_get_attachment_image_url($image_id, 'full'); ?>
                                    <li class="splide__slide">
                                        <img src="<?= esc_url($thumb_url); ?>" alt="<?= esc_attr($product_title); ?> thumbnail">
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <button class="open-gallery-lightbox" aria-label="Open product image gallery">
                        <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="44" height="44" rx="22" fill="white" fill-opacity="0.5" />
                            <path
                                d="M29.5 29.5L25.875 25.875M21.1667 18.6667V23.6667M18.6667 21.1667H23.6667M27.8333 21.1667C27.8333 24.8486 24.8486 27.8333 21.1667 27.8333C17.4848 27.8333 14.5 24.8486 14.5 21.1667C14.5 17.4848 17.4848 14.5 21.1667 14.5C24.8486 14.5 27.8333 17.4848 27.8333 21.1667Z"
                                stroke="#61615F" stroke-linecap="square" stroke-linejoin="round" />
                        </svg>
                    </button>
                <?php endif; ?>
            </div>


            <div class="single-product-section__right">
                <div class="caption_l"><?= esc_html($extra); ?></div>

                <h1><?= esc_html($product_title); ?></h1>
                <div class="single-product-section__price">
                    <?php
                    $regular_price = $product->get_regular_price();
                    $sale_price = $product->get_sale_price();

                    if ($product->is_on_sale() && !empty($sale_price)) {
                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                        $savings = wc_price($regular_price - $sale_price);
                        ?>
                        <div class="discount">
                            <div class="discount__bar">
                                <del class="discount__regular-price"><?= wc_price($regular_price); ?></del>
                                <span class="discount__savings">-<?= $percentage; ?>%
                                    (sutaupote&nbsp;<?= $savings; ?>)</span>
                            </div>
                            <span class="discount__current-price">
                                <?= wc_price($sale_price); ?>
                                <span class="price_per_ml"><?= wp_kses_post($price_extra); ?></span>
                            </span>
                            <div class="caption_s"><?php esc_attr_e('With taxes', 'bp_theme'); ?></div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <span class="discount__current-price">
                            <?= wc_price($regular_price); ?>
                            <span class="price_per_ml"><?= wp_kses_post($price_extra); ?></span>
                        </span>
                        <div class="caption_s"><?php esc_attr_e('With taxes', 'bp_theme'); ?></div>
                        <?php
                    }
                    ?>
                </div>
                <?php if ($is_variable): ?>
                    <select name="variation_id" id="variation_select" class="variation_select">
                        <?php
                        $variations = $product->get_available_variations();
                        foreach ($variations as $key => $variation) {
                            $variation_id = $variation['variation_id'];
                            $variable_product1 = new WC_Product_Variation($variation_id);

                            $formatted_attributes = [];
                            foreach ($variation['attributes'] as $attr_key => $attr_value) {
                                $taxonomy = str_replace('attribute_', '', $attr_key);

                                $term = get_term_by('slug', $attr_value, $taxonomy);

                                if ($term && !is_wp_error($term)) {
                                    $formatted_attributes[] = esc_html($term->name);
                                } else {
                                    $formatted_attributes[] = ucfirst($attr_value);
                                }
                            }

                            $option_text = implode(' / ', $formatted_attributes);
                            $selected = $key === 0 ? ' selected' : '';
                            echo "<option value='{$variation_id}'{$selected}>{$option_text}</option>";
                        }

                        ?>
                    </select>
                <?php endif; ?>
                <?php if (!empty($product_short_description)): ?>
                    <div class="single-product-section__short-description text description-block" data-readmore
                        data-readmore-label="<?= esc_attr__('Read more', 'bp_theme'); ?>"
                        data-readless-label="<?= esc_attr__('Read less', 'bp_theme'); ?>">
                        <?= wp_kses_post($product_short_description); ?>
                    </div>
                <?php endif; ?>

                <div class="single-product-section__cart-btn">
                    <form class="cart"
                        action="<?= esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
                        method="post" enctype='multipart/form-data'>
                        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                        <div class="single-product-section__qty quantity">
                            <button type="button" class="single-product-section__qty-button minus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21"
                                    fill="none">
                                    <path d="M3.33325 11.3333V9.66663H16.6666V11.3333H3.33325Z" fill="#002E60" />
                                </svg>
                            </button>
                            <input type="text" id="quantity_<?= esc_attr($product_id); ?>"
                                class="input-text single-product-section__qty--input qty text" step="1" min="1"
                                max="<?= esc_attr($product->get_max_purchase_quantity()); ?>" name="quantity" value="1"
                                title="<?= esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>"
                                size="4" pattern="[0-9]*" inputmode="numeric" />
                            <button type="button" class="single-product-section__qty-button plus">
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9.16675 11.3333H4.16675V9.66663H9.16675V4.66663H10.8334V9.66663H15.8334V11.3333H10.8334V16.3333H9.16675V11.3333Z"
                                        fill="#002E60" />
                                </svg>
                            </button>
                        </div>
                        <?php $base_price = $product->get_price(); ?>
                        <button type="submit" name="add-to-cart" value="<?= esc_attr($product->get_id()); ?>"
                            class="single_add_to_cart_button button alt"
                            data-base-price="<?= esc_attr($base_price); ?>"><?= esc_attr_e('ADD TO CART', 'bp_theme') . '·' . wc_price($base_price); ?>
                        </button>
                        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                    </form>
                    <?= do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . esc_attr($product_id) . '"]'); ?>
                </div>

                <div class="single-product-section__categories">
                    <?php $product_points = get_field('product_points', $product_id);

                    if (!empty($product_points)):
                        $points = array_filter(array_column($product_points, 'point'));
                        if (!empty($points)):
                            ?>
                            <div class="product-extra-points">
                                <?= implode(
                                    '<span class="sep" style="margin: 0 10px;">·</span>',
                                    array_map('esc_html', $points)
                                ); ?>
                            </div>
                            <?php
                        endif;
                    endif;
                    ?>
                </div>

                <div class="single-product-section__accordions accordions">
                    <?php if ($product_description): ?>
                        <div class="single-product-section__accordion-item accordion-item ">
                            <div class="single-product-section__accordion-item--title-wrap accordion-item-heading">
                                <span class="heading-1"><?= esc_html(__('Description', 'bp_theme')); ?></span>
                                <svg class="icon-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 12.5H6V11.5H11.5V6H12.5V11.5H18V12.5H12.5V18H11.5V12.5Z" fill="black" />
                                </svg>

                                <svg class="icon-minus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 12.5V11.5H17V12.5H7Z" fill="black" />
                                </svg>
                            </div>
                            <div
                                class="single-product-section__accordion-item--content text description-block accordion-item-content">
                                <?= $product_description; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    if ($product_accordions):
                        foreach ($product_accordions as $accordion):
                            $title = $accordion['title'];
                            $text = $accordion['text'];
                            ?>
                            <?php if (!empty($title) && !empty($text)): ?>
                                <div class="single-product-section__accordion-item accordion-item">
                                    <div class="single-product-section__accordion-item--title-wrap accordion-item-heading">
                                        <span class="heading-1"><?= esc_html($title) ?></span>
                                        <svg class="icon-plus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.5 12.5H6V11.5H11.5V6H12.5V11.5H18V12.5H12.5V18H11.5V12.5Z" fill="black" />
                                        </svg>

                                        <svg class="icon-minus" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 12.5V11.5H17V12.5H7Z" fill="black" />
                                        </svg>
                                    </div>
                                    <div
                                        class="single-product-section__accordion-item--content text description-block accordion-item-content">
                                        <?= wp_kses_post($text); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function ($) {

        function updatePrice(variation_id) {
            $.ajax({
                type: 'POST',
                url: '<?= admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'update_variation_price',
                    variation_id: variation_id,
                },
                success: function (response) {
                    $('.single-product-section__price').html(response);
                }
            });
        }

        $('#variation_select').on('change', function () {
            let selectedVariation = $(this).val();
            updatePrice(selectedVariation);

            // Update add-to-cart button value
            $('button.single_add_to_cart_button').val(selectedVariation);
        });

        // Trigger change for the default selected variation on page load
        $('#variation_select').trigger('change');

        // Add hidden gallery links for Lightbox2
        var galleryHtml = '';
        $('.single-product-section__gallery-image img').each(function (index) {
            var src = $(this).data('lightbox-src');
            var alt = $(this).attr('alt');
            galleryHtml += '<a href="' + src + '" data-lightbox="product-gallery" data-title="' + alt + '" class="hidden-gallery-link" style="display:none;">' + index + '</a>';
        });
        $('body').append(galleryHtml);

        $('.accordion-item').each(function () {
            var $accordionItem = $(this);
            var $content = $accordionItem.find('.accordion-item-content');

            if ($accordionItem.hasClass('active')) {
                $content.show(); // Show the content if the item has 'active' class
            } else {
                $content.hide(); // Otherwise, ensure it's hidden
            }
        });

        // Accordion toggle behavior on click
        $('.accordion-item-heading').on('click', function () {
            var $accordionItem = $(this).closest('.accordion-item');
            var $content = $accordionItem.find('.accordion-item-content');

            $accordionItem.toggleClass('active');
            $content.stop().slideToggle();

            $(this).closest('.accordions').find('.accordion-item').not($accordionItem).removeClass('active').find('.accordion-item-content').slideUp();
        });


        // Handle quantity buttons
        $(document).on("click", ".single-product-section__qty-button.plus", function () {
            var $input = $(this).closest(".quantity").find(".qty");
            var currentVal = parseInt($input.val(), 10);
            if (isNaN(currentVal) || currentVal < 1) currentVal = 1;

            var maxVal = parseInt($input.attr("max"), 10);

            if (isNaN(maxVal) || maxVal === -1 || currentVal < maxVal) {
                $input.val(currentVal + 1).trigger("change");
            }
        });

        $(document).on("click", ".single-product-section__qty-button.minus", function () {
            var $input = $(this).closest(".quantity").find(".qty");
            var currentVal = parseInt($input.val(), 10);
            if (isNaN(currentVal) || currentVal <= 1) {
                $input.val(1).trigger("change");
                return;
            }

            $input.val(currentVal - 1).trigger("change");
        });

        // Update button label with total price
        const quantityInputs = document.querySelectorAll(".single-product-section__qty--input");

        quantityInputs.forEach(input => {
            const form = input.closest("form.cart");
            const button = form.querySelector(".single_add_to_cart_button");
            const basePrice = parseFloat(button.getAttribute("data-base-price"));

            function updateButtonLabel() {
                let qty = parseInt(input.value, 10);
                if (isNaN(qty) || qty < 1) qty = 1;

                const total = (basePrice * qty).toFixed(2);
                button.innerHTML = `<?= esc_html__('ADD TO CART', 'bp_theme'); ?> · ${woocommerce_format_money(total)}`;
            }

            input.addEventListener("input", updateButtonLabel);
            input.addEventListener("change", updateButtonLabel);

            ["plus", "minus"].forEach(className => {
                const btn = form.querySelector(`.single-product-section__qty-button.${className}`);
                if (btn) {
                    btn.addEventListener("click", function () {
                        setTimeout(updateButtonLabel, 10);
                    });
                }
            });

            updateButtonLabel();
        });

        function woocommerce_format_money(amount) {
            return amount + "<?= get_woocommerce_currency_symbol(); ?>";
        }
    });
</script>