<?php
defined( 'ABSPATH' ) || exit;
/**
 * Product Section (Sản phẩm đa dạng)
 * @param array $args ACF data passed from the flexible content field.
 */

$main_title  = $args['main_title'] ?? '';
$description = $args['description'] ?? '';
$img_gallery = $args['img_gallery'] ?? [];
?>

<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 space-y-6">
        <?php if ($main_title): ?>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-[#E7292B] text-center fade-up">
                <?= esc_html($main_title); ?>
            </h1>
        <?php endif; ?>

        <div class="fade-up delay-5s">
            <?php if ($description): ?>
                <p class="max-w-6xl mx-auto text-justify text-sm md:text-base lg:text-base leading-relaxed text-gray-700">
                    <?= wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($img_gallery)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 fade-up delay-7s">
                <?php foreach ($img_gallery as $img_id): ?>
                    <div class="w-full aspect-[4/3] overflow-hidden">
                        <?= wp_get_attachment_image($img_id, 'full', false, [
                            'class' => 'w-full h-full object-cover',
                            'alt'   => get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: 'Gallery image',
                        ]); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>