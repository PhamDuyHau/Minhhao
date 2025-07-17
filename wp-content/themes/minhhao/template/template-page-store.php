<?php

/**
 * Template Name: Store
 * Template Post Type: page
 *
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;
get_header();

/* 
 *  Breadcrumb
 * */
get_template_part('template-part/block/breadcrumbs');

/* 
 *  Gather data
 *  */

// All city terms (needed for both select & store query)
$city = get_terms([
    'taxonomy'   => 'store_city',
    'hide_empty' => false,
]);

// All stores
$stores = get_posts([
    'post_type'      => 'store',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'title',
    'order'          => 'ASC',
]);

?>

<!-- Category Section -->
<section class="p-4 sm:p-6 max-w-lg mx-auto">

    <div class="mb-6 text-center">
        <?php
        // Get your ACF fields (adjust 'option' if they belong to something else)
        $store_main_title = get_field('store_main_title');
        $store_description = get_field('store_description');
        ?>

        <?php if ($store_main_title): ?>
            <h2 class="text-2xl sm:text-3xl font-bold  text-[#E7292B] fade-up delay-3s">
                <?= esc_html($store_main_title); ?>
            </h2>
        <?php endif; ?>

        <?php if ($store_description): ?>
            <p class="mt-3 text-base fade-up delay-5s">
                <?= wp_kses_post($store_description); ?>
            </p>
        <?php endif; ?>

        <span class="block mt-2 h-1 w-20 sm:w-24 bg-[#E7292B] rounded mx-auto fade-up delay-5s"></span>
    </div>

    <!-- Dropdown + (optional) “Hiển hiện” button -->
    <form id="city-form" class="flex flex-col sm:flex-row gap-4 fade-left delay-7s" method="GET">
        <select id="city-select"
            class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
            <option value="">-- Chọn Địa điểm --</option>
            <?php foreach ($city as $term) : ?>
                <?php if (is_object($term) && isset($term->slug, $term->name)) : ?>
                    <option value="<?= esc_attr($term->slug); ?>"><?= esc_html($term->name); ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <button id="city-show" type="button"
            class="w-full px-4 py-2 bg-[#E7292B] text-white rounded hover:bg-[#c32225] cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#c32225] fade-right delay-7s">
            Hiển hiện kết quả
        </button>
    </form>
</section>


<!-- Stores + Map Section  -->
<section class="px-6 py-12 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row gap-8">

        <!-- Left column: Store cards -->
        <div id="store-content"
            class="w-full md:w-1/2 min-h-[600px] flex flex-col justify-start gap-6 fade-left delay-3s">
            <?php foreach ($stores as $index => $store) : ?>
                <?php
                // Limit to showing only first 4 by default — hide others
                $hidden_class = ($index >= 4) ? 'hidden hidden-store' : '';

                $terms = get_the_terms($store->ID, 'store_city');
                $city_slug = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->slug : 'unknown';

                $map_field = get_field('store_location_map', $store->ID);
                $decoded = html_entity_decode($map_field);
                $map_src = '';

                if (preg_match('/<iframe[^>]+src=["\']([^"\']+)["\']/', $decoded, $m)) {
                    $map_src = $m[1];
                } elseif (filter_var(trim($decoded), FILTER_VALIDATE_URL)) {
                    $map_src = trim($decoded);
                }
                ?>
                <div class="store-box <?= esc_attr($hidden_class); ?> h-[140px] bg-white text-black rounded-lg p-6 shadow-md transition duration-300 hover:bg-[#E7292B] hover:text-white cursor-pointer active-box"
                    data-city="<?= esc_attr($city_slug); ?>"
                    data-map="<?= esc_url($map_src); ?>">

                    <h2 class="text-xl font-bold mb-2"><?= esc_html(get_the_title($store)); ?></h2>

                    <div class="store-summary">
                        <?= nl2br(wp_kses_post($store->post_content)); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Right column: Google Map -->
        <div class="w-full md:w-1/2 animate-boxOpen delay-3s">
            <div class="h-[300px] md:h-full md:min-h-[600px] rounded-lg overflow-hidden shadow-md">
                <iframe id="store-map"
                    class="w-full h-full"
                    src=""
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

</section>


<!-- Contact Section -->
<section class="bg-white py-12">
    <div class="max-w-7xl mx-auto lg:px-28 md:px-14 px-6 grid grid-cols-1 md:grid-cols-2 gap-10 items-start">

        <!-- Left Column: Text & Contact Info -->
        <?php
        $store_group = get_field('store_group');
        if ($store_group):
            $main_title     = $store_group['main_title'] ?? '';
            $description    = $store_group['description'] ?? '';
            $link_phone = $store_group['link_phone'] ?? null;
            $link_phone_url = $link_phone['url'] ?? '';
            $link_facebook_url  = $store_group['link_facebook']['url'] ?? '';
            $link_youtube_url   = $store_group['link_youtube']['url'] ?? '';
            $link_instagram_url = $store_group['link_instagram']['url'] ?? '';
            $link_zalo_url      = $store_group['link_zalo']['url'] ?? '';
            $box_title     = $store_group['box_title'] ?? '';
        ?>

            <!-- Left Column: Text & Contact Info -->
            <div class="space-y-6">
                <?php if ($main_title): ?>
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold  text-[#E7292B] fade-left delay-3s">
                        <?= esc_html($main_title); ?>
                    </h1>
                <?php endif; ?>


                <div class="fade-left delay-5s">
                    <?php if ($description): ?>
                        <p class="text-gray-700">
                            <?= wp_kses_post($description); ?>
                        </p>
                    <?php endif; ?>
                </div>


                <?php if ($link_phone_url): ?>
                    <div class="fade-left delay-7s">
                        <a href="<?= esc_url($link_phone_url); ?>"
                            class="inline-flex items-center gap-3 bg-[#E7292B] text-white px-6 py-3 cursor-pointer rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-[#c32225]">
                            <i class="fas fa-phone text-white text-lg"></i>
                            <span class="font-semibold"><?= esc_html($link_phone['title'] ?? 'LIÊN HỆ NGAY'); ?></span>
                        </a>
                    </div>
                <?php endif; ?>


                <!-- Social Icons -->
                <div class="flex items-center gap-4 mt-4 fade-left delay-8s">
                    <?php if ($link_facebook_url): ?>
                        <a href="<?= esc_url($link_facebook_url); ?>" title="Facebook"
                            class="w-12 h-12 bg-[#E7292B] text-white rounded-full flex items-center justify-center text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-[#c32225]">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($link_youtube_url): ?>
                        <a href="<?= esc_url($link_youtube_url); ?>" title="YouTube"
                            class="w-12 h-12 bg-[#E7292B] text-white rounded-full flex items-center justify-center text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-[#c32225]">
                            <i class="fab fa-youtube"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($link_instagram_url): ?>
                        <a href="<?= esc_url($link_instagram_url); ?>" title="Instagram"
                            class="w-12 h-12 bg-[#E7292B] text-white rounded-full flex items-center justify-center text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-[#c32225]">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($link_zalo_url): ?>
                        <a href="<?= esc_url($link_zalo_url); ?>" title="Zalo"
                            class="w-12 h-12 bg-[#E7292B] text-white rounded-full flex items-center justify-center text-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:bg-[#c32225]">
                            <i class="fas fa-comment-dots"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>


        <!-- Right Column: White Box Form -->
        <div class="bg-white shadow-lg rounded-lg p-8 space-y-6 animate-boxOpen delay-3s">
            <?php if ($box_title): ?>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold  text-[#E7292B] text-center">
                    <?= esc_html($box_title); ?>
                </h1>
            <?php endif; ?>
            
            <!-- FluentForm renders its own <form> tag -->
            <?php echo do_shortcode('[fluentform id="1"]'); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>