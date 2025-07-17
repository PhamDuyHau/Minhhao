<?php
defined('ABSPATH') || exit;
// WooCommerce assets
add_action('wp_enqueue_scripts', function () {
    if (class_exists('WooCommerce')) {
        wp_enqueue_script('wc-add-to-cart');
        wp_enqueue_script('wc-cart-fragments');
    }
}, 20);

// Shop style
add_action('wp_enqueue_scripts', function () {
    if (is_shop()) {
        wp_enqueue_style(
            'minhhao-shop-style',
            ASSETS_URL . 'css/shop.css',
            [],
            filemtime(THEME_PATH . 'assets/css/shop.css')
        );
    }
}, 29);

// Cart style
add_action('wp_enqueue_scripts', function () {
    if (is_cart()) {
        wp_enqueue_style(
            'minhhao-cart-style',
            ASSETS_URL . 'css/cart.css',
            [],
            filemtime(THEME_PATH . 'assets/css/cart.css')
        );
    }
}, 30);


// Checkout style
add_action('wp_enqueue_scripts', function () {
    if (is_checkout()) {
        wp_enqueue_style(
            'minhhao-checkout-style',
            ASSETS_URL . 'css/checkout.css',
            [],
            filemtime(THEME_PATH . 'assets/css/checkout.css')
        );
    }
}, 31);

// Thank You style
add_action('wp_enqueue_scripts', function () {
    if (is_order_received_page()) {
        wp_enqueue_style(
            'minhhao-thankyou-style',
            ASSETS_URL . 'css/thankyou.css',
            [],
            filemtime(THEME_PATH . 'assets/css/thankyou.css')
        );
    }
}, 32);


// Frontend JS/CSS
add_action('wp_enqueue_scripts', function () {
    // Main child theme assets
    wp_enqueue_style('hd-child-style', get_stylesheet_directory_uri() . '/dist/assets/main-CeQw0XQk.css', [], filemtime(get_stylesheet_directory() . '/dist/assets/main-CeQw0XQk.css'));
    wp_enqueue_script('hd-child-script', get_stylesheet_directory_uri() . '/dist/assets/main-f5mX-uYy.js', [], filemtime(get_stylesheet_directory() . '/dist/assets/main-f5mX-uYy.js'), true);


    // Conditional
    if (is_page_template('template/template-page-store.php')) {
        wp_enqueue_script('store-page-script', ASSETS_URL . 'js/store-page.js', [], filemtime(THEME_PATH . 'assets/js/store-page.js'), true);
    }

    if (is_tax('product_cat')) {
        global $wp_query;
        $term = get_queried_object();
        wp_enqueue_script('product-category-script', ASSETS_URL . 'js/product-category.js', [], filemtime(THEME_PATH . 'assets/js/product-category.js'), true);
        wp_localize_script('product-category-script', 'categoryData', [
            'parentCategoryId' => $term->parent ? $term->parent : $term->term_id,
            'ajaxUrl' => admin_url('admin-ajax.php'),
        ]);
    }

    if (is_page_template('template/template-page-dumpling.php')) {
        wp_enqueue_script('dumpling-script', ASSETS_URL . 'js/dumpling.js', [], filemtime(THEME_PATH . 'assets/js/dumpling.js'), true);
    }

    // Always
    wp_enqueue_script('header-script', ASSETS_URL . 'js/header.js', ['jquery'], filemtime(THEME_PATH . 'assets/js/header.js'), true);

    if (is_product()) {
        wp_enqueue_script('single-product-script', ASSETS_URL . 'js/single-product.js', [], filemtime(THEME_PATH . 'assets/js/single-product.js'), true);
    }
});
