<?php

/**
 * Template Name: Job
 * Template Post Type: page
 *
 * @author Hau
 */
defined( 'ABSPATH' ) || exit;
get_header();
get_template_part('template-part/block/breadcrumbs');

$args = [
    'post_type'      => 'job',
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'ASC',
];

$query = new WP_Query($args);
$index = 1;
$today = date('Ymd');
?>

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl  text-center mb-12 text-[#E7292B] font-bold">Cơ hội nghề nghiệp</h1>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto rounded-3xl shadow-md overflow-hidden">
            <table class="w-full table-fixed border-collapse text-center">
                <thead>
                    <tr class="bg-[#E7292B] text-white  text-sm">
                        <th class="w-[60px] py-3 px-4 border border-gray-200">STT</th>
                        <th class="py-3 px-4 border border-gray-200">Vị trí tuyển dụng</th>
                        <th class="py-3 px-4 border border-gray-200">Đăng tuyển</th>
                        <th class="py-3 px-4 border border-gray-200">Số lượng</th>
                        <th class="py-3 px-4 border border-gray-200">Nơi làm việc</th>
                        <th class="py-3 px-4 border border-gray-200">Hạn nộp hồ sơ</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                            $number = get_field('number');
                            $location = get_field('location');
                            $deadline = get_field('deadline'); // format: d/m/Y
                            // Safely convert deadline to Ymd
                            $deadline_obj = DateTime::createFromFormat('d/m/Y', $deadline);
                            $deadline_ymd = $deadline_obj ? $deadline_obj->format('Ymd') : null;

                            $status = ($deadline_ymd && $deadline_ymd >= $today) ? 'Ứng tuyển' : 'Hết hạn';
                            $status_class = ($status === 'Ứng tuyển') ? 'bg-[#E7292B] text-white' : 'bg-[#F5F5F5] text-black';
                    ?>
                            <tr class="hover:bg-gray-100 transition font-semibold">
                                <td class="py-3 px-4 border border-gray-200 text-xl">
                                    <?= str_pad($index, 2, '0', STR_PAD_LEFT); ?>
                                </td>
                                <td class="py-3 px-4 border border-gray-200"><?php the_title(); ?></td>
                                <td class="py-3 px-4 border border-gray-200">
                                    <?php if ($status === 'Ứng tuyển') : ?>
                                        <a href="<?php the_permalink(); ?>"
                                            class="inline-block bg-[#E7292B] text-white text-xs font-semibold px-4 py-2 rounded-full transition duration-300 hover:bg-[#c71f21] hover:scale-105">
                                            Ứng tuyển
                                        </a>
                                    <?php else : ?>
                                        <span class="inline-block bg-[#F5F5F5] text-black text-xs font-semibold px-4 py-2 rounded-full">
                                            Hết hạn
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 border border-gray-200"><?= esc_html($number); ?></td>
                                <td class="py-3 px-4 border border-gray-200"><?= esc_html($location); ?></td>
                                <td class="py-3 px-4 border border-gray-200"><?= esc_html($deadline); ?></td>
                            </tr>
                    <?php $index++;
                        endwhile;
                    endif;
                    wp_reset_postdata(); ?>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card Layout -->
        <div class="md:hidden space-y-4 mt-8">
            <?php
            $index = 1;
            $query->rewind_posts(); // Reuse existing query
            if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                    $number = get_field('number');
                    $location = get_field('location');
                    $deadline = get_field('deadline'); // format: d/m/Y
                    $deadline_obj = DateTime::createFromFormat('d/m/Y', $deadline);
                    $deadline_ymd = $deadline_obj ? $deadline_obj->format('Ymd') : null;

                    $status = ($deadline_ymd && $deadline_ymd >= $today) ? 'Ứng tuyển' : 'Hết hạn';
                    $is_active = ($status === 'Ứng tuyển');
                    $status_class = $is_active
                        ? 'bg-[#E7292B] text-white'
                        : 'bg-[#F5F5F5] text-black';
                    $title = get_the_title();
            ?>
                    <div class="border rounded-xl p-4 shadow-sm space-y-1">
                        <div><strong>STT:</strong> <?= str_pad($index, 2, '0', STR_PAD_LEFT); ?></div>
                        <div><strong>Vị trí:</strong> <?= esc_html($title); ?></div>
                        <div><strong>Đăng tuyển:</strong>
                            <?php if ($is_active) : ?>
                                <a href="<?php the_permalink(); ?>"
                                    class="inline-block <?= $status_class ?> text-xs font-semibold px-4 py-1 rounded-full transition duration-300 hover:bg-[#c71f21] hover:scale-105">
                                    Ứng tuyển
                                </a>
                            <?php else : ?>
                                <span class="inline-block <?= $status_class ?> text-xs font-semibold px-4 py-1 rounded-full">
                                    Hết Hạn
                                </span>
                            <?php endif; ?>
                        </div>
                        <div><strong>Số lượng:</strong> <?= esc_html($number); ?></div>
                        <div><strong>Nơi làm việc:</strong> <?= esc_html($location); ?></div>
                        <div><strong>Hạn nộp:</strong> <?= esc_html($deadline); ?></div>
                    </div>
            <?php
                    $index++;
                endwhile;
            endif;
            ?>
        </div>


    </div>
</section>

<?php get_footer(); ?>