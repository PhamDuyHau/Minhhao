<?php

/**
 * Template Name: History
 * Template Post Type: page
 * 
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;
get_header();
?>

<?php
get_template_part('template-part/block/breadcrumbs');
?>

<?php
$main_title = get_field('history_main_title');
$history_items = get_field('history_items');
if ($history_items):
?>

<!-- Desktop -->
<section class="py-20 bg-white relative hidden md:block">
    <div class="max-w-7xl mx-auto px-4">
        <?php if ($main_title): ?>
            <h1 class="text-3xl  text-center mb-20 text-[#E7292B] font-bold">
                <?php echo esc_html($main_title); ?>
            </h1>
        <?php endif; ?>

        <div class="flex flex-col items-center relative">
            <div id="timeline-line" class="absolute left-1/2 -translate-x-1/2 w-0.5 bg-[#E7292B] z-[1] h-full"></div>
              <div id="timeline-active-dot" class="absolute w-6 h-6 bg-[#E7292B] rounded-full z-10 transition-all duration-300"></div>

            <!-- Timeline Blocks -->
            <div class="flex flex-col space-y-32 w-full max-w-7xl">
                <?php foreach ($history_items as $item): 
                    $title = $item['re_title'];
                    $desc = $item['re_description'];
                    $img_url = wp_get_attachment_image_url($item['re_img'], 'full');
                    $position = $item['re_position']; // 'left' or 'right'
                    $is_left = $position === 'left';
                ?>
                <div class="flex items-center justify-between w-full">
                    <!-- Left Side -->
                    <?php if ($is_left): ?>
                        <!-- Image -->
                        <div class="w-1/2 flex justify-end">
                            <div class="rounded-2xl overflow-hidden shadow-2xl">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-[500px] h-[300px] object-cover" />
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Content -->
                        <div class="w-1/2 text-right">
                            <h1 class="text-4xl text-[#E7292B] font-bold mb-2 "><?php echo esc_html($title); ?></h1>
                            <div class="text-gray-600"><?php echo wp_kses_post($desc); ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Center: Timeline Dot & Arrows -->
                    <div class="relative w-[300px] flex justify-center items-center">
                        <!-- Line -->
                        <div class="absolute top-1/2 left-1/2 w-[80%] h-0.5 bg-red-600 -translate-x-1/2 -translate-y-1/2 z-0"></div>

                        <?php if ($is_left): ?>
                            <!-- Arrow tip left -->
                            <div class="absolute top-1/2 left-[10%] -translate-y-1/2 
                                w-0 h-0 border-t-4 border-b-4 border-r-6 
                                border-t-transparent border-b-transparent border-r-red-600 z-10"></div>
                            <!-- Small dot right -->
                            <div class="absolute top-1/2 right-[10%] -translate-y-1/2 
                                w-2 h-2 bg-red-600 rounded-full shadow-sm z-10"></div>
                        <?php else: ?>
                            <!-- Small dot left -->
                            <div class="absolute top-1/2 left-[10%] -translate-y-1/2 
                                w-2 h-2 bg-red-600 rounded-full shadow-sm z-10"></div>
                            <!-- Arrow tip right -->
                            <div class="absolute top-1/2 right-[10%] -translate-y-1/2 
                                w-0 h-0 border-t-4 border-b-4 border-l-6 
                                border-t-transparent border-b-transparent border-l-red-600 z-10"></div>
                        <?php endif; ?>

                        <!-- Main Dot -->
                        <div class="timeline-dot"></div>
                    </div>

                    <!-- Right Side -->
                    <?php if ($is_left): ?>
                        <!-- Content -->
                        <div class="w-1/2">
                            <h1 class="text-4xl text-[#E7292B] font-bold mb-2 "><?php echo esc_html($title); ?></h1>
                            <div class="text-gray-600"><?php echo wp_kses_post($desc); ?></div>
                        </div>
                    <?php else: ?>
                        <!-- Image -->
                        <div class="w-1/2 flex justify-start">
                            <div class="rounded-2xl overflow-hidden shadow-2xl">
                                <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-[500px] h-[300px] object-cover" />
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Mobile -->
<section class="py-20 bg-white block md:hidden">
    <div class="max-w-7xl mx-auto px-4">
        <?php if ($main_title): ?>
            <h1 class="text-3xl  text-center mb-20 text-[#E7292B] font-bold">
                <?php echo esc_html($main_title); ?>
            </h1>
        <?php endif; ?>

        <div class="flex flex-col space-y-20">
            <?php foreach ($history_items as $index => $item):
                $title = $item['re_title'];
                $desc = $item['re_description'];
                $img_url = wp_get_attachment_image_url($item['re_img'], 'full');
                $position = $item['re_position'];
                $reverse = ($position === 'right') ? 'md:flex-row-reverse md:text-right md:space-x-reverse' : 'md:flex-row md:text-left';
            ?>
            <div class="flex flex-col items-center space-y-4 <?php echo $reverse; ?> md:space-y-0 md:space-x-8">
                <div class="w-full md:w-1/2">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>"
                         class="w-full h-auto max-h-[250px] object-cover rounded-2xl shadow-2xl" />
                </div>
                <div class="w-full md:w-1/2 text-center <?php echo ($position === 'right') ? 'md:text-right' : 'md:text-left'; ?>">
                    <h1 class="text-2xl md:text-4xl text-[#E7292B] font-bold mb-2 ">
                        <?php echo esc_html($title); ?>
                    </h1>
                    <div class="text-gray-600 text-sm md:text-base">
                        <?php echo wp_kses_post($desc); ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>


<?php get_footer(); ?>