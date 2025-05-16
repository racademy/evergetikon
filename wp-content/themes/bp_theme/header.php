<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php get_template_part('template-parts/section', 'discount'); ?>

    <header class="header">
        <div class="container">
            <div class="desktop-menu">
                <div class="header__top">
                    <div class="header__top--search">
                        <div class="search-wrapper">
                            <input type="text" id="live-search"
                                placeholder="<?php esc_attr_e('Find the product...', 'bp_theme'); ?>"
                                autocomplete="off">
                        </div>

                        <div id="live-search-results"
                            data-view-all-text="<?php esc_attr_e('View all results', 'bp_theme'); ?>"
                            data-found-text="<?php esc_attr_e('%s results found. Press Enter/Forward to see all results.', 'bp_theme'); ?>"
                            data-products-text="<?php esc_attr_e('Products', 'bp_theme'); ?>"
                            data-categories-text="<?php esc_attr_e('Categories', 'bp_theme'); ?>"
                            data-no-results-text="<?php esc_attr_e('No results found', 'bp_theme'); ?>">
                        </div>
                    </div>

                    <div class="header__top--logo">
                        <?php
                        if (has_custom_logo()) {
                            $logo = get_custom_logo();
                            echo $logo;
                        }
                        ?>
                    </div>

                    <div class="header__top--user">
                        <nav class="main-navigation">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'menu-main-user',
                                'menu_class' => 'nav-menu-user',
                                'container' => false,
                                'menu_id' => 'user-menu',
                            ));
                            ?>
                        </nav>
                    </div>
                </div>

                <div class="header__bottom">
                    <div class="header__bottom--main-nav">
                        <nav class="main-navigation">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'menu-main',
                                'menu_class' => 'nav-menu',
                                'container' => false,
                                'walker' => new Custom_Two_Level_Walker(),
                                'menu_id' => 'main-menu',
                            ));
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="mobile-menu">
                <div class="mobile-header__bar">
                    <button class="mobile-toggle" data-target="#mobile-main-menu" aria-label="Toggle main menu">
                        <span class="hamburger">
                            <span class="bar"></span>
                            <span class="bar"></span>
                            <span class="bar"></span>
                        </span>
                    </button>

                    <div class="mobile-header__logo">
                        <?php if (has_custom_logo())
                            echo get_custom_logo(); ?>
                    </div>

                    <div class="header__top--user">
                        <nav class="main-navigation">
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'menu-main-user',
                                'menu_class' => 'nav-menu-user',
                                'container' => false,
                                'menu_id' => 'user-menu',
                            ));
                            ?>
                        </nav>
                    </div>
                </div>

                <!-- Main menu dropdown -->
                <div id="mobile-main-menu" class="mobile-menu__dropdown">
                    <div class="header__top--search">
                        <div class="search-wrapper">
                            <input type="text" id="mobile-search"
                                placeholder="<?php esc_attr_e('Find the product...', 'bp_theme'); ?>"
                                autocomplete="off">
                            <button type="button" class="clear-input" aria-label="Clear search">×</button>
                        </div>

                        <div id="mobile-search-results"
                            data-view-all-text="<?php esc_attr_e('View all results', 'bp_theme'); ?>"
                            data-found-text="<?php esc_attr_e('%s results found. Press Enter/Forward to see all results.', 'bp_theme'); ?>"
                            data-products-text="<?php esc_attr_e('Products', 'bp_theme'); ?>"
                            data-categories-text="<?php esc_attr_e('Categories', 'bp_theme'); ?>"
                            data-no-results-text="<?php esc_attr_e('No results found', 'bp_theme'); ?>">
                        </div>
                    </div>

                    <nav class="mobile-menu__nav">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'menu-main',
                            'menu_class' => 'mobile-nav-menu',
                            'container' => false,
                            'id' => 'mobile-nav-menu',
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <?php if (!is_front_page() && !is_home()) { ?>
        <div id="breadcrumbs">
            <div class="container">
                <div class="breadcrumbs__holder">
                    <?= do_shortcode('[custom_breadcrumbs]'); ?>
                </div>
            </div>
        </div>
    <?php } ?>