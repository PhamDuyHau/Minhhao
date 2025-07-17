<?php
defined('ABSPATH') || exit;

add_action('wp_ajax_nopriv_refresh_mini_cart_count', 'refresh_mini_cart_count');
add_action('wp_ajax_refresh_mini_cart_count', 'refresh_mini_cart_count');

function refresh_mini_cart_count()
{
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}
