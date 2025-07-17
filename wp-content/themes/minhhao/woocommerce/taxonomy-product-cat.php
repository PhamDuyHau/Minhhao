<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$term = get_queried_object();
$term_id = $term->term_id;
$is_sub = $term->parent !== 0;
$current_main_term = $is_sub ? get_term($term->parent, 'product_cat') : $term;

// Get all parent (main) categories
$main_categories = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => 0,
    'hide_empty' => true,
]);

// Get subcategories under the current main category
$subcategories = get_terms([
    'taxonomy'   => 'product_cat',
    'parent'     => $current_main_term->term_id,
    'hide_empty' => true,
]);

get_template_part('template-part/block/breadcrumbs');

?>

<section class="py-16 bg-[#FFF4EC]">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Main Category Buttons -->
        <div class="flex flex-wrap gap-4 justify-center mb-6">
            <?php foreach ($main_categories as $main_cat): ?>
                <a href="<?= esc_url(get_term_link($main_cat)); ?>"
                    class="category-btn transition font-semibold <?= $main_cat->term_id === $current_main_term->term_id ? 'bg-[#B40303] text-white' : 'bg-gray-100 text-gray-700 hover:bg-[#FFD4C7]' ?>">
                    <?= esc_html($main_cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Subcategory Filter Buttons -->
        <?php if (!empty($subcategories)): ?>
            <div class="flex flex-wrap gap-4 justify-center mb-8">
                <button data-subcat-id="all" class="subcategory-btn category-btn transition font-semibold cursor-pointer">
                    Tất cả
                </button>
                <?php foreach ($subcategories as $sub): ?>
                    <button data-subcat-id="<?= esc_attr($sub->term_id); ?>" class="subcategory-btn category-btn transition font-semibold cursor-pointer">
                        <?= esc_html($sub->name); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Product Grid -->
        <div id="product-grid-container">
            <?php
            $term_ids = [$current_main_term->term_id];
            $children = get_term_children($current_main_term->term_id, 'product_cat');
            if (!is_wp_error($children)) {
                $term_ids = array_merge($term_ids, $children);
            }

            $products = new WP_Query([
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => [[
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $term_ids,
                    'operator' => 'IN',
                ]],
            ]);

            if ($products->have_posts()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php while ($products->have_posts()): $products->the_post();
                        $product = wc_get_product(get_the_ID());
                        $product_term_ids = wp_list_pluck(wp_get_post_terms(get_the_ID(), 'product_cat'), 'term_id');
                    ?>
                        <div class="product-card bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 flex flex-col h-full" data-category-ids="<?= esc_attr(implode(',', $product_term_ids)); ?>">
                            <a href="<?= esc_url(get_permalink()); ?>" class="block relative">
                                <?= get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => 'w-full h-64 object-cover transition-transform duration-500 ease-in-out hover:scale-105']); ?>
                                <?php if ($product->is_on_sale()): ?>
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
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            <?php else: ?>
                <p class="text-center text-gray-500">Không có sản phẩm.</p>
            <?php endif; ?>
        </div>
    </div>


</section>

<?php get_footer(); ?>