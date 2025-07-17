<?php
defined( 'ABSPATH' ) || exit;

/**
 * @param array $args ACF data passed from the flexible content field.
 */

$sub_title = $args['sub_title'] ?? '';
$main_title = $args['main_title'] ?? '';
$link_phone = $args['link_phone'] ?? null; // ACF link array
$img_circle = isset($args['img_circle']) ? wp_get_attachment_image($args['img_circle'], 'full', false, ['class' => 'w-full h-full object-cover rounded-full shadow-xl']) : '';
$img_bg_src = isset($args['img_bg']) ? wp_get_attachment_image_src($args['img_bg'], 'full')[0] : '';
?>

<!-- Intro (Minh Hảo đồng hành cùng bạn) -->
<section class="py-16 bg-white">
    <div class="mx-auto grid md:grid-cols-2 gap-12 md:gap-20 lg:gap-28 xl:gap-32 items-center max-w-full lg:max-w-none">
        <!-- Left Side -->
        <div class="space-y-6 px-0 md:px-0 relative">

            <!-- Decorative Background Image -->
            <?php if ($img_bg_src): ?>
                <img src="<?= esc_url($img_bg_src); ?>" alt="Decorative BG"
                    class="absolute top-[20%] left-[75%] w-48 md:w-52 lg:w-80 z-0 pointer-events-none hidden md:block">
            <?php endif; ?>

            <div class="relative z-10 pl-6 md:pl-4 lg:pl-24 space-y-4">
                <?php if ($sub_title): ?>
                    <h2 class="text-base md:text-lg lg:text-xl text-[#E7292B] font-medium fade-left">
                        <?= esc_html($sub_title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($main_title): ?>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#E7292B] leading-snug fade-left delay-3s">
                        <?= esc_html($main_title); ?>
                    </h1>
                <?php endif; ?>

                <?php if (!empty($link_phone['url'])): ?>
                    <a href="<?= esc_url($link_phone['url']); ?>"
                        target="<?= esc_attr($link_phone['target'] ?? '_self'); ?>"
                        class="inline-flex items-center gap-3 bg-[#E7292B] text-white px-6 py-3 rounded-full hover:bg-[#c32225] hover:scale-110 transition text-sm md:text-base lg:text-lg fade-left delay-5s cursor-pointer">
                        <i class="fas fa-phone text-white text-lg"></i>
                        <span class="font-semibold"><?= esc_html($link_phone['title'] ?? 'Liên hệ'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($img_circle): ?>
                <div class="relative w-full max-w-3xl mx-auto z-10 fade-left delay-7s">
                    <!-- Background Image -->
                    <img src="data:image/svg+xml,%3csvg%20width='618'%20height='362'%20viewBox='0%200%20618%20362'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M618%20181C618%2081.0365%20536.964%200%20437%200H-121V362H437C536.964%20362%20618%20280.964%20618%20181Z'%20fill='%23E7292B'/%3e%3c/svg%3e" alt="Hình nền"
                        class="w-full h-auto block">
                    <!-- Circle Image -->
                    <div class="absolute top-[4%] right-[2%] w-[54%] aspect-square">
                        <?= $img_circle; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Side -->
        <div class="relative bg-[#E7292B] text-white rounded-2xl p-8 shadow-xl mx-4 md:mx-8 lg:mx-12 xl:mx-16 overflow-hidden fade-right delay-3s ff-cooperate-intro">
        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold uppercase text-white text-center pb-4">
            Tư vấn - Báo giá
        </h1>

        <img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/cooperate-bg-BewSvt0s.png" alt="Background Decorative"
            class="absolute inset-0 w-full h-full object-cover opacity-10 pointer-events-none z-0">

        <?php echo do_shortcode('[fluentform id="1"]'); ?>
        </div>



    </div>
</section>