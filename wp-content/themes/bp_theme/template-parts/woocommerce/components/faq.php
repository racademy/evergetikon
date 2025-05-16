<?php
?>
<section class="shop-section-questions">
    <div class="container">
        <?php
        $faq_section_title = get_field('frequently_questions_title', 'option');
        $faq_items = get_field('frequently_questions', 'option');

        if ($faq_items): ?>
            <div class="shop-section-questions__holder">
                <h2><?php echo esc_html($faq_section_title); ?></h2>
                <div class="faq-items">
                    <?php foreach ($faq_items as $index => $faq):
                        $question = $faq['frequently_questions_title'];
                        $answer = $faq['frequently_questions_answer'];
                        ?>
                        <div class="faq-item " data-index="<?php echo $index; ?>">
                            <h3 class="faq-question body_one_semibold">
                                <?php echo esc_html($question); ?>
                                <span class="toggle-btn">+</span>
                            </h3>
                            <div class="faq-answer body_one_regular" style="display: none;">
                                <?php echo esc_html($answer); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>