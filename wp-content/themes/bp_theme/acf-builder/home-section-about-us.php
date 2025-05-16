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
        ->addLink('about_us_read', [
            'label' => 'About Us Read Full Story',
            'wrapper' => ['width' => '50'],
        ])
        ->addImage('about_us_bg_image', [
            'label' => 'About Us Background Image',
            'return_format' => 'id',
            'wrapper' => ['width' => '50'],

        ])
        ->addText('signature', [
            'label' => 'Signature',
            'wrapper' => ['width' => '100'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home section about us');

});
