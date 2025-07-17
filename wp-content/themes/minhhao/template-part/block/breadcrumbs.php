<?php

/**
 * Full Hero Section with Breadcrumbs and Dynamic ACF Image
 */
defined( 'ABSPATH' ) || exit;

// Use passed arguments or fallback
$page_title  = $args['page_title'] ?? get_the_title();
$breadcrumbs = $args['breadcrumbs'] ?? null;
$hero_image_id = get_field('hero_image', 'option');
$hero_img_url = wp_get_attachment_image_url($hero_image_id, 'full')
    ?: get_template_directory_uri() . '/dist/assets/hero-sub-DCK5kuzD.png';
// If breadcrumbs not passed, build it dynamically
if (!$breadcrumbs) {
    $breadcrumbs = [
        [
            'label' => 'Trang chủ',
            'url'   => home_url('/'),
        ],
    ];

    if (is_404()) {
        $breadcrumbs[] = [
            'label' => 'Không tìm thấy trang',
            'url'   => '',
        ];
        $page_title = '404 - Không tìm thấy trang';

    } elseif (is_tax('product_cat')) {
        $term = get_queried_object();
        $breadcrumbs[] = [
            'label' => 'Sản phẩm',
            'url'   => home_url('/san-pham/'),
        ];

        if ($term->parent) {
            $parent = get_term($term->parent, 'product_cat');
            $breadcrumbs[] = [
                'label' => $parent->name,
                'url'   => get_term_link($parent),
            ];
        }

        $breadcrumbs[] = [
            'label' => $term->name,
            'url'   => '',
        ];
        $page_title = $term->name;

    } elseif (is_shop() || is_post_type_archive('product')) {
        $breadcrumbs[] = [
            'label' => 'Sản phẩm',
            'url'   => '',
        ];
        $page_title = get_the_title(wc_get_page_id('shop'));

    } elseif (is_single() && get_post_type() === 'post') {
        $breadcrumbs[] = [
            'label' => 'Tin tức',
            'url'   => home_url('/tin-tuc/'),
        ];
        $breadcrumbs[] = [
            'label' => get_the_title(),
            'url'   => '',
        ];
        $page_title = 'Tin tức';

    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor_id) {
                $breadcrumbs[] = [
                    'label' => get_the_title($ancestor_id),
                    'url'   => get_permalink($ancestor_id),
                ];
            }
        }
        $breadcrumbs[] = [
            'label' => get_the_title(),
            'url'   => '',
        ];
    } elseif (is_search()) {
        $breadcrumbs[] = [
            'label' => 'Tìm kiếm',
            'url'   => '',
        ];
        $page_title = 'Tìm kiếm';
    }

}

?>

<section class="lg:h-[600px] md:h-[500px] sm:h-[400px] h-[300px] text-white" style="background: var(--main-bg);">
    <div class="max-w-7xl mx-auto px-4 h-full flex flex-col md:flex-row items-center justify-between">

        <!-- Left: Title and Breadcrumb -->
        <div class="w-full md:w-1/2 flex flex-col items-center justify-center text-center md:items-start md:text-left h-full">
            <div>
                <h1 class="text-4xl text-[#FFCD27] md:text-5xl font-bold mb-4">
                    <?= esc_html($page_title); ?>
                </h1>

                <nav class="text-white text-sm md:text-base mb-4" aria-label="Breadcrumb">
                    <ol class="list-reset flex justify-center md:justify-start items-center space-x-2">
                        <?php foreach ($breadcrumbs as $index => $crumb) : ?>
                            <li>
                                <?php if (!empty($crumb['url'])) : ?>
                                    <a href="<?= esc_url($crumb['url']); ?>" class="text-white hover:underline">
                                        <?= esc_html(mb_strimwidth(html_entity_decode($crumb['label']), 0, 45, '...')); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="font-semibold"><?= esc_html(mb_strimwidth(html_entity_decode($crumb['label']), 0, 45, '...')); ?></span>
                                <?php endif; ?>
                            </li>
                            <?php if ($index !== array_key_last($breadcrumbs)) : ?>
                                <li><span class="mx-2">/</span></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Right: Hero Image -->
        <div class="w-full md:w-1/2 mt-8 md:mt-0 justify-center md:justify-end relative hidden md:flex">
            <img src="<?= esc_url($hero_img_url); ?>" alt="<?= esc_attr($page_title); ?>" class="max-h-[500px] object-contain z-0" />
        </div>

    </div>
</section>