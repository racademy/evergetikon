<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addText('about_us_title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])
        ->addTextarea('about_us_description', [
            'label' => 'Description',
            'wrapper' => ['width' => '50'],
        ])
        ->addImage('about_us_background_image', [
            'label' => 'About us hero image',
            'return_format' => 'id',
            'wrapper' => ['width' => '100'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'About us hero section');

});
