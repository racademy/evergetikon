<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addText('map_address', [
            'label' => 'Address',
            'instructions' => 'Enter a full address (e.g. "1600 Amphitheatre Parkway, Mountain View, CA")',
            'required' => 1,
            'wrapper' => ['width' => '100'],
        ])

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Google maps');

});
