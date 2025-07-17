<?php
defined( 'ABSPATH' ) || exit;
/**
 * Template part - Home » Consultation Section (Tư vấn và báo giá)
 *
 * Expected $args:
 * - home_quote_group (group)
 *     · main_title (string)
 *     · description (string)
 *     · animation_img (image ID)
 *     · bg_image (image ID)
 *     · right_image_1 (image ID)
 *     · right_image_2 (image ID)
 *
 * @param array $args Passed data from flexible content.
 */

$group        = $args['home_quote_group'] ?? [];
$main_title   = $group['main_title'] ?? '';
$description  = $group['description'] ?? '';
$anim_image   = $group['animation_img'] ?? null;
$bg_image   = $group['bg_img'] ?? null;
$right_img_1  = $group['right_img_1'] ?? null;
$right_img_2  = $group['right_img_2'] ?? null;
$box_title   = $group['box_title'] ?? '';
?>

<section class="py-16  relative overflow-hidden bg-white">

    <!-- Background Hills -->
    <img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20fill='none'%20viewBox='0%200%201726.192468619247%20220.576'%20style='max-height:%20500px'%20width='1726.192468619247'%20height='220.576'%3e%3cellipse%20fill='url(%23paint0_radial_4064_2483)'%20ry='452'%20rx='1431.5'%20cy='452'%20cx='863.5'/%3e%3cdefs%3e%3cradialGradient%20gradientTransform='translate(864%20268)%20rotate(7.32697)%20scale(1442.78%20455.562)'%20gradientUnits='userSpaceOnUse'%20r='1'%20cy='0'%20cx='0'%20id='paint0_radial_4064_2483'%3e%3cstop%20stop-color='%237A0202'/%3e%3cstop%20stop-color='%237A0202'%20offset='1'/%3e%3c/radialGradient%3e%3c/defs%3e%3c/svg%3e" alt="Decor Hill Background"
        class="absolute bottom-0 left-0 w-full h-auto pointer-events-none z-1 hidden md:block" />
    <img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20fill='none'%20viewBox='0%200%201726.054054054054%20295.792'%20style='max-height:%20500px'%20width='1726.054054054054'%20height='295.792'%3e%3cellipse%20fill='%23AC0707'%20ry='486.5'%20rx='1540.5'%20cy='486.5'%20cx='863.5'/%3e%3c/svg%3e" alt="Decor Hill Background"
        class="absolute bottom-0 left-0 w-full h-auto pointer-events-none z-0 hidden md:block" />

    <!-- Image Left -->
    <?php if ($bg_image): ?>

        <div class="hidden md:block">
            <div class="absolute left-0 top-0">
                <img src="<?= esc_url(wp_get_attachment_image_url($bg_image, 'full')) ?>" alt="Decor Left" class="h-auto object-contain" />

            </div>
        </div>
    <?php endif; ?>

    <div class="relative z-20 max-w-7xl mx-auto grid grid-rows-[auto_1fr_auto]">
        <!-- Title -->
        <div class="text-center fade-up space-y-4 max-w-2xl mx-auto">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800  fade-up delay-200">
                <?= wp_kses_post($main_title) ?>
            </h1>
            <p class="text-sm sm:text-base md:text-lg text-black fade-up delay-4s">
                <?= wp_kses_post($description) ?>
            </p>
        </div>

        <!-- Form + Images Row -->
        <div class="relative md:grid md:grid-cols-[1fr_2fr_1fr] items-end gap-8">

            <!-- Left Animation -->
            <?php if ($anim_image): ?>
                <div class="hidden md:block relative h-auto">
                    <div class="absolute left-0 bottom-0">
                        <img src="<?= esc_url(wp_get_attachment_image_url($anim_image, 'full')) ?>" alt="Decor Left"
                            class="w-[80%] h-auto object-contain swing-animation" />
                    </div>
                </div>
            <?php endif; ?>

            <!-- Form Box Placeholder -->
            <div class="col-span-3 md:col-span-1 mt-4 mx-auto w-full sm:w-[90%] md:w-full bg-white shadow-xl rounded-lg p-6 sm:p-6 md:p-8 space-y-6 fade-up delay-6s max-w-[700px]">
            <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-center text-[#E7292B]">
                <?= wp_kses_post($box_title) ?>
            </h2>

            <!-- Form fields go here -->
                <?php echo do_shortcode('[fluentform id="1"]'); ?>
            </div>


            <!-- Right Image Group -->
            <div class="hidden md:block relative h-auto mb-6">
                <?php if ($right_img_1): ?>
                    <div class="absolute right-0 bottom-0">
                        <img src="<?= esc_url(wp_get_attachment_image_url($right_img_1, 'full')) ?>" alt="Decor Right"
                            class="w-full h-full object-contain" />
                    </div>
                <?php endif; ?>
                <?php if ($right_img_2): ?>
                    <div class="absolute right-30 bottom-0 lg:-bottom-20">
                        <img src="<?= esc_url(wp_get_attachment_image_url($right_img_2, 'full')) ?>" alt="Decor Right"
                            class="w-full h-full object-contain scale-75 z-1" />
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>