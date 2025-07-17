<?php
// File: /inc/ajax/product-filter.php

defined('ABSPATH') || exit;

add_action('wp_ajax_load_subcategory_products', 'load_subcategory_products');
add_action('wp_ajax_nopriv_load_subcategory_products', 'load_subcategory_products');

if (!function_exists('truncate_chars')) {
    function truncate_chars($text, $limit = 50) {
        $text = wp_strip_all_tags($text);
        return mb_strlen($text) > $limit
            ? mb_substr($text, 0, $limit) . '...'
            : $text;
    }
}

function load_subcategory_products() {
    $term_id = $_GET['term_id'] ?? 0;
    $term_id = ($term_id === 'all') ? 'all' : intval($term_id);
    $parent_id = intval($_GET['parent_id'] ?? 0);

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
    ];

    if ($term_id !== 'all') {
        $args['tax_query'] = [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $term_id,
        ]];
    } elseif ($parent_id) {
        $args['tax_query'] = [[
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => get_terms([
                'taxonomy' => 'product_cat',
                'parent'   => $parent_id,
                'fields'   => 'ids',
                'hide_empty' => false,
            ]),
        ]];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';
        while ($query->have_posts()) : $query->the_post();
            $product = wc_get_product(get_the_ID());
            ?>
            <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 flex flex-col h-full">
                <a href="<?= esc_url(get_permalink()); ?>" class="block relative">
                    <div class="w-full h-64 overflow-hidden transition-transform duration-500 ease-in-out hover:scale-105">
                        <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
                    </div>
                    <?php if ($product && $product->is_on_sale()): ?>
                        <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow">Giảm giá</span>
                    <?php endif; ?>
                </a>
                <div class="p-4 flex-1 flex flex-col justify-between text-left">
                    <h3 class="font-semibold text-base text-gray-800 leading-snug mb-1">
                        <a href="<?= esc_url(get_permalink()); ?>" class="hover:text-[#B40303] transition">
                            <?= get_the_title(); ?>
                        </a>
                    </h3>
                    <?php if ($desc = get_the_excerpt()): ?>
                        <p class="text-sm text-gray-600 mb-4"><?= truncate_chars($desc, 50); ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between mt-auto pt-4 border-t">
                        <div class="text-lg font-bold text-[#B40303]">
                            <?= $product->get_price_html(); ?>
                        </div>
                        <a href="<?= esc_url(get_permalink()); ?>"
                           class="w-10 h-10 flex items-center justify-center rounded-full border border-red-200 bg-[#FFF4EC] text-[#B40303] hover:bg-red-100 hover:scale-105 hover:shadow transition duration-300"
                           title="Xem chi tiết sản phẩm">
                            <i class="fa-solid fa-cart-plus text-base"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        echo '</div>';
    else :
        echo '<p class="text-center text-gray-500 col-span-4">Không có sản phẩm.</p>';
    endif;

    wp_reset_postdata();
    wp_die();
}
