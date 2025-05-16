<?php

use StoutLogic\AcfBuilder\FieldsBuilder;

$optionsPage = new FieldsBuilder('options_page');

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Site settings',
        'menu_title' => 'Site settings',
        'menu_slug' => 'acf-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ]);
}

add_action('acf/init', function () use ($optionsPage) {
    acf_add_local_field_group($optionsPage->build());
});

$optionsPage
    /* Discount page topsection */
    ->addAccordion('discount_block', [
        'label' => 'Discount on top of the page',
        'open' => 1,
    ])
    ->addTrueFalse('display_discount_section', [
        'label' => 'Display Discount Section',
        'message' => 'Enable Discount Section',
        'default_value' => 1,
        'ui' => 1,
    ])
    ->addText('discount_text', [
        'label' => 'Discount text',
        'wrapper' => [
            'width' => '100',
        ],
        'conditional_logic' => [
            [
                [
                    'field' => 'display_discount_section',
                    'operator' => '==',
                    'value' => '1',
                ]
            ]
        ]
    ])

    /* Footer section */
    ->addAccordion('footer_section', [
        'label' => 'Footer fields',
        'open' => 0,
    ])
    ->addText('discount_title', [
        'label' => 'Discount title',
        'wrapper' => [
            'width' => '50'
        ],
    ])
    ->addText('discount_description', [
        'label' => 'Discount description',
        'wrapper' => [
            'width' => '50'
        ],
    ])
    ->addRepeater('company_details', [
        'label' => 'Company information footer',
        'instructions' => 'Add single line information for display',
        'button_label' => 'Add line',
        'layout' => 'block',
    ])
    ->addText('info', [
        'label' => 'Info',
        'wrapper' => ['width' => '100'],
    ])
    ->endRepeater()
    ->addText('email', [
        'label' => 'Email',
        'wrapper' => ['width' => '50'],
    ])
    ->addText('phone', [
        'label' => 'Phone',
        'wrapper' => ['width' => '50'],
    ])

    ->addText('adress', [
        'label' => 'Adress',
        'wrapper' => ['width' => '50'],
    ])
    ->addRepeater('social_media', [
        'label' => 'Our  social media',
        'button_label' => 'Add new media',
        'layout' => 'block',
    ])
    ->addImage('icon', [
        'label' => 'Icon',
        'return_format' => 'url',
        'wrapper' => ['width' => '50'],
    ])
    ->addText('media_name', [
        'label' => 'Media link',
        'wrapper' => ['width' => '50'],
    ])
    ->endRepeater()
    ->addRepeater('payments', [
        'label' => 'Payments',
        'button_label' => 'Add payment image',
        'layout' => 'block',
    ])
    ->addImage('icon', [
        'label' => 'Payment image',
        'return_format' => 'url',
        'wrapper' => ['width' => '100'],
    ])
    ->endRepeater()

    /* Post archives */
    ->addAccordion('post_archive', [
        'label' => 'Post archive hero',
        'open' => 0,
    ])
    ->addText('about_us_title', [
        'label' => 'Title',
        'wrapper' => ['width' => '50'],
    ])
    ->addTextarea('about_us_description', [
        'label' => 'Description',
        'wrapper' => ['width' => '50'],
    ])
    ->addImage('about_us_background_image', [
        'label' => 'Post hero image',
        'return_format' => 'id',
        'wrapper' => ['width' => '100'],
    ])

    /* Our promise */
    ->addAccordion('our_promise', [
        'label' => 'Our promises',
        'open' => 0,
    ])
    ->addText('our_promise_title', [
        'label' => 'Title',
        'wrapper' => ['width' => '100'],
    ])
    ->addRepeater('our_promises_rep', [
        'label' => 'Our promises',
        'max' => 3,
        'button_label' => 'Add promise',
        'layout' => 'block',
    ])
    ->addText('title', [
        'label' => 'Title',
        'wrapper' => ['width' => '33'],
    ])
    ->addTextarea('description', [
        'label' => 'Description',
        'wrapper' => ['width' => '33'],
    ])
    ->addLink('link', [
        'label' => 'Link',
        'wrapper' => ['width' => '33'],
    ])
    ->endRepeater()

    /* 404 page */
    ->addAccordion('page_not_found', [
        'label' => 'Page not found',
        'open' => 0,
    ])
    ->addText('title_not_found', [
        'label' => 'Title',
        'wrapper' => ['width' => '50'],
    ])
    ->addTextarea('description_not_found', [
        'label' => 'Description',
        'wrapper' => ['width' => '50'],
    ])
    ->addLink('link_products', [
        'label' => 'Link shop',
        'wrapper' => ['width' => '50'],
    ])
    ->addLink('link_history', [
        'label' => 'Link about us',
        'wrapper' => ['width' => '50'],
    ])

    /* Shop page ADD section */
    ->addAccordion('shop_add', [
        'label' => 'Shop page ADD fields',
        'open' => 0,
    ])
    ->addTrueFalse('shop_add_show', [
        'label' => 'Show shop add section?',
        'default_value' => 0,
        'ui' => 1,
        'wrapper' => ['width' => '100'],
    ])
    ->addText('shop_add_semi', [
        'label' => 'Shop add semi title',
        'wrapper' => ['width' => '50'],
    ])
    ->addText('shop_add_title', [
        'label' => 'Shop add title',
        'wrapper' => ['width' => '50'],
    ])
    ->addLink('shop_add_cta', [
        'label' => 'Shop add CTA',
        'wrapper' => ['width' => '50'],
    ])
    ->addImage('shop_add_side_img', [
        'label' => 'Add side image',
        'return_format' => 'url',
        'wrapper' => ['width' => '50'],
    ])

    /* Shop page CTA */
    ->addAccordion('shop_cta', [
        'label' => 'Shop page CTA fields',
        'open' => 0,
    ])
    ->addText('cta_title', [
        'label' => 'Shop CTA Title',
        'wrapper' => ['width' => '50'],
    ])
    ->addTextarea('cta_description', [
        'label' => 'SHop CTA Description',
        'wrapper' => ['width' => '50'],
    ])
    ->addLink('cta_link', [
        'label' => 'Shop CTA Link',
        'wrapper' => ['width' => '50'],
    ])
    ->addImage('cta_bg', [
        'label' => 'CTA Background Image',
        'return_format' => 'id',
        'wrapper' => ['width' => '50'],
    ])

    /* Shop page testimonial section */
    ->addAccordion('shop_testimonials', [
        'label' => 'Shop page testimonials',
        'open' => 0,
    ])
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

    /* Most frequently asked questions */
    ->addAccordion('frequently_questions_accordion', [
        'label' => 'Most frequently asked questions',
        'open' => 0,
    ])
    ->addText('frequently_questions_title', [
        'label' => 'Frequently questions title',
        'wrapper' => [
            'width' => '100'
        ]
    ])
    ->addRepeater('frequently_questions', [
        'label' => 'Frequently questions',
        'button_label' => 'Add question',
    ])
    ->addText('frequently_questions_title', [
        'label' => 'Frequently question',
        'wrapper' => [
            'width' => '50',
        ]
    ])
    ->addTextArea('frequently_questions_answer', [
        'label' => 'Frequently question answer',
        'wrapper' => [
            'width' => '50',
        ]
    ])
    ->endRepeater()

    /* Slider for products page */
    ->addAccordion('products_slider', [
        'label' => 'Products slider',
        'open' => 0,
    ])
    ->addText('section_title', [
        'label' => 'Section Title',
        'wrapper' => ['width' => '50']
    ])
    ->addLink('section_link', [
        'label' => 'Section Button Link',
        'wrapper' => ['width' => '50']

    ])
    ->addRadio('product_source', [
        'label' => 'Choose Products From',
        'choices' => [
            'manual' => 'Manual Selection',
            'category' => 'Product Category',
        ],
        'default_value' => 'manual',
        'layout' => 'horizontal',
    ])
    ->addRelationship('manual_products', [
        'label' => 'Choose Products',
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
        'label' => 'Choose Product Category',
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

    ->setLocation('options_page', '==', 'acf-options');
