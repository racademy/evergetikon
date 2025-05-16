<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addTextarea('contact_us_description', [
            'label' => 'Description',
            'wrapper' => ['width' => '100'],
        ])
        ->addImage('contact_us_background_image', [
            'label' => 'contact us hero image',
            'return_format' => 'id',
            'wrapper' => ['width' => '100'],
        ])

        ->addRepeater('contact_us_co', [
            'label' => 'Contacts',
            'button_label' => 'Add contact',
            'max' => 3,
        ])
        ->addImage('icon', [
            'label' => 'Icon',
            'return_format' => 'url',
            'wrapper' => ['width' => '33'],
        ])
        ->addText('contact_us_label', [
            'label' => 'What contact ?',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->addText('contact_us_text', [
            'label' => 'Contact',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->endRepeater()


        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Contact us hero section');

});
