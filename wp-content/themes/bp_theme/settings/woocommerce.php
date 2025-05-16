<?php
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


// Add start of the container
function mytheme_add_container_start()
{
    echo '<div class="container">';
}
add_action('woocommerce_before_main_content', 'mytheme_add_container_start', 10);

// Add end of the container
function mytheme_add_container_end()
{
    echo '</div> <!-- .my-custom-container -->';
}
add_action('woocommerce_after_main_content', 'mytheme_add_container_end', 10);

/* New products badge */
function is_product_new($product_id, $days = 30)
{
    $post_date = get_the_date('U', $product_id);
    $now = current_time('timestamp');
    $diff = $now - $post_date;

    return ($diff < DAY_IN_SECONDS * $days);
}
/* New badge end */

/* Set per page */
add_filter('loop_shop_per_page', function ($cols) {
    return 8;
}, 20);

/* set per page end */

add_action('wp_footer', 'force_open_coupon_block_and_translate', 100);

function force_open_coupon_block_and_translate()
{
    if (is_checkout() || is_cart()) {
        ?>
        <script>
            function translateCouponElements() {
                const buttons = document.querySelectorAll('[role="button"]');
                buttons.forEach(btn => {
                    if (btn.textContent.includes('Sukurti nuolaidą')) {
                        btn.childNodes[1].textContent = 'Pridėti kuponą';
                    }
                });

                const expandBtn = Array.from(buttons).find(
                    btn => btn.textContent.includes('Pridėti kuponą') && btn.getAttribute('aria-expanded') === 'false'
                );
                if (expandBtn) {
                    expandBtn.click();
                }

                const label = document.querySelector('label[for="wc-block-components-totals-coupon__input-coupon"]');
                if (label && label.textContent === 'Enter code') {
                    label.textContent = 'Įveskite kodą';
                }
            }

            translateCouponElements();

            const observer = new MutationObserver(() => {
                translateCouponElements();
            });
            observer.observe(document.body, { childList: true, subtree: true });

            document.addEventListener('click', function (e) {
                const couponForm = document.querySelector('.wp-block-woocommerce-checkout-order-summary-coupon-form-block');
                const input = document.querySelector('input.woocommerce-block-components-coupon-form__input');
                if (couponForm && input && !couponForm.contains(e.target)) {
                    input.blur();
                }
            });
        </script>
        <?php
    }
}

