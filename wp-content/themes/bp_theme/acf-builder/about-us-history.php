<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addRepeater('our_history', [
            'label' => 'Our history',
            'button_label' => 'Add story line',
            'layout' => 'block',
        ])
        ->addSelect('layout_side', [
            'label' => 'Image Position',
            'choices' => [
                'left' => 'Left',
                'right' => 'Right',
            ],
            'default_value' => 'left',
            'wrapper' => ['width' => '100'],
        ])
        ->addText('semi_title', [
            'label' => 'Semi title',
            'wrapper' => ['width' => '50'],
        ])
        ->addText('title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])
        ->addWysiwyg('description', [
            'label' => 'Description',
            'wrapper' => ['width' => '50'],
        ])
        ->addLink('link', [
            'label' => 'Read more',
            'wrapper' => ['width' => '50'],
        ])
        ->addImage('image', [
            'label' => 'History Image',
            'return_format' => 'url',
            'wrapper' => ['width' => '100'],
        ])
        ->endRepeater()

        ->addTextarea('signature_description', [
            'label' => 'Signature Description',
            'wrapper' => ['width' => '100'],
        ])
        ->addImage('signature_history', [
            'label' => 'Signature',
            'return_format' => 'url',
            'wrapper' => ['width' => '100'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'About us history');

});
