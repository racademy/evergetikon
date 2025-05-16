<?php

/*acf builder*/
require_once __DIR__ . '/../vendor/autoload.php';

// Define the main ACF Builder path
$acf_builder_path = get_stylesheet_directory() . '/acf-builder/';

// Function to recursively get all PHP files in a directory and its subdirectories
function get_php_files($directory)
{
    $files = [];
    foreach (glob($directory . '*.php') as $file) {
        $files[] = $file;
    }
    foreach (glob($directory . '*/', GLOB_ONLYDIR) as $sub_dir) {
        $files = array_merge($files, get_php_files($sub_dir));
    }

    return $files;
}

// Get all PHP files in the main ACF Builder directory and its subdirectories
$all_files = get_php_files($acf_builder_path);

// Include each file
foreach ($all_files as $file) {
    include_once $file;
}

/* 🔁 Reusable ACF block functions */

function register_custom_acf_block($blockName, $title)
{
    if (!function_exists('acf_register_block_type'))
        return;

    acf_register_block_type([
        'key' => 'group_' . $blockName . '_id',
        'name' => $blockName,
        'title' => __($title),
        'render_callback' => 'render_acf_block',
        'category' => 'bp-theme-blocks',
        'icon' => 'block-default',
        // 'mode' => 'auto',
        'example' => [
            'attributes' => [
                'mode' => 'preview',
                'data' => ['_is_preview' => true],
            ],
        ],
        'supports' => [
            'anchor' => true,
            'spacing' => ['padding' => true, 'margin' => true,],
            'color' => ['background' => true, 'text' => true, 'link' => true],
            'custom' => true,
            'layout' => ['contentSize' => true],
            'background' => ['backgroundImage' => true, 'backgroundSize' => true],
        ],
    ]);
}

function render_acf_block($block)
{
    $slug = str_replace('acf/', '', $block['name']);
    $template = get_template_directory() . '/template-parts/' . $slug . '.php';

    $className = isset($block['className']) ? ' ' . $block['className'] : '';
    $blockStyles = '';
    $containerStyles = '';


    if (!empty($block['style']['color']['background'])) {
        $blockStyles .= 'background-color:' . esc_attr($block['style']['color']['background']) . ';';
    }
    if (!empty($block['style']['color']['text'])) {
        $blockStyles .= 'color:' . esc_attr($block['style']['color']['text']) . ';';
    }
    if (!empty($block['style']['spacing']['padding'])) {
        foreach ($block['style']['spacing']['padding'] as $side => $val) {
            $blockStyles .= "padding-$side:$val;";
        }
    }
    if (!empty($block['style']['spacing']['margin'])) {
        foreach ($block['style']['spacing']['margin'] as $side => $val) {
            $blockStyles .= "margin-$side:$val;";
        }
    }

    // Apply content size to container only
    if (!empty($block['layout']['contentSize'])) {
        $containerStyles .= 'max-width:' . esc_attr($block['layout']['contentSize']) . ';';
    }

    // Handle justifyContent via margins for the container only
    if (!empty($block['layout']['justifyContent'])) {
        switch ($block['layout']['justifyContent']) {
            case 'center':
                $containerStyles .= 'margin-left:auto;margin-right:auto;';
                break;
            case 'right':
                $containerStyles .= 'margin-left:auto;margin-right:0;';
                break;
            case 'left':
            default:
                $containerStyles .= 'margin-left:0;margin-right:auto;';
                break;
        }
    }


    $id = isset($block['anchor']) ? $block['anchor'] : 'block-' . $block['id'];
    $wrapper_attributes = 'id="' . esc_attr($id) . '" class="' . esc_attr($slug . $className) . '"';
    if ($blockStyles) {
        $wrapper_attributes .= ' style="' . esc_attr($blockStyles) . '"';
    }

    $fields = get_fields();
    if (file_exists($template)) {
        // Read the content of the template file
        ob_start();
        include $template;
        $template_content = ob_get_clean();

        // Now, inject the wrapper attributes into the existing <section>
        // This assumes you want to replace the section's opening tag with the modified one
        $template_content = preg_replace('/<section([^>]+)>/', '<section ' . $wrapper_attributes . '>', $template_content, 1);
        $template_content = preg_replace('/<div class="container">/', '<div class="container" style="' . esc_attr($containerStyles) . '">', $template_content, 1);

        // Output the modified content
        echo $template_content;
    } else {
        echo '<p>Block template not found for "' . esc_html($slug) . '"</p>';
    }
}


/*acf builder*/