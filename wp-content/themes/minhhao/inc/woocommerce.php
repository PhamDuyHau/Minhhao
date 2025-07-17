<?php
defined('ABSPATH') || exit;


// Theme supports
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

// Remove WooCommerce breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Remove the archive header (title + description)
remove_action( 'woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10 );

// Remove default WooCommerce ones
// Remove default WooCommerce output
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Add custom version
add_action( 'woocommerce_before_shop_loop', 'my_custom_shop_header', 20 );
function my_custom_shop_header() {
    global $wp_query;

    $total = $wp_query->found_posts;
    $per_page = $wp_query->get('posts_per_page');
    $paged = max(1, get_query_var('paged'));

    $first = ($per_page * ($paged - 1)) + 1;
    $last  = min($total, $per_page * $paged);

    ?>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4 text-sm">

        <!-- Result Count -->
        <div class="text-gray-600">
            Hiển thị sản phẩm <strong><?= $first ?>–<?= $last ?></strong> trong tổng số <strong><?= $total ?></strong>
        </div>

        <!-- Sort Dropdown -->
        <div class="w-full md:w-auto">
            <label for="sort" class="sr-only">Sắp xếp theo</label>
            <div class="relative inline-block w-full md:w-auto">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

    </div>
    <?php
}

add_action('init', function () {
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    remove_all_actions('woocommerce_single_product_summary'); // Only if you're replacing ALL default summary content
});



add_filter('woocommerce_add_to_cart_redirect', function($url) {
    return wc_get_page_permalink('shop'); // Redirects to /shop/
});

add_filter('woocommerce_product_subcategories_hide_empty', '__return_false');

add_action('pre_get_posts', function($q) {
	if ( ! $q->is_main_query() || is_admin() || ! is_tax('product_cat') ) return;

	$term = get_queried_object();
	$term_ids = [$term->term_id];
	$children = get_term_children($term->term_id, 'product_cat');

	if (!is_wp_error($children)) {
		$term_ids = array_merge($term_ids, $children);
	}

	$q->set('tax_query', [[
		'taxonomy' => 'product_cat',
		'field'    => 'term_id',
		'terms'    => $term_ids,
		'operator' => 'IN',
	]]);
});


