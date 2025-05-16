<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

if (function_exists('acf_register_block_type')) {
    add_action('acf/init', function () {

        $ProductDetailsFields = new FieldsBuilder('product_details_block_shop');

        $ProductDetailsFields
            ->addText('extra_product_tag', [
                'label' => 'For what is product ?',
                'wrapper' => ['width' => '100'],
            ])
            ->addText('price_per_ml', [
                'label' => ' Price per ml example: 3.45€ / 100ml (Optional)',
                'wrapper' => ['width' => '100'],
            ])
            ->addRepeater('product_points', [
                'label' => 'Extra describe points',
                'button_label' => 'Add point',
                'instructions' => 'Add points to describe the product example "100% natural, no preservatives, etc."',
            ])
            ->addText('point', [
                'label' => 'Point',
                'wrapper' => [
                    'width' => '100',
                ]
            ])
            ->endRepeater()
            ->addRepeater('woocommerce_settings_accordion', [
                'label' => 'Accordion about products',
                'instructions' => 'Add accordion to describe the product example "Description, Ingredients, etc."',
                'button_label' => 'Add',
            ])
            ->addText('title', [
                'label' => 'Title',
                'wrapper' => [
                    'width' => '50',
                ]
            ])
            ->addTextarea('text', [
                'label' => 'Content',
                'wrapper' => [
                    'width' => '50',
                ]
            ])
            ->endRepeater()

            ->addRepeater('our_history', [
                'label' => 'About product',
                'button_label' => 'Add',
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
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'url',
                'wrapper' => ['width' => '50'],
            ])
            ->endRepeater()

            ->setLocation('post_type', '==', 'product');

        acf_add_local_field_group($ProductDetailsFields->build());
    });
}