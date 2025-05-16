<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields
        ->addText('req_title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])
        ->addText('req_semi_title', [
            'label' => 'Semi title',
            'wrapper' => ['width' => '50'],
        ])
        ->addRepeater('req_information', [
            'label' => 'Information',
            'button_label' => 'Add info',
        ])
        ->addText('what_info', [
            'label' => 'What info?',
            'wrapper' => ['width' => '50'],
        ])
        ->addText('info_text', [
            'label' => 'Info',
            'wrapper' => ['width' => '50'],
        ])
        ->endRepeater()

        ->addSelect('req_selected_form', [
            'label' => 'Select Contact Form',
            'instructions' => 'Choose a contact form to display.',
            'choices' => [],
            'allow_null' => 1,
            'ui' => 1,
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Contact us information');
});

