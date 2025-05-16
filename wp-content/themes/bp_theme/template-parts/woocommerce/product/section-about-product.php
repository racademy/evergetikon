<?php
$accordions = get_field('woocommerce_product_accordion');
?>
<?php if ($accordions && !empty($accordions)): ?>
    <div class="section-about-product">
        <div class="container">
            <h2 class="heading-2"><?= esc_html(__('About product', 'bp_theme')); ?></h2>
            <div class="section-about-product__accordions accordions">
                <?php foreach ($accordions as $accordion): ?>
                    <div class="section-about-product__accordion-item accordion-item">
                        <div class="section-about-product__accordion-item--title-wrap accordion-item-heading">
                            <span class="heading-1 transition"><?= esc_html($accordion['title']); ?></span>
                            <svg class="icon-plus" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path d="M11 13H5V11H11V5H13V11H19V13H13V19H11V13Z" fill="#C02324" />
                            </svg>
                            <svg class="icon-minus" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <path d="M4 13V11H20V13H4Z" fill="#C02324" />
                            </svg>
                        </div>
                        <div class="section-about-product__accordion-item--content text accordion-item-content">
                            <?= wp_kses_post($accordion['text']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>