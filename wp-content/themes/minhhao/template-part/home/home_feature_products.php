<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template part – Home » Feature Products (Sản phẩm nổi bật)
 *
 * Expected $args:
 *  - home_main_title      (string)
 *  - home_description     (string)
 *  - home_feature_items   (repeater)
 *      · re_image_main    (image ID)
 *      · re_image_bg      (image ID)
 *      · re_name          (string)
 *      · re_description   (string)
 *      · re_link          (link array)
 *      · re_shopee        (link array)
 */

$main_title  = $args['home_main_title']  ?? '';
$description = $args['home_description'] ?? '';
$items       = $args['home_feature_items'] ?? [];

if (empty($items)) {
    return; // nothing to render
}
?>

<section class="bg-white overflow-x-visible">
    <div class="relative overflow-visible mx-auto">

        <!-- Title & description -->
        <div class="flex flex-col items-center text-center">
            <?php if ($main_title) : ?>
                <h1 class="text-3xl font-bold text-[#E7292B]  fade-up">
                    <?= esc_html($main_title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="text-black fade-up delay-2s">
                    <?= wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Swiper -->
        <div class="swiper home-feature-swiper overflow-visible fade-up delay-4s">
            <div class="swiper-wrapper py-12">
                <?php foreach ($items as $item) :
                    $img_main = wp_get_attachment_image_url($item['re_image_main'] ?? 0, 'full');
                    $img_bg   = wp_get_attachment_image_url($item['re_image_bg']   ?? 0, 'full');
                    $name     = $item['re_name']        ?? '';
                    $desc     = $item['re_description'] ?? '';
                    $link     = $item['re_link']        ?? [];
                    $shopee   = $item['re_shopee']      ?? [];
                ?>
                <!-- Slide -->
                <div class="swiper-slide w-[80%] sm:w-[50%] md:w-[33.333%] flex-shrink-0 flex flex-col items-center justify-center overflow-visible relative text-center">
                    <!-- Image block -->
                    <div class="relative aspect-square w-[300px] sm:w-[400px] md:w-[500px] mx-auto overflow-visible flex items-center justify-center transition-all duration-300">
                        <?php if ($img_bg) : ?>
                            <img src="<?= esc_url($img_bg); ?>" alt="Product Background"
                                 class="product-bg absolute inset-0 w-full h-full object-contain z-0 pointer-events-none transition-all duration-700 ease-out opacity-0">
                        <?php endif; ?>

                        <?php if ($img_main) : ?>
                            <img src="<?= esc_url($img_main); ?>" alt="<?= esc_attr($name); ?>"
                                 class="relative z-10 w-full h-full object-contain product-image">
                        <?php endif; ?>

                        
                    </div>

                    <!-- Content -->
                    <div class="product-content mt-6 items-center opacity-0 transition-all duration-700 ease-out sm:text-center max-w-[320px] md:max-w-none mx-auto break-words">
                        <h2 class="text-lg sm:text-2xl md:text-3xl font-bold text-[#E7292B] mb-2 whitespace-normal">
                            <?= esc_html($name); ?>
                        </h2>

                        <?php if ($desc) : ?>
                            <p class="text-sm md:text-base text-black mb-4 md:break-normal md:whitespace-normal">
                                <?= wp_kses_post($desc); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Buttons -->
                        <div class="flex flex-wrap justify-center gap-2 sm:gap-4">
                            <?php if (!empty($link['url'])) : ?>
                                <a href="<?= esc_url(url: $link['url']); ?>"
                                   class="inline-flex items-center gap-1 px-3 py-[5px] sm:px-10 sm:py-1 bg-[#E7292B] text-white text-xs sm:text-lg font-semibold  border border-white rounded-full hover:bg-[#d32628] transition-all duration-300 ease-in-out shadow-lg hover:shadow-md hover:-translate-y-1"
                                   <?= isset($link['target']) ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                                   <?= esc_html($link['title'] ?? 'Xem chi tiết'); ?>
                                   <i class="fas fa-arrow-right text-[10px] sm:text-base"></i>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($shopee['url'])) : ?>
                                <a href="<?= esc_url($shopee['url']); ?>"
                                   class="inline-flex items-center gap-2 sm:gap-4 px-1 pr-2 sm:px-1 sm:pr-4 py-[5px] sm:py-1 bg-[#FC5722] text-white text-xs sm:text-lg font-semibold  border border-white rounded-full hover:bg-[#e94c1d] transition-all duration-300 ease-in-out shadow-lg hover:shadow-md hover:-translate-y-1"
                                   <?= isset($shopee['target']) ? 'target="' . esc_attr($shopee['target']) . '"' : ''; ?>>
                                    <span class="w-7 h-7 sm:w-[47px] sm:h-[47px] bg-white rounded-full flex items-center justify-center shrink-0">
                                        <!-- same base64 icon from original -->
                                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABoAAAAdCAYAAAC0T3x2AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAKSSURBVHgBtVZdUtRAEP66swF8MjdwwAOoJ2C9QbAs4A08AeUJgBMoJxDeKLRkOQG5gXgAZTgB4QnYzUzbk80qCJsElv2qsqnNdM83/TtNaInLVWNmhDcFSPVvQiInIrzT+fprt40+tRGqSI6VJBGPPWFYBhZ1KSXBVnTwe/tJiNzKwqmSYED+7bN9a0ffB6sLW0q0Kfo93rcZJkGx/DItVhakWDbpvesr88fhadqH0Yw1fWznwPbuXdU4qWO68m7+BSYiIulqXI7GLUd9l4X3IKYlPJZIUpMgJADoZJwM9WyugbYR8Kpur074uUyN6XRg/l90VH0TSQbvTXfsLiK5qOw4mfibzSikbix8iilCIEccOSSYMtS1z9lFyDFlaA1edOaukLvZ1iqZZuGeKlrySDwoZaK1Ji0GnZedIRRkIwVhW9j3Iscb6nOjDsnh6Uj9kiv5Ya2ux06ZdSE9lcnUyNoCfjd2/CP0u7+diyV0i2bX62GGdST1wmrBzxjoAvcmTmMyiZAtiYQkrz8QLQ6ALFiOR4DJDS3ygrMG2URrbbOvXTrE6qGEeq3kbZrqCOtKdkxO3XDt34SrIVx+bRTFVUTqGot2MJoAX9wsn7PwWp9lKVjYpBQ7On+IRbdPWVkozvfK+qoBfT89G1rE3uJxMBHzRijiJsG2FtVmpRcem+KjxCkLVgptKVHNTuI/6JES8rQhRK9vLGR9ku1qcBmnnP8j0sqtnVKID3UI2e2zXwrRUSVThMtOO3/M/Kmuq0jljZIodHBu6HZV8NdRKsrJDMhofRigUe8ivMsYVSNU2+siKYcRNJOU8MPSuZkMGaaAIvKfbxFF1xpwoR6eDrkHPo4Gzjs5ECafq7nJr/ebE23AH9EbFubI3vaoAAAAAElFTkSuQmCC" alt="icon" class="w-[14px] h-[14px] sm:w-6 sm:h-6" />
                                    </span>
                                    <?= esc_html($shopee['title'] ?? ''); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div><!-- /.swiper-wrapper -->

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div><!-- /.swiper -->
    </div>
</section>
