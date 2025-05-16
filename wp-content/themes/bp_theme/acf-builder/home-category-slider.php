<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);

    $fields->setLocation('block', '==', 'acf/' . $blockName);

    $fields
        ->addTaxonomy('category', [
            'label' => 'Choose a Category',
            'instructions' => 'Choose one category from which one would be show child categories',
            'taxonomy' => 'product_cat',
            'field_type' => 'select',
            'allow_null' => 1,
            'add_term' => 0,
            'return_format' => 'id',
            'multiple' => 0,
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Product Category Selector');
});
