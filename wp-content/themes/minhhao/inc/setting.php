<?php
defined('ABSPATH') || exit;

function minhhao_register_menus() {
    register_nav_menus([
        'main_menu_left'  => __('Main Menu Left', 'minhhao'),
        'main_menu_right' => __('Main Menu Right', 'minhhao'),
        'mobile_menu'     => __('Mobile Menu', 'minhhao'),
        'footer_menu_1'     => __('Footer Menu 1', 'minhhao'),
        'footer_menu_2'     => __('Footer Menu 2', 'minhhao'),
        'main-nav'        => __('Primary Menu', 'minhhao'),
        'mobile-nav'      => __('Handheld Menu', 'minhhao'),
        'policy-nav'      => __('Term Menu', 'minhhao'),
    ]);
}
add_action('after_setup_theme', 'minhhao_register_menus', 11);
