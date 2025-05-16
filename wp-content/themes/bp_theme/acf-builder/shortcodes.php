<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields
        ->addText('shortcode', [
            'label' => 'Shortcode Text',
            'instructions' => 'You can enter plain text or a shortcode like [example_shortcode]',
            'wrapper' => ['width' => '100'],
        ])
        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Woocommerce shortcodes');

});
