<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template part for displaying the home hero slide block.
 *
 * @param array $args Passed data from flexible content.
 */

$slides = $args['home_slider_list'] ?? [];

if (!empty($slides)) : ?>
  <section class="swiper home-hero-swiper relative min-h-[650px] bg-[var(--main-bg)]" style="background: var(--main-bg);">
    <div class="swiper-wrapper h-auto" id="heroSwiperWrapper">

      <?php foreach ($slides as $slide) :
        $title = $slide['re_title'] ?? '';
        $desc = $slide['re_description'] ?? '';
        $link = $slide['re_link']['url'] ?? '';
        $link_title = $slide['re_link']['title'] ?? '';
        $link_target = $slide['re_link']['target'] ?: '_self';
        $icon = $slide['re_icon'] ?? '';
        $img_id = $slide['re_img'] ?? 0;
        $img_url = wp_get_attachment_image_url($img_id, 'full');
        $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $title;
      ?>
        <div class="swiper-slide overflow-hidden hero-slide flex items-center">
          <div
            class="max-w-7xl mx-auto px-4 py-12 gap-4 flex flex-col-reverse md:flex-row items-center justify-between w-full mt-16 sm:mt-20 md:mt-28 lg:mt-36">

            <!-- Text Content -->
            <div class="w-full md:w-1/2 text-white z-10 mt-8 md:mt-0">
              <?php if ($title) : ?>
                <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 text-[#FFCD27]">
                  <?= esc_html($title); ?>
                </h1>
              <?php endif; ?>

              <?php if ($desc) : ?>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl mb-6">
                  <?= esc_html($desc); ?>
                </p>
              <?php endif; ?>

              <?php if ($link) : ?>
                <a href="<?= esc_url($link); ?>" target="<?= esc_attr($link_target); ?>"
                  class="inline-flex items-center gap-2 px-10 py-2 bg-[#E7292B] text-white text-base sm:text-lg font-semibold  border border-white rounded-full hover:bg-[#c92021] transition">
                  <?= esc_html($link_title); ?>
                  <i class="fas fa-arrow-right"></i>
                </a>
              <?php endif; ?>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 relative">
              <?php if ($img_url) : ?>
                <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>"
                  class="hero-image w-full max-w-md mx-auto md:max-w-full" />
              <?php endif; ?>
            </div>

          </div>
        </div>
      <?php endforeach; ?>

    </div>

    <!-- Arrows and pagination -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
  </section>
<?php endif; ?>
