<?php
defined('ABSPATH') || exit;

// ✅ Enable WooCommerce support for this theme
add_action('after_setup_theme', function () {
    add_theme_support('woocommerce');
});

// ✅ Remove default WooCommerce breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

// ✅ Remove WooCommerce sidebar (if not using it in layout)
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// ✅ Remove archive header: title and description (you likely use your own layout)
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);

// ✅ Remove WooCommerce's default result count and sort dropdown
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

// ✅ Add custom result count and sort dropdown styled with Tailwind
add_action('woocommerce_before_shop_loop', 'my_custom_shop_header', 20);
function my_custom_shop_header() {
    global $wp_query;

    $total = $wp_query->found_posts; // Total products found
    $per_page = $wp_query->get('posts_per_page'); // Products per page
    $paged = max(1, get_query_var('paged')); // Current page

    $first = ($per_page * ($paged - 1)) + 1; // First product index
    $last  = min($total, $per_page * $paged); // Last product index
    ?>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4 text-sm">

        <!-- ✅ Custom Result Count -->
        <div class="text-gray-600">
            Hiển thị sản phẩm <strong><?= $first ?>–<?= $last ?></strong> trong tổng số <strong><?= $total ?></strong>
        </div>

        <!-- ✅ Custom Sort Dropdown (still uses WooCommerce function) -->
        <div class="w-full md:w-auto">
            <label for="sort" class="sr-only">Sắp xếp theo</label>
            <div class="relative inline-block w-full md:w-auto">
                <?php woocommerce_catalog_ordering(); ?>
            </div>
        </div>

    </div>
    <?php
}

// ✅ Remove all default product detail layout parts
add_action('init', function () {
    // Remove image gallery
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    
    // Remove tabs (e.g., description, reviews)
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
    
    // Remove related products section
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
    
    // Remove entire product summary (title, price, etc.) — only if you're replacing it completely
    remove_all_actions('woocommerce_single_product_summary');

    // Unhook default thumbnail + title + price + add to cart
    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

});

// ✅ Redirect to shop after adding to cart (instead of cart page)
add_filter('woocommerce_add_to_cart_redirect', function($url) {
    return wc_get_page_permalink('shop'); // Redirects to /shop/
});

// ✅ Show subcategories even if they are empty
add_filter('woocommerce_product_subcategories_hide_empty', '__return_false');

// ✅ Include subcategories' products in main category archives
add_action('pre_get_posts', function($q) {
    // Only affect main product category archive queries (not admin or others)
    if (! $q->is_main_query() || is_admin() || ! is_tax('product_cat')) return;

    $term = get_queried_object(); // Current product category term
    $term_ids = [$term->term_id]; // Start with the current term

    $children = get_term_children($term->term_id, 'product_cat'); // Get subcategories
    if (!is_wp_error($children)) {
        $term_ids = array_merge($term_ids, $children); // Add subcategory IDs to filter
    }

    // Modify query to include both current category and all its subcategories
    $q->set('tax_query', [[
        'taxonomy' => 'product_cat',
        'field'    => 'term_id',
        'terms'    => $term_ids,
        'operator' => 'IN',
    ]]);
});

// ✅ Replace the default WooCommerce product loop markup with a Tailwind CSS grid
add_filter('woocommerce_product_loop_start', function($html) {

    return '<ul class="products columns-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
});

add_action('woocommerce_before_shop_loop_item', function () {
    global $product;

    echo '<a href="' . esc_url(get_the_permalink()) . '" class="block overflow-hidden rounded aspect-square bg-gray-100 group">';
    
    // Output product image
    echo $product->get_image('woocommerce_thumbnail', [
        'class' => 'w-full h-64 object-cover transition-transform duration-500 ease-in-out hover:scale-105',
    ]);

    echo '</a>';
    
    echo '<div class="p-4 flex-1 flex flex-col justify-between text-left">';
}, 5); // Lower priority so it runs before title, price, etc.


add_action('woocommerce_shop_loop_item_title', function () {
    echo '<h3 class="font-semibold text-base text-gray-800 leading-snug mb-1">';
    echo '<a href="' . esc_url(get_the_permalink()) . '" class="hover:text-[#B40303] transition">';
    the_title();
    echo '</a></h3>';
}, 10);

add_action('woocommerce_after_shop_loop_item_title', function () {
    $desc = get_the_excerpt();
    if ($desc) {
        echo '<p class="text-sm text-gray-600 mb-4">' . esc_html(wp_trim_words($desc, 15, '…')) . '</p>';
    }
}, 5); // custom excerpt

add_action('woocommerce_after_shop_loop_item', function () {
    global $product;

    echo '<div class="flex items-center justify-between mt-auto pt-4 border-t">';
    echo '<div class="text-lg font-bold text-[#B40303]">' . $product->get_price_html() . '</div>';

    echo '<a href="' . esc_url(get_the_permalink()) . '"
        class="w-10 h-10 flex items-center justify-center rounded-full border border-red-200 bg-[#FFF4EC] text-[#B40303] hover:bg-red-100 hover:scale-105 hover:shadow transition duration-300"
        title="Xem chi tiết sản phẩm">
        <i class="fa-solid fa-cart-plus text-base"></i>
    </a>';

    echo '</div>'; // close price+cart
    echo '</div>'; // close p-4 content
}, 15);

add_filter('woocommerce_post_class', function ($classes, $product) {
    $classes[] = 'bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition';
    return $classes;
}, 10, 2);