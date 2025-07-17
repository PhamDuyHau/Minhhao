<?php
defined( 'ABSPATH' ) || exit;
/**
 * System Factory Section
 * @param array $args Passed from Flexible Content
 */

$system = $args['system_group'] ?? null;

if ($system):
    $title = $system['main_title'] ?? '';
    $description = $system['description'] ?? '';
    $gallery_ids = $system['img'] ?? [];
?>
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 space-y-6">
        <?php if ($title): ?>
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold uppercase text-[#E7292B] fade-up">
                <?= esc_html($title); ?>
            </h1>
        <?php endif; ?>

        <?php if ($description): ?>
            <div class="text-justify text-sm md:text-base lg:text-base leading-relaxed text-gray-700 fade-up delay-5s">
                <?= wp_kses_post($description); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($gallery_ids) && is_array($gallery_ids)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 fade-up delay-7s">
                <?php foreach ($gallery_ids as $img_id): 
                    $img_url = wp_get_attachment_image_url($img_id, 'large');
                    $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: 'Factory Image';
                    if ($img_url):
                ?>
                    <div class="w-full aspect-[4/3] overflow-hidden">
                        <img src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" class="w-full h-full object-cover">
                    </div>
                <?php endif; endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
