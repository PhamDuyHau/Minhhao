<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template part - Home » Quality Section (Chất lượng từ tâm)
 *
 * Expected $args:
 * - home_box_items (repeater)
 *     · re_main_title (string)
 *     · re_sub_title (string)
 *     · re_description (string)
 * - home_big_image_1 (image ID)
 * - home_big_image_2 (image ID)
 * - home_bg_image (image ID)
 *
 * @param array $args Passed data from flexible content.
 */

$box_items    = $args['home_box_items'] ?? [];
$big_image_1  = $args['home_big_image_1'] ?? null;
$big_image_2  = $args['home_big_image_2'] ?? null;
$bg_image     = $args['home_bg_image'] ?? null;
$animate_image_top     = $args['home_animate_image_top'] ?? null;
$animate_image_bottom     = $args['home_animate_image_bottom'] ?? null;

if (empty($box_items)) return;
?>

<section class="relative lg:py-40 overflow-visible lg:min-h-[1200px] min-h-[600px] md:min-h-[700px]"
  style="background: var(--main-bg);">

  <!-- Decorative Images Left -->
  <?php if ($big_image_1): ?>
    <img src="<?= esc_url(wp_get_attachment_image_url($big_image_1, 'full')) ?>" alt=""
      class="hidden md:block absolute top-[25%] left-[-5%] z-1 md:scale-60 lg:scale-100 origin-top-left transition-transform duration-300" />
  <?php endif; ?>

  <?php if ($big_image_2): ?>
    <img src="<?= esc_url(wp_get_attachment_image_url($big_image_2, 'full')) ?>" alt=""
      class="hidden md:block absolute top-[40%] left-[-5%] z-1 md:scale-60 lg:scale-100 origin-top-left transition-transform duration-300" />
  <?php endif; ?>

  <!-- Decorative Image Right -->
  <img src="<?= get_theme_file_uri('/dist/assets/home-quality-3-DmAPvujb.png') ?>" alt=""
    class="absolute top-[-5%] right-0 z-1 md:scale-70 lg:scale-100 hidden sm:block w-24 md:w-auto" />

  <!-- Main Container -->
  <div class="max-w-7xl mx-auto px-4 relative z-20 flex flex-col md:flex-row items-start gap-10">

    <!-- Left Side -->
    <div class="w-full md:w-1/2">
      <!-- Optional image or content here -->
    </div>

    <!-- Right Side: 2x2 Grid -->
    <div class="w-full md:w-1/2 grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3 sm:mt-20 md:mt-40 lg:mt-0">
      <?php foreach ($box_items as $i => $box):
        $main_title   = esc_html($box['re_title_main'] ?? '');
        $sub_title    = esc_html($box['re_title_sub'] ?? '');
        $description  = esc_html($box['re_description'] ?? '');

        $color_map = [
          ['border-[#63B343]', 'stroke-fill-green', 'text-[#63B343]', 'delay-4s'],
          ['border-[#79D2F7]', 'stroke-fill-blue',  'text-[#79D2F7]',  'delay-6s'],
          ['border-[#DEAC50]', 'stroke-fill-yellow', 'text-[#DEAC50]', 'delay-8s'],
          ['border-[#DD3C27]', 'stroke-fill-red',   'text-[#DD3C27]',  'delay-10s']
        ];

        $colors          = $color_map[$i % count($color_map)];
        $box_color_class = $colors[0];
        $stroke_class    = $colors[1];
        $text_color      = $colors[2];
        $delay_class     = $colors[3];
        $position_class  = ($i % 2 !== 0) ? 'relative md:-top-2 lg:-top-4' : '';
      ?>
        <div class="<?= $position_class ?> bg-white p-2 sm:p-3 lg:p-6 rounded-xl lg:rounded-2xl shadow border-2 lg:border-4 <?= $box_color_class ?> fade-up <?= $delay_class ?>">
          <h1 class="text-xl sm:text-2xl lg:text-6xl font-bold mb-1 <?= $stroke_class ?>"><?= $main_title ?></h1>
          <h2 class="text-[10px] sm:text-xs lg:text-lg font-bold mb-1 <?= $text_color ?> "><?= $sub_title ?></h2>
          <p class="text-[10px] sm:text-xs lg:text-base text-black leading-snug"><?= $description ?></p>
        </div>
      <?php endforeach; ?>


    </div>

  </div>

  <!-- Top Wave -->
  <img src="data:image/svg+xml,%3csvg%20id='visual'%20viewBox='0%200%20900%20600'%20width='900'%20height='600'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20version='1.1'%3e%3cpath%20d='M0%2042L30%2049.8C60%2057.7%20120%2073.3%20180%2075C240%2076.7%20300%2064.3%20360%2057.2C420%2050%20480%2048%20540%2040.7C600%2033.3%20660%2020.7%20720%2017.5C780%2014.3%20840%2020.7%20870%2023.8L900%2027L900%200L870%200C840%200%20780%200%20720%200C660%200%20600%200%20540%200C480%200%20420%200%20360%200C300%200%20240%200%20180%200C120%200%2060%200%2030%200L0%200Z'%20fill='%23FFFFFF'%20stroke-linecap='round'%20stroke-linejoin='miter'%3e%3c/path%3e%3c/svg%3e"
    class="absolute top-0 left-0 w-full h-autoz-0 pointer-events-none" alt="Top Wave" />

  <!-- Bottom Wave -->
  <img src="data:image/svg+xml,%3csvg%20id='visual'%20viewBox='0%200%20900%20600'%20width='900'%20height='600'%20xmlns='http://www.w3.org/2000/svg'%20xmlns:xlink='http://www.w3.org/1999/xlink'%20version='1.1'%3e%3cpath%20d='M0%20567L12.5%20558.8C25%20550.7%2050%20534.3%2075%20525.2C100%20516%20125%20514%20150%20514C175%20514%20200%20516%20225%20521.8C250%20527.7%20275%20537.3%20300%20536.8C325%20536.3%20350%20525.7%20375%20519.5C400%20513.3%20425%20511.7%20450%20514.7C475%20517.7%20500%20525.3%20525%20532.5C550%20539.7%20575%20546.3%20600%20543.3C625%20540.3%20650%20527.7%20675%20524.2C700%20520.7%20725%20526.3%20750%20526.3C775%20526.3%20800%20520.7%20825%20523.3C850%20526%20875%20537%20887.5%20542.5L900%20548L900%20601L887.5%20601C875%20601%20850%20601%20825%20601C800%20601%20775%20601%20750%20601C725%20601%20700%20601%20675%20601C650%20601%20625%20601%20600%20601C575%20601%20550%20601%20525%20601C500%20601%20475%20601%20450%20601C425%20601%20400%20601%20375%20601C350%20601%20325%20601%20300%20601C275%20601%20250%20601%20225%20601C200%20601%20175%20601%20150%20601C125%20601%20100%20601%2075%20601C50%20601%2025%20601%2012.5%20601L0%20601Z'%20fill='%23FFEECF'%20stroke-linecap='round'%20stroke-linejoin='miter'%3e%3c/path%3e%3c/svg%3e"
    class="absolute bottom-0 left-0 w-full h-auto z-0 pointer-events-none" alt="Bottom Wave" />


  <!-- Jumping Animations -->
  <?php if ($animate_image_top): ?>
    <img src="<?= esc_url(wp_get_attachment_image_url($animate_image_top, 'full')) ?>"
      alt="Top Animation"
      class="absolute top-[-8%] sm:top-[-2%] left-[10%] sm:left-[5%] z-1 animate-float pointer-events-none
          w-12 sm:w-16 md:w-36  xl:w-auto" />
  <?php endif; ?>

  <?php if ($animate_image_bottom): ?>
    <img src="<?= esc_url(wp_get_attachment_image_url($animate_image_bottom, 'full')) ?>"
      alt="Bottom Animation"
      class="absolute bottom-0 right-[10%] sm:right-[5%] z-1 animate-float pointer-events-none
          w-12 sm:w-16 md:w-36 xl:w-auto" />
  <?php endif; ?>

</section>