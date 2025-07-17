<?php

/**
 * Template Name: Contact
 * Template Post Type: page
 * The template for displaying the contact page using ACF Flexible Content.
 *
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;

get_header();
get_template_part(slug: 'template-part/block/breadcrumbs');

// Get ACF fields
$contact_detail_group = get_field('contact_detail_group'); // Main contact details group
$contact_social_group  = get_field('contact_social_group'); // Social links group
$contact_title           = get_field('contact_title'); // Title box
$contact_map           = get_field('contact_map'); // Map content
?>

<!-- Contact (Liên hệ với chúng tôi) -->
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-10">

        <!-- Left Side: Contact Info -->
        <div class="space-y-6 animate-fadeInRotateLeft">
            <!-- Section Title -->
            <h2 class="text-2xl md:text-3xl font-bold text-[#E7292B] "><?= esc_html($contact_detail_group['main_title'] ?? ''); ?></h2>

            <!-- Address Box -->
            <div class="bg-[#E7292B] text-white p-4 rounded-lg shadow-md">
                <div class="text-lg font-semibold mb-2">
                    <?= wp_kses_post($contact_detail_group['location_name'] ?? ''); ?>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="space-y-3">
                <p class="flex items-center gap-3 text-gray-700">
                    <i class="fa-solid fa-phone text-black"></i>
                    <?= esc_html($contact_detail_group['phone_number'] ?? ''); ?>
                </p>
                <p class="flex items-center gap-3 text-gray-700">
                    <i class="fa-solid fa-envelope text-black"></i>
                    <?= esc_html($contact_detail_group['email'] ?? ''); ?>
                </p>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-lg font-semibold mb-3"><?= esc_html($contact_social_group['main_title'] ?? ''); ?></h3>
                <div class="flex gap-3">
                    <?php if (!empty($contact_social_group['facebook_link']['url'])): ?>
                        <a href="<?= esc_url($contact_social_group['facebook_link']['url']); ?>"
                            class="w-12 h-12 bg-[#3b5998] rounded-full flex items-center justify-center text-white transform transition-transform duration-300 hover:scale-110 hover:bg-[#2d4373]">
                            <i class="fa-brands fa-facebook-f text-lg"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_social_group['instagram_link']['url'])): ?>
                        <a href="<?= esc_url($contact_social_group['instagram_link']['url']); ?>"
                            class="w-12 h-12 bg-[#E4405F] rounded-full flex items-center justify-center text-white transform transition-transform duration-300 hover:scale-110 hover:bg-[#ba3353]">
                            <i class="fa-brands fa-instagram text-lg"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_social_group['twitter_link']['url'])): ?>
                        <a href="<?= esc_url($contact_social_group['twitter_link']['url']); ?>"
                            class="w-12 h-12 bg-[#1DA1F2] rounded-full flex items-center justify-center text-white transform transition-transform duration-300 hover:scale-110 hover:bg-[#1a91c1]">
                            <i class="fa-brands fa-twitter text-lg"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_social_group['youtube_link']['url'])): ?>
                        <a href="<?= esc_url($contact_social_group['youtube_link']['url']); ?>"
                            class="w-12 h-12 bg-[#FF0000] rounded-full flex items-center justify-center text-white transform transition-transform duration-300 hover:scale-110 hover:bg-[#cc0000]">
                            <i class="fa-brands fa-youtube text-lg"></i>
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($contact_social_group['zalo_link']['url'])): ?>
                        <a href="<?= esc_url($contact_social_group['zalo_link']['url']); ?>"
                            class="w-12 h-12 bg-[#0068FF] rounded-full flex items-center justify-center text-white transform transition-transform duration-300 hover:scale-110 hover:bg-[#0052cc]">
                            <i class="fa-solid fa-comment-dots text-lg"></i> <!-- Zalo placeholder -->
                        </a>
                    <?php endif; ?>
                </div>
            </div>


        </div>

        <!-- Right Side: Subscription Form -->
        <div class="bg-white rounded-lg shadow-md p-6 space-y-6 animate-fadeInRotateRight ">
            <h2 class="md:text-2xl lg:text-3xl font-bold text-[#E7292B] mb-4">
                <?= esc_html($contact_title ?? ''); ?>
            </h2>
            
            <?php echo do_shortcode('[fluentform id="1"]'); ?>
        </div>
    </div>
</section>

<!-- Map Container -->
<section class="relative py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="relative animate-boxOpen">
            <!-- Google Maps Embed -->

                <?= wp_kses($contact_map, array(
                    'iframe' => array(
                        'src' => true,
                        'width' => true,
                        'height' => true,
                        'style' => true,
                        'allowfullscreen' => true,
                    ),
                )); ?>


            <!-- Button in the Middle of Map (Hidden on smaller screens) -->
            <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
                <a href="https://www.google.com/maps?q=Ho+Chi+Minh+City,+Vietnam" target="_blank"
                    class="bg-white text-black py-3 px-8 rounded-full text-lg font-semibold hover:bg-gray-100 transition duration-300 items-center gap-2 pointer-events-auto hidden md:block">
                    <!-- Location Icon -->
                    <i class="fa-solid fa-location text-[#B40303]"></i>
                    Xem bản đồ
                </a>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>