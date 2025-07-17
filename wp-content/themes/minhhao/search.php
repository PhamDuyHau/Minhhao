<?php
defined('ABSPATH') || exit;

get_header();
get_template_part('template-part/block/breadcrumbs');

$search_keyword = get_search_query();

$args = [
    'post_type'      => 'product',
    'posts_per_page' => 12,
    's'              => $search_keyword,
    'post_status'    => 'publish',
];
$query = new WP_Query($args);
?>

<main class="py-12 bg-gray-50">
    <!-- Hero Search -->
    <div class="container mx-auto px-4 mb-10">
        <div class="bg-white rounded-xl shadow p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                Tìm kiếm: <span class="text-red-600">"<?php echo esc_html($search_keyword); ?>"</span>
            </h1>
            <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="w-full md:w-1/2">
                <div class="flex items-center rounded-lg border border-gray-300 overflow-hidden">
                    <input 
                        type="search"
                        name="s"
                        value="<?php echo esc_attr($search_keyword); ?>"
                        placeholder="Tìm sản phẩm khác..."
                        class="flex-grow px-4 py-2 text-gray-700 text-sm focus:outline-none"
                        autocomplete="off"
                    >
                    <button type="submit" class="bg-[#E7292B] text-white px-4 py-2 hover:bg-[#b40303] transition">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div class="container mx-auto px-4">
        <?php if ($query->have_posts()): ?>
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                <?php while ($query->have_posts()): $query->the_post(); global $product; ?>
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition overflow-hidden flex flex-col">
                        <a href="<?php the_permalink(); ?>" class="relative group">
                            <?php if (has_post_thumbnail()): ?>
                                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium'); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" />
                            <?php endif; ?>
                        </a>
                        <div class="p-4 flex flex-col flex-grow">
                            <h2 class="text-base font-semibold text-gray-900 mb-1 line-clamp-2">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <?php if ($product): ?>
                                <div class="text-[#E7292B] font-bold text-sm mb-3">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            <?php endif; ?>
                            <a href="<?php the_permalink(); ?>"
                               class="mt-auto inline-block text-center bg-[#E7292B] text-white py-2 px-4 rounded-lg text-sm hover:bg-[#b40303] transition">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-16 text-gray-600 text-lg">
                Không tìm thấy sản phẩm phù hợp với từ khóa <strong>"<?php echo esc_html($search_keyword); ?>"</strong>.
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>
