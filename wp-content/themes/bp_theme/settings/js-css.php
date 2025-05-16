<?php

// Load shared assets
function enqueue_shared_assets()
{
    // Enqueue shared global scripts with jQuery
    wp_enqueue_script('jquery', 'https://assets.brightprojects.io/jquery/jquery-3.7.1.min.js', array(), null, true);
    wp_enqueue_script('splide', 'https://assets.brightprojects.io/splide/splide.min.js', array('jquery'), '4.1.4', true);
    wp_enqueue_script('splide-auto-scroll', 'https://cdn.jsdelivr.net/npm/@splidejs/splide-extension-auto-scroll@0.5.3/dist/js/splide-extension-auto-scroll.min.js', array('splide'), '0.5.3', true);
    wp_enqueue_script('lightbox', 'https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js', array(), '0.5.3', true);

    // Enqueue shared global styles
    wp_enqueue_style('icomoon', get_template_directory_uri() . '/assets/icomoon/style.css', array(), '1.0', 'all');
    wp_enqueue_style('lightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '4.1.4', 'all');
    wp_enqueue_style('splide', 'https://assets.brightprojects.io/splide/splide.min.css', array(), '4.1.4', 'all');
    wp_enqueue_style('theme-global-css', get_template_directory_uri() . '/dist/global.css', array(), filemtime(get_template_directory() . '/dist/global.css'), 'all');

    if (function_exists('is_woocommerce') && is_woocommerce()) {
        wp_enqueue_style('woocommerce-shop-products', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/shop/section-products.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-shop-heading', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/shop/section-heading.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-product-about-product', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/product/section-about-product.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-product-content', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/product/section-content.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-components-filter', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/components/filter.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-components-product-card', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/components/product-card.css', array(), '4.1', 'all');
        wp_enqueue_style('woocommerce-components-slider', get_template_directory_uri() . '/dist/template-parts/css/woocommerce/components/slider.css', array(), '4.1', 'all');
        wp_enqueue_style('lightbox2-css', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css');
        wp_enqueue_script('lightbox2-js', 'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js', array('jquery'), '2.11.3', true);
    }
}

// Load frontend-specific assets
function enqueue_theme_assets()
{
    // Enqueue shared assets
    enqueue_shared_assets();

    // Enqueue frontend-specific global JS
    wp_enqueue_script('theme-global-js', get_template_directory_uri() . '/dist/global-js.js', array('jquery'), filemtime(get_template_directory() . '/dist/global-js.js'), true);

    // Conditionally enqueue layout-specific assets on singular pages
    if (is_singular()) {
        $blocks = parse_blocks(get_post()->post_content);

        foreach ($blocks as $block) {
            if (isset($block['blockName']) && is_string($block['blockName']) && strpos($block['blockName'], 'acf/') === 0) {
                $block_name = str_replace('acf/', '', $block['blockName']);
                enqueue_layout_assets($block_name);
            }
        }
    }
}

// Load block editor-specific assets
function enqueue_block_editor_assets()
{
    // Enqueue shared assets
    enqueue_shared_assets();

    // Enqueue editor-specific JS
    wp_enqueue_script('theme-global-js', get_template_directory_uri() . '/dist/global-js.js', array('jquery'), filemtime(get_template_directory() . '/dist/global-js.js'), true);

    // Conditionally enqueue layout-specific assets in the editor
    $post = get_post();
    if ($post) {
        $blocks = parse_blocks($post->post_content);

        foreach ($blocks as $block) {
            if (isset($block['blockName']) && is_string($block['blockName']) && strpos($block['blockName'], 'acf/') === 0) {
                $block_name = str_replace('acf/', '', $block['blockName']);
                enqueue_layout_assets($block_name, true);
            }
        }
    }
}

// Helper function to enqueue layout-specific assets
function enqueue_layout_assets($block_name, $is_editor = false)
{
    $layout_css = get_template_directory() . "/dist/template-parts/css/{$block_name}.css";
    $layout_js = get_template_directory() . "/dist/template-parts/js/{$block_name}.js";

    $suffix = $is_editor ? '-editor' : '';

    // CSS
    if (file_exists($layout_css)) {
        wp_enqueue_style(
            "theme-{$block_name}{$suffix}-css",
            get_template_directory_uri() . "/dist/template-parts/css/{$block_name}.css",
            array('theme-global-css'),
            filemtime($layout_css),
            'all'
        );
    }

    // JS
    if (file_exists($layout_js)) {
        $handle = "theme-{$block_name}{$suffix}-js";

        wp_enqueue_script(
            $handle,
            get_template_directory_uri() . "/dist/template-parts/js/{$block_name}.js",
            array('jquery'),
            filemtime($layout_js),
            true
        );

        // 💡 Trick: Reload block script after short delay in the editor
        if ($is_editor) {
            wp_add_inline_script($handle, "
                setTimeout(() => {
                    const script = document.createElement('script');
                    script.src = '" . get_template_directory_uri() . "/dist/template-parts/js/{$block_name}.js?delayed';
                    document.body.appendChild(script);
                }, 300);
            ");
        }

        // Localize only on frontend
        if (!$is_editor) {
            wp_localize_script($handle, 'ajax_obj', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('load_more_universities_nonce'),
                'show_more_text' => __('Show More', 'bp_theme'),
            ));

            wp_localize_script($handle, 'category_ajax_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('category-nonce')
            ));
        }
    }
}


// Hook into WordPress to load scripts and styles
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');
add_action('enqueue_block_editor_assets', 'enqueue_block_editor_assets');
