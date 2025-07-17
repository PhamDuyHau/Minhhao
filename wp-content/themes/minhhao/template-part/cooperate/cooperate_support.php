<?php
defined( 'ABSPATH' ) || exit;
/**
 * Support Steamer Section (Hỗ trợ tủ hấp chuyên dụng)
 * @param array $args ACF data passed from the flexible content field.
 */

// Get fields
$main_title  = $args['main_title'] ?? '';
$description = $args['description'] ?? '';
$link_phone  = $args['link_phone'] ?? [];
$img_bg      = $args['img_bg'] ?? '';
$img_circle  = $args['img_circle'] ?? '';
$big_img     = $args['big_img'] ?? '';
$top_img     = $args['top_img'] ?? '';
$bottom_img  = $args['bottom_img'] ?? '';
?>

<section class="py-16 bg-gray-50" aria-labelledby="support-steamer-title">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-16 relative">

        <!-- Background Image -->
        <?php if ($img_bg): ?>
            <img src="<?= esc_url(wp_get_attachment_image_url($img_bg, 'full')); ?>" alt="Background Decorative"
                class="absolute inset-0 w-full h-full object-cover opacity-10 pointer-events-none z-0">
        <?php endif; ?>

        <!-- Left: Image Content -->
        <div class="w-full md:w-1/2 relative order-last md:order-first flex flex-col md:flex-row gap-4 z-1">

            <!-- Small images -->
            <div class="grid grid-cols-2 md:grid-cols-1 md:grid-rows-2 gap-4 w-full md:w-1/3">
                <?php if ($top_img): ?>
                    <div class="aspect-[1/1] md:h-full w-full fade-left delay-2s">
                        <?= wp_get_attachment_image($top_img, 'full', false, [
                            'class' => 'w-full h-full object-cover rounded-lg shadow-lg',
                            'alt' => 'Top Image',
                        ]); ?>
                    </div>
                <?php endif; ?>
                <?php if ($bottom_img): ?>
                    <div class="aspect-[1/1] md:h-full w-full fade-left delay-3s">
                        <?= wp_get_attachment_image($bottom_img, 'full', false, [
                            'class' => 'w-full h-full object-cover rounded-lg shadow-lg',
                            'alt' => 'Bottom Image',
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Big image -->
            <?php if ($big_img): ?>
                <div class="w-full md:w-2/3 fade-left">
                    <div class="aspect-[4/3] md:h-full w-full">
                        <?= wp_get_attachment_image($big_img, 'full', false, [
                            'class' => 'w-full h-full object-cover rounded-lg shadow-lg',
                            'alt' => 'Main Image',
                        ]); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Text Content -->
        <div class="w-full md:w-1/2 text-left md:text-left space-y-6 fade-right">
            <?php if ($main_title): ?>
                <h1 id="support-steamer-title"
                    class="text-xl md:text-2xl lg:text-3xl font-bold uppercase text-[#E7292B] fade-right delay-3s">
                    <?= esc_html($main_title); ?>
                </h1>
            <?php endif; ?>

            <div class="fade-right delay-4s">
                <?php if ($description): ?>
                    <p class="text-sm md:text-base lg:text-base leading-relaxed text-gray-700">
                        <?= wp_kses_post($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($link_phone['url'])): ?>
                <a href="<?= esc_url($link_phone['url']); ?>"
                    target="<?= esc_attr($link_phone['target'] ?? '_self'); ?>"
                    class="inline-flex items-center bg-[#E7292B] text-white font-semibold px-6 py-3 rounded-full hover:bg-red-700 hover:scale-110 transition fade-right delay-5s cursor-pointer">
                    <?= esc_html($link_phone['title'] ?? 'Liên hệ'); ?>
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>