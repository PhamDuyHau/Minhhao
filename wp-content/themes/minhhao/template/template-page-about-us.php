<?php

/**
 * Template Name: About Us
 * Template Post Type: page
 * The template for displaying the about-us page using ACF Flexible Content.

 * @author Hau
 */
defined( 'ABSPATH' ) || exit;

get_header();
get_template_part(slug: 'template-part/block/breadcrumbs');
?>

<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

$items = get_field('about_us_items');
if (!$items) return;
?>

<!-- Desktop -->
<section class="py-20 bg-white relative hidden md:block">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col items-center relative">
            <div id="timeline-line" class="absolute left-1/2 -translate-x-1/2 w-1 bg-gray-300 z-1 h-full"></div>
            <div id="timeline-active-dot" class="absolute w-6 h-6 bg-red-600 rounded-full shadow-md transition-all duration-500 z-11"></div>

            <div class="flex flex-col space-y-32 w-full max-w-7xl">
                <?php foreach ($items as $index => $item):
                    $img_position = strtolower(trim($item['re_position'] ?? 'left'));
                    $image_id = $item['re_img'];
                    $image_url = wp_get_attachment_image_url($image_id, 'full');
                ?>

                    <div class="flex items-center justify-between w-full flex-row">
                        <?php if ($img_position === 'left'): ?>
                            <!-- Image Left -->
                            <div class="w-1/2 pr-12 flex justify-end">
                                <div class="w-full">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['re_title']); ?>" class="w-full h-auto object-contain" />
                                </div>
                            </div>

                            <!-- Dot -->
                            <div class="timeline-dot relative z-10 w-6 h-6 bg-gray-200 rounded-full shadow-md"></div>

                            <!-- Content -->
                            <div class="w-1/2 pl-12">
                                <h2 class="text-4xl text-[#E7292B] font-bold mb-2">
                                    <?php echo esc_html($item['re_title']); ?>
                                </h2>
                                <div class="text-black">
                                    <?php echo wp_kses_post($item['re_description']); ?>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- Content Left -->
                            <div class="w-1/2 pr-12">
                                <h2 class="text-4xl text-[#E7292B] font-bold mb-2">
                                    <?php echo esc_html($item['re_title']); ?>
                                </h2>
                                <div class="text-black">
                                    <?php echo wp_kses_post($item['re_description']); ?>
                                </div>
                            </div>

                            <!-- Dot -->
                            <div class="timeline-dot relative z-10 w-6 h-6 bg-gray-200 rounded-full shadow-md"></div>

                            <!-- Image Right -->
                            <div class="w-1/2 pl-12 flex justify-start">
                                <div class="w-full">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['re_title']); ?>" class="w-full h-auto object-contain" />
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>


            </div>
        </div>

        <!-- Decorative background images -->
        <img src="<?php echo get_template_directory_uri(); ?>/dist/assets/about-intro-bg-rice-DutXtjIa.png" alt="Rice Background"
            class="absolute top-[15%] right-[-5%] h-auto z-0 pointer-events-none" />
        <img src="<?php echo get_template_directory_uri(); ?>/dist/assets/about-intro-bg-flour-BYxvb-0E.png" alt="Flour Background"
            class="absolute bottom-20 right-0 w-[40%] h-auto z-0 pointer-events-none" />
    </div>
</section>

<!-- mobile -->
<section class="py-20 bg-white block md:hidden">
    <div class="max-w-7xl mx-auto px-4 space-y-24">

        <?php foreach ($items as $index => $item):
            $img_position = strtolower(trim($item['re_position'] ?? 'left'));
            $image_id = $item['re_img'];
            $image_url = wp_get_attachment_image_url($image_id, 'full');
        ?>

        <div class="flex flex-col md:flex-row items-center justify-center gap-12
            <?php echo ($index % 2 === 1) ? 'md:flex-row-reverse' : 'md:flex-row'; ?>">
            
            <!-- Image -->
            <div class="md:w-1/2 w-full">
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item['re_title']); ?>" class="w-full h-auto" />
            </div>

            <!-- Content -->
            <div class="md:w-1/2 w-full">
                <h2 class="text-2xl md:text-3xl text-[#E7292B] font-bold  mb-4">
                    <?php echo esc_html($item['re_title']); ?>
                </h2>
                <div class="text-black">
                    <?php echo wp_kses_post($item['re_description']); ?>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>
</section>


<?php get_footer(); ?>