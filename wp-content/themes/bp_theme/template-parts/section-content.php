<?php
$text = get_field('content');
if ($text) { ?>
    <div class="blog-single">
        <div class="blog-single__container">
            <?= wp_kses_post($text); ?>
        </div>
    </div>
<?php }
?>