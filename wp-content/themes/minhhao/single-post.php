<?php
defined( 'ABSPATH' ) || exit;
get_header(); ?>

<?php get_template_part( 'template-part/block/breadcrumbs' ); ?>

<?php
/* ────────────────────────────────────────────────
 *  GLOBAL NEWS SETTINGS (pulled from Options Page)
 * ──────────────────────────────────────────────── */
$latest_term     = get_field( 'news_latest_post', 'option' );
$latest_number   = get_field( 'latest_number', 'option' ) ?: 1; 
$related_number  = get_field( 'relative_number', 'option' ) ?: 1;
$current_post_id = get_the_ID();

$latest_post = get_field('latest_post', 'option');

/* ────────────────────────────────────────────────
 *  QUERY – latest posts (sidebar)
 * ──────────────────────────────────────────────── */
$latest_args = [
    'post_type'      => 'post',
    'posts_per_page' => $latest_number,
    'post__not_in'   => [ $current_post_id ],
];

if ( $latest_term && isset( $latest_term->term_id ) ) {
    $latest_args['tax_query'] = [[
        'taxonomy' => $latest_term->taxonomy,
        'field'    => 'term_id',
        'terms'    => $latest_term->term_id,
    ]];
}
$latest_query = new WP_Query( $latest_args );

/* ────────────────────────────────────────────────
 *  QUERY – related posts (swiper)
 *    same categories as current post
 * ──────────────────────────────────────────────── */
$current_categories = wp_get_post_categories( $current_post_id );
$related_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => $related_number,
    'post__not_in'   => [ $current_post_id ],
    'category__in'   => $current_categories,
]);
?>

<section class="max-w-7xl mx-auto px-4 py-16 grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Left: Main News (2/3) -->
    <div class="lg:col-span-2 space-y-8">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <h2 class="text-3xl font-bold text-gray-800"><?php the_title(); ?></h2>

            <p class="text-sm text-gray-500 mt-1 font-semibold">
                <i class="fa-solid fa-calendar-days mr-1"></i> <?php echo get_the_date( 'd F, Y' ); ?>
            </p>

            <?php if ( has_post_thumbnail() ) : ?>
                <img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>" class="w-full h-96 object-cover rounded-xl">
            <?php endif; ?>

            <div class="prose max-w-none text-gray-700 leading-relaxed">
                <?php the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </div>

    <!-- Right: Latest Posts -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b-2 border-dashed border-gray-400 pb-4">
            <h2 class="text-lg font-semibold text-gray-800">Tin tức mới nhất</h2>
        </div>

        <?php if ( $latest_query->have_posts() ) : ?>
            <?php while ( $latest_query->have_posts() ) : $latest_query->the_post(); ?>
                <div class="flex items-center justify-between border-b-2 border-dashed border-gray-400 pb-4">
                    <div class="flex-1 pr-4">
                        <a href="<?php the_permalink(); ?>" class="block">
                            <h3 class="text-md font-bold text-black hover:text-[#E7292B]"><?php the_title(); ?></h3>
                        </a>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fa-solid fa-calendar-days mr-1"></i> <?php echo get_the_date( 'd/m/Y' ); ?>
                        </p>
                    </div>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <img src="<?php the_post_thumbnail_url( 'thumbnail' ); ?>" alt="<?php the_title(); ?>" class="w-24 h-16 object-cover rounded">
                    <?php endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
            <p>Không có bài viết nào.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Related Posts Swiper -->
<section class="max-w-7xl mx-auto py-12 px-2 sm:px-4 md:px-6 lg:px-8 overflow-visible">
    <div class="flex flex-col md:flex-row gap-8 items-center text-center md:text-left">
        <div class="flex-1 text-left uppercase">
            <h1 class="text-[#E7292B] font-bold text-2xl sm:text-3xl md:text-4xl mt-1">Bài viết liên quan</h1>
        </div>
    </div>

    <div class="news-detail-swiper swiper mt-16 w-full relative overflow-visible">
        <div class="swiper-wrapper pb-12">
            <?php if ( $related_query->have_posts() ) : ?>
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="swiper-slide max-w-[90vw] mx-auto bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img src="<?php the_post_thumbnail_url( 'large' ); ?>" alt="<?php the_title(); ?>" class="w-full h-64 object-cover rounded-t-lg">
                        <?php endif; ?>

                        <div class="p-4 flex flex-col gap-2 text-start text-[#3B3B3B]">
                            <h3 class="text-base sm:text-lg font-semibold leading-snug"><?php the_title(); ?></h3>
                            <p class="text-sm text-black font-semibold">
                                <i class="fa-solid fa-calendar-days mr-1"></i> <?php echo get_the_date( 'd/m/Y' ); ?>
                            </p>
                            <p class="text-sm text-gray-700 line-clamp-3"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                        </div>
                    </a>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <p class="text-gray-500">Không có bài viết liên quan.</p>
            <?php endif; ?>
        </div>

        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
</section>

<?php get_footer(); ?>
