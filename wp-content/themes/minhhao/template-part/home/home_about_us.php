<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template part for the About Us (Về chúng tôi) section.
 *
 * @param array $args ACF data passed from the flexible content field.
 */

$group = $args['home_about_group'] ?? [];

$sub_title   = $group['sub_title'] ?? '';
$main_title  = $group['main_title'] ?? '';
$description = $group['description'] ?? '';
$link        = $group['link'] ?? [];

$image_bg    = wp_get_attachment_image_url($group['image_bg'] ?? '', 'full');

// Decorative images
$image_urls = [];
for ($i = 1; $i <= 6; $i++) {
    $img_id = $group["image_$i"] ?? null;
    $image_urls[$i] = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
}
?>

<section class="relative flex items-center py-20 lg:py-8 pb-20 overflow-hidden lg:h-[800px] h-auto" style="
    background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/about-intro-bg-white-wave-85qhpl5_.png'), linear-gradient(#7A0202, #7A0202);
    background-repeat: no-repeat, no-repeat;
    background-position: center, 0 0;
    background-size: cover, cover;
">
  <!-- Center Background Image (ACF image_bg) -->
  <?php if (!empty($image_bg)) : ?>
    <img src="<?= esc_url($image_bg); ?>" alt="Center Decoration"
      class="absolute inset-0 mx-auto top-1/2 -translate-y-1/2 z-0 pointer-events-none max-w-[80%] opacity-5 filter invert md:max-w-[60%] lg:max-w-full" />
  <?php endif; ?>

  <!-- Decorative Images (image_1 to image_6) -->
  <?php if (!empty($image_urls[1])) : ?>
    <img src="<?= esc_url($image_urls[1]); ?>" alt=""
      class="absolute top-1/2 left-[-150px] z-10 w-[200px] h-[200px] -translate-y-1/2 hidden md:block lg:w-[276px] lg:h-[276px]" />
  <?php endif; ?>

  <?php if (!empty($image_urls[2])) : ?>
    <img src="<?= esc_url($image_urls[2]); ?>" alt=""
      class="absolute top-1/2 left-[10%] z-10 w-[100px] h-[100px] -translate-y-1/2 hidden md:block lg:left-[20%] lg:w-[134px] lg:h-[134px]" />
  <?php endif; ?>

  <?php if (!empty($image_urls[3])) : ?>
    <img src="<?= esc_url($image_urls[3]); ?>" alt=""
      class="absolute top-32 left-[10%] z-10 w-[100px] h-[100px] hidden md:block lg:left-[20%] lg:w-[134px] lg:h-[134px]" />
  <?php endif; ?>

  <?php if (!empty($image_urls[4])) : ?>
    <img src="<?= esc_url($image_urls[4]); ?>" alt=""
      class="absolute bottom-10 hidden md:block left-[10%] md:left-[15%] lg:left-[18%] xl:left-[25%] 2xl:left-[30%]
            w-[200px] h-[200px] lg:w-[300px] lg:h-[300px] z-10" />
  <?php endif; ?>

  <?php if (!empty($image_urls[5])) : ?>
    <img src="<?= esc_url($image_urls[5]); ?>" alt=""
      class="absolute top-60 right-[-100px] z-10 w-[180px] h-[180px] hidden lg:block" />
  <?php endif; ?>

  <?php if (!empty($image_urls[6])) : ?>
    <img src="<?= esc_url($image_urls[6]); ?>" alt=""
      class="absolute bottom-49 right-[-60px] z-10 w-[120px] h-[200px] rotate-[45deg] hidden lg:block" />
  <?php endif; ?>

  <!-- Main Content -->
  <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-10 relative z-20">
    <!-- Left -->
    <div class="w-full md:w-1/2 relative"></div>

    <!-- Right -->
    <div class="w-full md:w-1/2 text-center md:text-left space-y-5">
      <?php if ($sub_title) : ?>
        <h4 class="text-lg md:text-xl font-bold text-[#5B5B5B] fade-right"><?= esc_html($sub_title); ?></h4>
      <?php endif; ?>

      <?php if ($main_title) : ?>
        <h1 class="text-2xl  lg:text-4xl font-bold  text-[#E7292B] fade-up delay-3s"><?= esc_html($main_title); ?></h1>
      <?php endif; ?>

        <?php if ($description) : ?>
        <div class="fade-up delay-5s text-sm md:text-base lg:text-base leading-relaxed text-black">
            <?= wp_kses_post($description); ?>
        </div>
        <?php endif; ?>

      <?php if (!empty($link['url'])) : ?>


        <a href="<?= esc_url($link['url']); ?>" target="<?= esc_attr($link['target'] ?? '_self'); ?>"
          class="inline-flex fade-up delay-8s items-center gap-2 px-8 py-2 bg-[#E7292B] text-white text-base md:text-lg font-semibold  border border-white rounded-full hover:bg-[#c92021] transition duration-300">
          <?= esc_html($link['title'] ?? ''); ?>

            <i class="fa-solid fa-arrow-right"></i>
          <?php endif; ?>
        </a>

    </div>
  </div>
</section>
