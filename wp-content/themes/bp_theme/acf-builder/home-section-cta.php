<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addText('cta_title', [
            'label' => 'Title',
            'wrapper' => ['width' => '50'],
        ])
        ->addTextarea('cta_description', [
            'label' => 'Description',
            'wrapper' => ['width' => '50'],
        ])
        ->addLink('cta_link', [
            'label' => 'CTA Link',
            'wrapper' => ['width' => '50'],
        ])
        ->addImage('cta_bg', [
            'label' => 'CTA Background Image',
            'return_format' => 'id',
            'wrapper' => ['width' => '50'],

        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home section CTA');

});
