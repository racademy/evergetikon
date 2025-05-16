<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$blockName = basename(__FILE__, '.php');

add_action('acf/init', function () use ($blockName) {

    $fields = new FieldsBuilder($blockName);
    $fields
        ->addText('testimonial_slider_title', [
            'label' => 'Testimonials slider title',
            'wrapper' => [
                'width' => '100'
            ]
        ])
        ->addRepeater('home_testimonials_slider', [
            'label' => 'Testimonials Slider',
            'button_label' => 'Add slide',
        ])
        ->addText('home_testimonials_title', [
            'label' => 'Slide Title',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->addTextArea('home_testimonials_description', [
            'label' => 'Slide Description',
            'wrapper' => [
                'width' => '33',
            ]
        ])
        ->addText('home_testimonials_author', [
            'label' => 'Slide author',
            'wrapper' => [
                'width' => '20',
            ]
        ])
        ->addText('home_testimonials_initials', [
            'label' => 'Slide author initials',
            'wrapper' => [
                'width' => '13',
            ]
        ])
        ->endRepeater()
        ->addText('colab_title', [
            'label' => 'Lets work together  title',
            'wrapper' => [
                'width' => '100'
            ]
        ])
        ->addRepeater('colab', [
            'label' => 'Collaborate images',
            'button_label' => 'Add image',
        ])
        ->addImage('colab_img', [
            'label' => 'colloborator Image',
            'return_format' => 'id',
            'wrapper' => ['width' => '100'],
        ])
        ->endRepeater()

        ->setLocation('block', '==', 'acf/' . $blockName);

    acf_add_local_field_group($fields->build());

    register_custom_acf_block($blockName, 'Home section testimonial slider');

});
