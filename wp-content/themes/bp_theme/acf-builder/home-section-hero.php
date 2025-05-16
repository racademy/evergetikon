<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addText('hero_section_title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])
        ->addTextarea('hero_section_description', [
            'label' => 'Description',
            'wrapper' => ['width' => '50'],
        ])
        ->addLink('hero_section_check_products', [
            'label' => 'Check out products',
            'wrapper' => ['width' => '50'],
        ])
        ->addImage('hero_section_background_image', [
            'label' => 'Hero Background Image',
            'return_format' => 'id',
            'wrapper' => ['width' => '50'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home hero section');

});
