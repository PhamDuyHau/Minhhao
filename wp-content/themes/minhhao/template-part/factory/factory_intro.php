<?php
defined( 'ABSPATH' ) || exit;
/**
 * Factory Section Block
 * @param array $args Passed data from flexible content.
 */
$factory = $args['factory_group'] ?? null;

if ($factory):
    $title = $factory['main_title'] ?? '';
    $description = $factory['description'] ?? '';
    $img_id = $factory['img'] ?? '';
    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center gap-16 relative">

        <!-- Left: Text Content -->
        <div class="w-full md:w-1/2 text-justify md:text-left space-y-5">
            <?php if ($title): ?>
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-[#E7292B] fade-up delay-3s">
                    <?= esc_html($title); ?>
                </h1>
            <?php endif; ?>

            <?php if ($description): ?>
                <div class="text-sm md:text-base lg:text-base leading-relaxed text-gray-700 fade-up delay-5s">
                    <?= wp_kses_post($description); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Image Content -->
        <div class="w-full md:w-1/2 relative fade-up delay-7s">
            <?php if ($img_url): ?>
                <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($title); ?>" class="w-full h-auto rounded-lg shadow-lg object-cover">
            <?php endif; ?>
        </div>

    </div>
</section>
<?php endif; ?>
