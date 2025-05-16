<?php
$discount_title = get_field('discount_title', 'option');
$discount_description = get_field('discount_description', 'option');
$company_details = get_field('company_details', 'option');
$email = get_field('email', 'option');
$phone = get_field('phone', 'option');
$social_media = get_field('social_media', 'option');
$payments = get_field('payments', 'option');
?>

<button id="scrollToTopBtn" class="scroll-to-top" aria-label="Scroll to top">
    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M17.7566 13.8284L16.87 14.715L9.99995 7.84419L3.12995 14.715L2.24329 13.8284L9.99995 6.07169L17.7566 13.8284Z"
            fill="white" />
    </svg>
</button>

<footer>
    <div class="container">
        <div class="site-footer">
            <div class="footer-top">
                <div class="footer-top__inner">
                    <div class="footer-top__inner--discount-info">
                        <?php if ($discount_title): ?>
                            <span class="title"><?= esc_html($discount_title); ?></span>
                        <?php endif; ?>
                        <?php if ($discount_description): ?>
                            <span class="body_one_light"><?= esc_html($discount_description); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="footer-top__inner--form">
                        <?php echo do_shortcode('[newsletter_form]'); ?>
                    </div>
                </div>
            </div>

            <div class="footer-middle">
                <div class="footer-middle__inner">
                    <div class="footer-middle__inner--menu">
                        <?php
                        wp_nav_menu([
                            'theme_location' => 'menu-footer',
                            'menu_class' => 'footer-nav',
                            'container' => false,
                        ]);
                        ?>
                    </div>

                    <div class="footer-middle__inner--company-details">
                        <?php if ($company_details): ?>
                            <ul class="company-info-list">
                                <li class="body_one_semibold"><?= esc_attr_e('Requisites', 'bp_theme'); ?></li>
                                <?php foreach ($company_details as $detail): ?>
                                    <li class="body_one_light"><?= esc_html($detail['info']); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom__inner">

                    <div class="footer-bottom__inner--social-media">
                        <?php if ($social_media): ?>
                            <ul class="social-media-list">
                                <?php foreach ($social_media as $media): ?>
                                    <li>
                                        <a href="<?= esc_url($media['media_name']); ?>" target="_blank">
                                            <?php if ($media['icon']): ?>
                                                <img src="<?= esc_url($media['icon']); ?>" alt="Social Media Icon">
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="copyright">
                            <p><?= date('Y'); ?> &copy; EVERGETIKON |
                                <?= esc_attr_e('ALL RIGHTS RESERVED', 'bp_theme'); ?>.
                            </p>
                        </div>
                    </div>


                    <div class="footer-bottom__inner--created-by-payments">
                        <div class="created-by">
                            <p>
                                <?= esc_attr_e('Created by', 'bp_theme'); ?>:
                                <a href="<?= esc_attr_e('https://brightprojects.io/', 'bp_theme'); ?>"
                                    target="_blank"><?= esc_attr_e('Bright Projects', 'bp_theme'); ?>
                                </a>
                            </p>
                        </div>

                        <div class="payments">
                            <?php if ($payments): ?>
                                <ul class="payment-icons">
                                    <?php foreach ($payments as $payment): ?>
                                        <li>
                                            <?php if ($payment['icon']): ?>
                                                <img src="<?= esc_url($payment['icon']); ?>" alt="Payment Method">
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    /* Translate dynamic WooCommerce strings */
    if (document.documentElement.lang === "lt-LT") {
        const observer = new MutationObserver(() => {
            // Translate "Delivery"
            document.querySelectorAll('.wc-block-components-totals-item__label').forEach(el => {
                if (el.textContent.trim() === "Delivery") {
                    el.textContent = "Pristatymas";
                }
            });

            // Translate "Your payment information is incomplete."
            document.querySelectorAll('.wc-block-components-notice-banner__content div').forEach(el => {
                if (el.textContent.trim() === "Your payment information is incomplete.") {
                    el.textContent = "Jūsų mokėjimo informacija yra neišsami.";
                }
            });

            // Translate "You are currently checking out as a guest."
            const guestNotice = document.getElementById("wc-guest-checkout-notice");
            if (guestNotice && guestNotice.textContent.trim() === "You are currently checking out as a guest.") {
                guestNotice.textContent = "Šiuo metu atsiskaitote kaip svečias.";
            }

            // Translate "There are no products in the cart!"
            document.querySelectorAll('.woofc-no-item').forEach(el => {
                if (el.textContent.trim() === "There are no products in the cart!") {
                    el.textContent = "Krepšelis tuščias!";
                }
            });

        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
</script>

<?php wp_footer(); ?>
</body>

</html>