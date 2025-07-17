<?php
defined( 'ABSPATH' ) || exit;

/**
 * Template Part - News Section with Flexible Content
 * Expected $args:
 * - main_title (string)
 * - post_items (taxonomy term or category)
 * - post_number (int)
 * 
 * @param array $args
 */

// Extract values from $args
$main_title   = esc_html($args['main_title'] ?? 'Tin Tức Nổi Bật');
$taxonomy     = $args['post_items'] ?? null;
$post_number  = $args['post_number'] ?? 0; // Default to 5 if no number is set

// Setup the taxonomy query
$news_query = null;

if ($taxonomy && is_object($taxonomy)) {
    $news_query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => $post_number,
        'tax_query'      => [
            [
                'taxonomy' => 'category', // Adjust this if you're using a custom taxonomy
                'field'    => 'term_id',
                'terms'    => $taxonomy->term_id,
            ]
        ]
    ]);
}
?>

<!-- News Section -->
<section class="py-12 px-2 sm:px-4 md:px-6 lg:px-8 overflow-hidden">
    <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-[#E7292B] font-bold text-2xl sm:text-3xl md:text-4xl fade-up delay-2s">
            <?= $main_title; ?>
        </h1>
    </div>

    <!-- Swiper Container -->
    <div class="cooperate-news-swiper swiper mt-16 w-full relative overflow-visible fade-up delay-6s">
        <div class="swiper-wrapper pb-12">

            <?php if ($news_query && $news_query->have_posts()): ?>
                <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
                    <!-- Slide -->
                    <div class="swiper-slide max-w-[90vw] mx-auto bg-white rounded-lg shadow-md overflow-hidden relative flex flex-col">
                        
                        <!-- Image Wrapper: relative to position the date box inside it -->
                        <div class="relative">
                            <!-- Image -->
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?= esc_attr(get_the_title()); ?>" class="w-full h-64 object-cover">

                            <!-- Floating Date Box inside image wrapper -->
                            <div class="absolute right-4 -bottom-6 w-10 h-10 sm:w-12 sm:h-12 bg-[#DD3C27] rounded-md flex flex-col items-center justify-center text-[10px] sm:text-xs font-bold shadow-md z-10">
                                <span class="text-white"><?= get_the_date('d.m'); ?></span>
                                <span class="text-white"><?= get_the_date('Y'); ?></span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-4 text-start text-[#002956] flex flex-col gap-2">
                            <p class="text-base sm:text-lg font-semibold leading-snug">
                                <?= get_the_title(); ?>
                            </p>
                            <a href="<?= get_permalink(); ?>"
                                class="text-[#1D1D1D] text-xs sm:text-sm inline-flex items-center gap-1 font-medium hover:underline">
                                Xem thêm <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else: ?>
                <p class="text-center text-gray-500 w-full py-10">Không có bài viết nào trong chuyên mục này.</p>
            <?php endif; ?>

        </div>

        <!-- Swiper Pagination -->
        <div class="swiper-pagination"></div>

        <!-- Swiper Navigation -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>
