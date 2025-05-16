<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields
        ->setLocation('block', '==', 'acf/' . $blockName)

        ->addText('title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])

        ->addTextarea('description', [
            'label' => 'Description',
            'wrapper' => ['width' => '50'],
        ])

        ->addRepeater('our_values_repeater', [
            'label' => 'Our Values Items',
            'button_label' => 'Add Value Item',
            'layout' => 'block',
        ])
        ->addImage('icon', [
            'label' => 'Icon',
            'return_format' => 'url',
            'wrapper' => ['width' => '50'],
        ])
        ->addText('text', [
            'label' => 'Text',
            'wrapper' => ['width' => '50'],
        ])
        ->endRepeater()

        ->addLink('read_all_story', [
            'label' => 'Read All Story',
            'wrapper' => ['width' => '100'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home Our Values');
});
