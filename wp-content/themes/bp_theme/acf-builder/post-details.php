<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

if (function_exists('acf_register_block_type')) {
    add_action('acf/init', function () {

        $PostDetailsFields = new FieldsBuilder('product_details_block');

        $PostDetailsFields
            ->addText('post_q', [
                'label' => 'Post question ?',
                'wrapper' => ['width' => '100'],
            ])

            ->addRepeater('post_source', [
                'label' => 'Post sources',
                'button_label' => 'Add source',
                'layout' => 'block',
            ])
            ->addLink('s_link', [
                'label' => 'Source link',
                'wrapper' => ['width' => '50'],
            ])
            ->endRepeater()

            ->setLocation('post_type', '==', 'post');

        acf_add_local_field_group($PostDetailsFields->build());
    });
}