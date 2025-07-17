<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined('ABSPATH') || exit;

get_header('shop');
get_template_part('template-part/block/breadcrumbs');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action('woocommerce_shop_loop_header');
?>

<section class="py-16 bg-[#FFF4EC]">
    <div class="max-w-6xl mx-auto px-4">

        <?php
        // Get main (top-level) product categories
        $main_categories = get_terms([
            'taxonomy'   => 'product_cat',
            'parent'     => 0,
            'hide_empty' => true, // Change to true to hide empty categories
        ]);

        if (!empty($main_categories)) :
        ?>
            <div class="flex flex-wrap gap-4 justify-center mb-8">
                <?php foreach ($main_categories as $cat): ?>
                    <a href="<?= esc_url(get_term_link($cat)); ?>"
                        class="category-btn opacity-80 hover:opacity-100 transition font-semibold">
                        <?= esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (woocommerce_product_loop()) : ?>

            <?php
            /**
             * Hook: woocommerce_before_shop_loop.
             *
             * @hooked woocommerce_output_all_notices - 10
             * @hooked woocommerce_result_count - 20
             * @hooked woocommerce_catalog_ordering - 30
             */
            do_action('woocommerce_before_shop_loop');

            echo '<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">';

            while (have_posts()) :
                the_post();
                do_action('woocommerce_shop_loop');
                $product = wc_get_product(get_the_ID());
            ?>
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 flex flex-col h-full">

                    <!-- Product Image -->
                    <a href="<?php the_permalink(); ?>" class="block relative">
                        <?php the_post_thumbnail('medium', [
                            'class' => 'w-full h-64 object-cover transition-transform duration-500 ease-in-out hover:scale-105'
                        ]); ?>
                        <?php if ($product && $product->is_on_sale()) : ?>
                            <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow">Giảm giá</span>
                        <?php endif; ?>
                    </a>

                    <!-- Content -->
                    <div class="p-4 flex-1 flex flex-col justify-between text-left">

                        <!-- Title -->
                        <h3 class="font-semibold text-base text-gray-800 leading-snug mb-1">
                            <a href="<?php the_permalink(); ?>" class="hover:text-[#B40303] transition">
                                <?php the_title(); ?>
                            </a>
                        </h3>

                        <!-- Description -->
                        <?php if ($desc = get_the_excerpt()) : ?>
                            <p class="text-sm text-gray-600 mb-4"><?= wp_trim_words($desc, 15, '…'); ?></p>
                        <?php endif; ?>

                        <!-- Price + Cart Icon -->
                        <div class="flex items-center justify-between mt-auto pt-4 border-t">
                            <div class="text-lg font-bold text-[#B40303]">
                                <?= $product ? $product->get_price_html() : ''; ?>
                            </div>
                            <a href="<?php the_permalink(); ?>"
                                class="w-10 h-10 flex items-center justify-center rounded-full border border-red-200 bg-[#FFF4EC] text-[#B40303] hover:bg-red-100 hover:scale-105 hover:shadow transition duration-300"
                                title="Xem chi tiết sản phẩm">
                                <i class="fa-solid fa-cart-plus text-base"></i>
                            </a>
                        </div>
                    </div>
                </div>

        <?php endwhile;

            echo '</div>'; // Close product grid
            echo '<div class="mt-8 flex justify-center">';
            /**
             * Hook: woocommerce_after_shop_loop.
             *
             * @hooked woocommerce_pagination - 10
             */
            do_action('woocommerce_after_shop_loop');
            echo '</div>';


        else :

            /**
             * Hook: woocommerce_no_products_found.
             *
             * @hooked wc_no_products_found - 10
             */
            do_action('woocommerce_no_products_found');

        endif;
        ?>

    </div>
</section>

<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10
 */
do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');

get_footer('shop');
