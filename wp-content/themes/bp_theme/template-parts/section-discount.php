<?php
$display_discount = get_field('display_discount_section', 'option');
$discount_text = get_field('discount_text', 'option');

if ($display_discount): ?>
    <section class="discount-section">
        <div class="container">
            <?php if ($discount_text): ?>
                <span class="caption_m"><?= esc_html($discount_text); ?></span>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>