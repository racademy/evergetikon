<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields
        ->addText('section_title', [
            'label' => 'Section Title',
            'wrapper' => [
                'width' => '50',
            ],
        ])
        ->addLink('section_link', [
            'label' => 'Section Link (optional)',
            'wrapper' => [
                'width' => '50',
            ],
        ])
        ->addRepeater('featured_categories', [
            'label' => 'Featured Product Categories',
            'button_label' => 'Add Category',
        ])
        ->addTaxonomy('category', [
            'label' => 'Product Category',
            'taxonomy' => 'product_cat',
            'field_type' => 'select',
            'add_term' => 0,
            'return_format' => 'id',
            'allow_null' => 0,
        ])
        ->endRepeater()

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home section featured categories');

});
