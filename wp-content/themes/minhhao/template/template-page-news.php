<?php

/**
 * Template Name: News
 * Template Post Type: page
 *
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;
get_header();
get_template_part('template-part/block/breadcrumbs');

/* ─────────────────────────────────────────────────────────
 * 1. ACF – featured post (single Post‑Object field)
 * ───────────────────────────────────────────────────────── */
$featured_post = get_field('main_news_post');      // post object or null
$featured_id   = $featured_post ? $featured_post->ID : 0;

/* ─────────────────────────────────────────────────────────
 * 2. Pagination + optional taxonomy filter
 * ───────────────────────────────────────────────────────── */
$taxonomy_term  = get_field('news_taxonomy');      // term object or null
$posts_per_page = get_field('news_page_number') ?: 9;
$current_page   = max(1, get_query_var('paged') ?: get_query_var('page') ?: 1);

/* ─────────────────────────────────────────────────────────
 * 3. Build the main query
 * ───────────────────────────────────────────────────────── */
$args = array(
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
    'paged'          => $current_page,
);

/* Exclude the featured post from the grid */
if ($featured_id) {
    $args['post__not_in'] = array($featured_id);
}

/* Optional taxonomy filter */
if ($taxonomy_term) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => $taxonomy_term->taxonomy,
            'field'    => 'term_id',
            'terms'    => $taxonomy_term->term_id,
        ),
    );
}

$news_query = new WP_Query($args);
?>

<?php if ($featured_post) : ?>
    <section class="lg:py-16 md:py-8 py-4 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-8">

            <!-- Left column: featured image -->
            <div class="w-full md:w-1/2 fade-left">
                <?php
                $img = get_the_post_thumbnail_url($featured_id, 'large')
                    ?: get_template_directory_uri() . '/assets/placeholder.jpg';
                ?>
                <div class="aspect-[4/3] w-full">
                    <img src="<?php echo esc_url($img); ?>"
                        alt="<?php echo esc_attr(get_the_title($featured_id)); ?>"
                        class="w-full h-full object-cover rounded-lg shadow-lg">
                </div>
            </div>

            <!-- Right column: title + excerpt -->
            <div class="w-full md:w-1/2 space-y-6 fade-right">
                <h1 class="text-2xl lg:text-3xl font-bold  text-[#E7292B]">
                    <?php echo esc_html(get_the_title($featured_id)); ?>
                </h1>

                <p class="text-base text-gray-700 fade-right delay-3s">
                    <?php echo esc_html(wp_trim_words(get_the_excerpt($featured_id), 35)); ?>
                </p>

                <a href="<?php echo esc_url(get_permalink($featured_id)); ?>"
                    class="inline-flex items-center text-white font-semibold pl-6 pr-1 py-1 rounded-full gap-3 hover:scale-110 transition fade-right delay-5s"
                    style="background: linear-gradient(360deg,#064DA1 -56.52%,#0059C3 59.78%);">
                    Xem Tin
                    <span class="w-10 h-10 rounded-full bg-[#FF0006] flex items-center justify-center">
                        <i class="fas fa-arrow-right text-white text-sm"></i>
                    </span>
                </a>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- List -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Grid Container -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($news_query->have_posts()) : ?>
                <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>"
                        class="block bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl hover:scale-105 transition-all duration-300">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>"
                                alt="<?php the_title(); ?>"
                                class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-105">
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[#FFCD27] transition-colors">
                                <?php the_title(); ?>
                            </h3>
                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                <i class="fa-solid fa-calendar-days mr-2"></i>
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                            <p class="text-sm text-gray-600 mt-2 line-clamp-3 group-hover:text-gray-700 transition-colors">
                                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                            </p>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No news items found.</p>
            <?php endif; ?>
        </div>

        <?php
        $total_pages  = $news_query->max_num_pages;
        $current_page = max(1, $current_page);

        if ($total_pages > 1) :
        ?>
            <div class="flex justify-center items-center mt-8 space-x-2">
                <!-- Prev Button -->
                <a href="<?php echo ($current_page > 1) ? get_pagenum_link($current_page - 1) : '#'; ?>"
                    class="px-4 py-2 text-[#FFCD27] rounded cursor-pointer hover:bg-gradient-to-r hover:from-[#B40303] hover:to-[#7A0202] hover:scale-110 transition <?php echo ($current_page == 1) ? 'opacity-50 pointer-events-none' : ''; ?>"
                    style="background: radial-gradient(131.61% 131.61% at 50% 50%, #B40303 0%, #7A0202 100%);">
                    <i class="fa-solid fa-angle-left text-[#FFCD27] hover:text-white"></i>
                </a>

                <!-- Page Numbers -->
                <div id="page-buttons" class="flex space-x-1">
                    <?php
                    for ($i = 1; $i <= $total_pages; $i++) {
                        $is_current  = ($i === $current_page);
                        $link_class  = $is_current
                            ? 'bg-[#FFCD27] text-black px-4 py-2 rounded shadow-lg ring-2 ring-[#FFCD27] transform scale-110 pointer-events-none'
                            : 'px-4 py-2 text-[#FFCD27] rounded hover:bg-gradient-to-r hover:from-[#B40303] hover:to-[#7A0202] hover:scale-110 transition';
                        echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="' . $link_class . '" style="background: radial-gradient(131.61% 131.61% at 50% 50%, #B40303 0%, #7A0202 100%);">' . $i . '</a>';
                    }
                    ?>
                </div>

                <!-- Next Button -->
                <a href="<?php echo ($current_page < $total_pages) ? get_pagenum_link($current_page + 1) : '#'; ?>"
                    class="px-4 py-2 text-[#FFCD27] rounded cursor-pointer hover:bg-gradient-to-r hover:from-[#B40303] hover:to-[#7A0202] hover:scale-110 transition <?php echo ($current_page == $total_pages) ? 'opacity-50 pointer-events-none' : ''; ?>"
                    style="background: radial-gradient(131.61% 131.61% at 50% 50%, #B40303 0%, #7A0202 100%);">
                    <i class="fa-solid fa-angle-right text-[#FFCD27] hover:text-white"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>