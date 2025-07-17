<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template Part - Home » News Section
 *
 * Expected $args:
 * - home_news_group (group):
 *     · sub_title (string)
 *     · main_title (string)
 *     · description (string)
 *     · link (array or string)
 * - home_news_category (taxonomy term or category)
 * - home_news_number (number of posts to display)
 *
 * @param array $args
 */

$news_group = $args['home_news_group'] ?? null;
if (!$news_group) return;

$sub_title   = esc_html($news_group['sub_title'] ?? '');
$main_title  = esc_html($news_group['main_title'] ?? '');
$description = esc_html($news_group['description'] ?? '');
$link        = $news_group['link'] ?? '#'; // Could be string or array depending on return format

// Handle ACF Link field (array or string)
if (is_array($link)) {
  $link_url    = esc_url($link['url'] ?? '#');
  $link_title  = esc_html($link['title'] ?? 'Xem thêm');
  $link_target = esc_attr($link['target'] ?? '_self');
} else {
  $link_url    = esc_url($link);
  $link_title  = 'Xem thêm';
  $link_target = '_self';
}

// Get the category term and number of posts from $args
$term         = $args['home_news_category'] ?? null;
$posts_number = $args['home_news_number'] ?? 1; // Default to 5 if no number is set

$news_query = null;

// Only run the query if a valid taxonomy term is provided
if ($term && is_object($term)) {
  $news_query = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => $posts_number, // Use the number from the argument
    'tax_query'      => [
      [
        'taxonomy' => 'category', // Ensure this is the correct taxonomy
        'field'    => 'term_id',
        'terms'    => $term->term_id,
      ]
    ]
  ]);
}
?>

<!-- News Section Top -->
<section class="py-12 px-8 overflow-hidden">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8 items-center text-center md:text-left">

    <!-- Left side: Text -->
    <div class="flex-1 text-left">
      <?php if ($sub_title): ?>
        <h2 class="text-black font-bold text-base sm:text-lg md:text-xl fade-left"><?= $sub_title ?></h2>
      <?php endif; ?>

      <?php if ($main_title): ?>
        <h1 class="text-[#E7292B] font-bold text-2xl sm:text-3xl md:text-4xl mt-1 fade-left delay-200 ">
          <?= $main_title ?>
        </h1>
      <?php endif; ?>

      <?php if ($description): ?>
        <p class="text-[#262626] mt-3 text-sm sm:text-base md:text-lg fade-left delay-4s">
          <?= $description ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- Right side: Button -->
    <div class="flex-1 flex justify-center md:justify-end items-center">
      <a href="<?= $link_url ?>" target="<?= $link_target ?>"
        class="inline-flex items-center gap-2 px-6 sm:px-8 md:px-10 py-2 sm:py-3 fade-right delay-200 bg-[#E7292B] text-white text-sm sm:text-base md:text-lg font-semibold border border-white rounded-full hover:bg-[#c92021] transition duration-300">
        <?= $link_title ?>
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>
  </div>

  <!-- News Swiper -->
  <div class="home-news-swiper swiper mt-16 w-full h-[420px] sm:h-[480px] md:h-[560px] relative overflow-visible fade-up delay-6s">
    <div class="swiper-wrapper">
      <?php if ($news_query && $news_query->have_posts()): ?>
        <?php while ($news_query->have_posts()): $news_query->the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="swiper-slide rounded-lg shadow-md relative overflow-hidden max-w-[90vw] mx-auto">
            <!-- Image -->
            <div class="h-[85%] overflow-hidden">
              <img src="<?= get_the_post_thumbnail_url(null, 'large'); ?>" alt="<?php the_title(); ?>" class="w-full h-full object-cover">
            </div>

            <!-- Floating Date Box -->
            <div class="absolute right-[-5%] -translate-x-1/2 bottom-[12%] w-10 h-10 sm:w-12 sm:h-12 bg-[#FDAD24] rounded-md flex flex-col items-center justify-center text-[10px] sm:text-xs font-bold shadow-md">
              <span class="text-white"><?= get_the_date('d.m'); ?></span>
              <span class="text-white"><?= get_the_date('Y'); ?></span>
            </div>

            <!-- Title -->
            <div class="h-[15%] px-4 bg-[#27A116] text-white text-sm sm:text-base flex items-center justify-center text-start">
              <p><?php the_title(); ?></p>
            </div>
          </a>
        <?php endwhile; wp_reset_postdata(); ?>
      <?php else: ?>
        <p class="text-center text-gray-500 w-full py-10">Không có bài viết nào trong chuyên mục được chọn.</p>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="swiper-pagination"></div>

    <!-- Navigation Buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>
</section>
