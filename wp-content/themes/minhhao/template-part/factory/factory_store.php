<?php
defined( 'ABSPATH' ) || exit;
/**
 * Sales System Section
 * @param array $args Passed data from flexible content
 */

$main_title = $args['main_title'] ?? '';
$description = $args['description'] ?? '';

$store_terms = $args['location_stores'] ?? [];

// Convert to array if needed
$store_terms = is_array($store_terms) ? $store_terms : [$store_terms];

// Convert term IDs to term objects if they are not already
$store_terms = array_map(function ($term) {
    return is_object($term) ? $term : get_term($term);
}, $store_terms);
?>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto items-center text-center">
        <?php if ($main_title): ?>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-[#E7292B] fade-up">
                <?= esc_html($main_title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($description): ?>
            <p class="text-sm md:text-base lg:text-base text-gray-700 leading-relaxed max-w-2xl mx-auto fade-up delay-3s">
                <?= wp_kses_post($description); ?>
            </p>
        <?php endif; ?>
    </div>

    <div class="factory-sale-swiper max-w-7xl swiper py-16 mt-12">
        <div class="swiper-wrapper items-center">

            <?php
            // Loop all taxonomy terms (e.g. cities)
            foreach ($store_terms as $term) :

                // Query stores inside this taxonomy term
                $stores_query = new WP_Query([
                    'post_type' => 'store',  // replace with your store CPT slug
                    'tax_query' => [[
                        'taxonomy' => $term->taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term->term_id,
                    ]],
                    'posts_per_page' => -1,
                ]);

                if ($stores_query->have_posts()) :
                    while ($stores_query->have_posts()) : $stores_query->the_post();
                        $content = apply_filters('the_content', get_the_content());
                        $store_map_link = get_field('store_link_map');
            ?>
                        <div class="swiper-slide w-[260px] h-auto bg-white rounded-xl p-6 shadow-md transition-all duration-500 branch-card">
                            <h1 class="font-bold text-lg mb-2"><?= get_the_title(); ?></h1>
                            <div class="text-sm text-gray-700">
                                <?= $content; ?>
                            </div>

                            <?php if (!empty($store_map_link['url'])): ?>
                                <a href="<?= esc_url($store_map_link['url']); ?>"
                                    target="<?= esc_attr($store_map_link['target'] ?? '_blank'); ?>"
                                    rel="noopener noreferrer"
                                    class="inline-block mt-4 text-red-600 hover:underline text-sm font-medium">
                                    <?= esc_html($store_map_link['title'] ?? 'Xem bản đồ'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
            <?php
                    endwhile;

                    wp_reset_postdata();
                endif;

            endforeach;
            ?>

        </div>

        <!-- Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination mt-6"></div>
    </div>
</section>