<?php
$text = get_field('shortcode');
if ($text) { ?>

    <section id="shortcodes">
        <div class="container">
            <div class="shortcodes__holder">
                <?= do_shortcode($text); ?>
            </div>
        </div>
    </section>
<?php }
?>