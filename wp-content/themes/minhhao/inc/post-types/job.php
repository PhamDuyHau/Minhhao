<?php
defined('ABSPATH') || exit;

register_post_type('job', [
    'labels' => [
        'name' => 'Jobs',
        'singular_name' => 'Job',
    ],
    'public' => true,
    'has_archive' => false,
    'rewrite' => [
        'slug' => 'tuyen-dung',
        'with_front' => false,
    ],
    'supports' => ['title', 'editor', 'custom-fields'],
    'menu_icon' => 'dashicons-id',
]);
