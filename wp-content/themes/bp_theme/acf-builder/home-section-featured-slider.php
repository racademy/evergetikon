<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addRepeater('featured_slider', [
            'label' => 'Featured Slider',
            'button_label' => 'Add slide',
        ])
        ->addImage('slide_bg', [
            'label' => 'Slide background image',
            'return_format' => 'id',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->addText('slide_title', [
            'label' => 'Slide Title',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->addLink('slide_link', [
            'label' => 'Slide link',
            'wrapper' => [
                'width' => '33'
            ]
        ])
        ->endRepeater()

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home section featured slider');

});
