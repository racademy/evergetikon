<?php
//Disable Emoji Script:
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

//Remove Unnecessary Header Tags:
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'start_post_rel_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'adjacent_posts_rel_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

//Remove jQuery Migrate:
function remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array('jquery-migrate'));
        }
    }
}
add_action('wp_default_scripts', 'remove_jquery_migrate');

//To dequeue these stylesheets from your WordPress theme, you can use the
function remove_default_stylesheets()
{
    wp_dequeue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'remove_default_stylesheets', 100);

//allow SVG uploads:
function allow_svg_upload($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_upload');

/*remove comments*/
add_action('init', function () {
    // Remove support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});

add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
add_action('wp_dashboard_setup', function () {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
});
add_action('wp_before_admin_bar_render', function () {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
});


/*enable custom logo*/
add_theme_support('custom-logo');

// MENUS
function _custom_theme_register_menu()
{
    register_nav_menus(
        array(
            'menu-main' => __('Header'),
            'menu-main-user' => __('Header User Menu'),
            'menu-footer' => __('Footer'),
        )
    );
}

add_action('init', '_custom_theme_register_menu');


function remove_default_image_sizes($sizes)
{
    unset($sizes['large']);
    unset($sizes['medium']);
    unset($sizes['medium_large']);
    return $sizes;
}

add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');

// disabling big image sizes scaled
add_filter('big_image_size_threshold', '__return_false');



function custom_setup()
{
    // Images

    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');
    add_theme_support('align-wide');
    add_theme_support('custom-spacing'); // Enables padding and margin controls
    add_theme_support('editor-color-palette');

    // Title tags
    add_theme_support('title-tag');

    // Languages
    load_theme_textdomain('textdomaintomodify', get_template_directory() . '/languages');

    // HTML 5 - Example : deletes type="*" in scripts and style tags
    add_theme_support('html5', ['script', 'style']);

    // Remove SVG and global styles
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

    // Remove wp_footer actions which add's global inline styles
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // Remove render_block filters which adds unnecessary stuff
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block', 'wp_restore_group_inner_container');
    remove_filter('render_block', 'wp_render_layout_support_flag');

    // Remove useless WP image sizes
    remove_image_size('1536x1536');
    remove_image_size('2048x2048');

    // Custom image sizes
    // add_image_size( '424x424', 424, 424, true );
    // add_image_size( '1920', 1920, 9999 );
}

add_action('after_setup_theme', 'custom_setup');


/*enable only those blocks*/


add_filter('allowed_block_types', 'restrict_blocks_by_category', 10, 2);

function restrict_blocks_by_category($allowed_blocks, $post)
{
    // Get all available blocks
    $all_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

    // Category slug to allow
    $category_slug = 'bp-theme-blocks';

    // Filter blocks by the 'bp-theme-blocks' category
    $allowed_blocks = array_filter($all_blocks, function ($block) use ($category_slug) {
        return isset($block->category) && $block->category === $category_slug;
    });

    // Extract only the block names (as the `allowed_block_types` filter requires an array of block names)
    return array_keys($allowed_blocks);
}


add_filter('block_categories_all', 'my_custom_block_category', 10, 2);
function my_custom_block_category($categories, $post)
{
    return array_merge(
        [
            [
                'slug' => 'bp-theme-blocks',
                'title' => __('BP Theme Blocks', 'bp_theme'),
                'icon' => null,
            ],
        ],
        $categories
    );
}

/* Ajax live search */

function enqueue_live_search_script()
{
    wp_enqueue_script(
        'live-search',
        get_template_directory_uri() . '/assets/js/live-search.js',
        array(),
        null,
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_live_search_script');

add_action('wp_ajax_live_search', 'handle_live_search');
add_action('wp_ajax_nopriv_live_search', 'handle_live_search');

function handle_live_search()
{
    $query = sanitize_text_field($_GET['q']);
    $limit = 5;

    $product_args = [
        'post_type' => 'product',
        's' => $query,
        'posts_per_page' => $limit + 1,
    ];
    $product_query = new WP_Query($product_args);

    $products = [];
    foreach ($product_query->posts as $i => $product) {
        if ($i >= $limit)
            break;
        $image = get_the_post_thumbnail_url($product, 'thumbnail');
        if (!$image) {
            $image = wc_placeholder_img_src();
        }

        $regular_price = get_post_meta($product->ID, '_regular_price', true);
        $sale_price = get_post_meta($product->ID, '_sale_price', true);
        $price_html = '';

        if ($sale_price && $sale_price < $regular_price) {
            $price_html = '<span class="old-price">' . wc_price($regular_price) . '</span> <span class="sale-price">' . wc_price($sale_price) . '</span>';
        } else {
            $price_html = '<span class="regular-price">' . wc_price($regular_price) . '</span>';
        }

        $products[] = [
            'title' => get_the_title($product),
            'link' => get_permalink($product),
            'price' => $price_html,
            'image' => $image,
        ];

    }
    $has_more_products = count($product_query->posts) > $limit;

    // Search Categories
    $category_args = [
        'taxonomy' => 'product_cat',
        'name__like' => $query,
        'number' => $limit + 1,
        'hide_empty' => false,
    ];
    $categories = get_terms($category_args);

    $categories_output = [];
    foreach ($categories as $i => $cat) {
        if ($i >= $limit)
            break;
        $categories_output[] = [
            'name' => $cat->name,
            'link' => get_term_link($cat),
        ];
    }
    $has_more_categories = count($categories) > $limit;

    wp_send_json([
        'products' => $products,
        'categories' => $categories_output,
        'has_more' => $has_more_products || $has_more_categories,
        'total_found' => $product_query->found_posts + count($categories),
    ]);
}

/* End ajax live search */

/* Breadcrumbs */

function custom_breadcrumbs()
{
    $separator = ' / '; // or ' / '
    $home_title = __('Home', 'bp_theme');

    $breadcrumbs = '<nav class="breadcrumbs" aria-label="Breadcrumbs">';
    $breadcrumbs .= '<a href="' . home_url() . '">' . $home_title . '</a>' . $separator;

    global $post;

    if (is_home()) {
        $breadcrumbs .= __('Blog', 'bp_theme');
    } elseif (is_singular('post')) {
        $category = get_the_category();
        if (!empty($category)) {
            $breadcrumbs .= get_category_parents($category[0], true, $separator);
        }
        $breadcrumbs .= '<span>' . get_the_title() . '</span>';

    } elseif (is_singular('page')) {
        if ($post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs_array = [];
            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs_array[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs_array = array_reverse($breadcrumbs_array);
            foreach ($breadcrumbs_array as $crumb) {
                $breadcrumbs .= $crumb . $separator;
            }
        }
        $breadcrumbs .= '<span>' . get_the_title() . '</span>';

    } elseif (is_singular('product')) {
        if (function_exists('woocommerce_breadcrumb')) {
            $terms = get_the_terms($post->ID, 'product_cat');
            if (!empty($terms)) {
                $first_term = array_shift($terms);
                $breadcrumbs .= '<a href="' . get_term_link($first_term) . '">' . $first_term->name . '</a>' . $separator;
            }
        }
        $breadcrumbs .= '<span>' . get_the_title() . '</span>';

    } elseif (is_product_category()) {
        $current_cat = get_queried_object();
        if ($current_cat->parent != 0) {
            $parent_cats = get_ancestors($current_cat->term_id, 'product_cat');
            $parent_cats = array_reverse($parent_cats);
            foreach ($parent_cats as $parent_cat) {
                $term = get_term($parent_cat, 'product_cat');
                $breadcrumbs .= '<a href="' . get_term_link($term) . '">' . $term->name . '</a>' . $separator;
            }
        }
        $breadcrumbs .= '<span>' . single_cat_title('', false) . '</span>';

    } elseif (is_category()) {
        $breadcrumbs .= '<span>' . single_cat_title('', false) . '</span>';

    } elseif (is_tag()) {
        $breadcrumbs .= '<span>' . single_tag_title('', false) . '</span>';

    } elseif (is_archive()) {
        $breadcrumbs .= '<span>' . post_type_archive_title('', false) . '</span>';

    } elseif (is_search()) {
        $breadcrumbs .= '<span>' . __('Search results for:', 'bp_theme') . ' ' . get_search_query() . '</span>';

    } elseif (is_404()) {
        $breadcrumbs .= '<span>' . __('Error 404', 'bp_theme') . '</span>';
    }

    $breadcrumbs .= '</nav>';

    return $breadcrumbs;
}
add_shortcode('custom_breadcrumbs', 'custom_breadcrumbs');


add_filter('acf/load_field/name=req_selected_form', function ($field) {
    if (!function_exists('wpcf7_contact_form')) {
        return $field;
    }

    $forms = get_posts([
        'post_type' => 'wpcf7_contact_form',
        'numberposts' => -1,
    ]);

    $choices = [];

    foreach ($forms as $form) {
        $choices[$form->ID] = $form->post_title;
    }

    $field['choices'] = $choices;
    return $field;
});
