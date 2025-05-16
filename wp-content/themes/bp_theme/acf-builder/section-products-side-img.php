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
        ->addSelect('layout_type', [
            'label' => 'Layout Type',
            'choices' => [
                'slider_only' => 'Slider Only',
                'slider_left' => 'Slider Left / Image Right',
                'slider_right' => 'Image Left / Slider Right',
            ],
            'default_value' => 'slider_only',
            'return_format' => 'value',
            'ui' => 1,
        ])
        ->addImage('side_image', [
            'label' => 'Side Image',
            'return_format' => 'id',
            'preview_size' => 'medium',
            'conditional_logic' => [
                [
                    [
                        'field' => 'layout_type',
                        'operator' => '!=',
                        'value' => 'slider_only',
                    ],
                ],
            ],
        ])
        ->addRadio('product_source', [
            'label' => 'Select Products From',
            'choices' => [
                'manual' => 'Manual Selection',
                'category' => 'Product Category',
            ],
            'default_value' => 'manual',
            'layout' => 'horizontal',
        ])
        ->addRelationship('manual_products', [
            'label' => 'Select Products',
            'post_type' => ['product'],
            'filters' => ['search'],
            'max' => 10,
            'conditional_logic' => [
                [
                    [
                        'field' => 'product_source',
                        'operator' => '==',
                        'value' => 'manual',
                    ],
                ],
            ],
        ])
        ->addTaxonomy('product_category', [
            'label' => 'Select Product Category',
            'taxonomy' => 'product_cat',
            'field_type' => 'select',
            'return_format' => 'id',
            'allow_null' => 1,
            'conditional_logic' => [
                [
                    [
                        'field' => 'product_source',
                        'operator' => '==',
                        'value' => 'category',
                    ],
                ],
            ],
        ])
        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Section Products Slider – Hero Image');
});
