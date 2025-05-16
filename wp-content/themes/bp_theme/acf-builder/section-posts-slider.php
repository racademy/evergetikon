<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields
        ->addText('section_title', [
            'label' => 'Section Title',
            'wrapper' => ['width' => '50']
        ])
        ->addLink('section_link', [
            'label' => 'Section Button Link',
            'wrapper' => ['width' => '50']

        ])
        ->addSelect('post_source', [
            'label' => 'Post Source',
            'choices' => [
                'manual' => 'Manual Selection',
                'latest' => 'Latest Posts',
            ],
            'default_value' => 'manual',
            'wrapper' => ['width' => '50'],
        ])
        ->addRelationship('manual_posts', [
            'label' => 'Select Posts',
            'post_type' => ['post'],
            'max' => 10,
            'filters' => ['search'],
            'return_format' => 'object',
            'conditional_logic' => [
                [
                    [
                        'field' => 'post_source',
                        'operator' => '==',
                        'value' => 'manual',
                    ],
                ],
            ],
            'wrapper' => ['width' => '50'],
        ])
        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Section Posts Slider ');
});
