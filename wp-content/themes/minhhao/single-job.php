<?php
defined( 'ABSPATH' ) || exit;


get_header();
$number = get_field('number');
$location = get_field('location');
$deadline = get_field('deadline');

$page_title = 'Tuyển dụng';
$breadcrumbs = [
  ['label' => 'Trang chủ', 'url' => home_url('/')],
  ['label' => 'Tuyển dụng', 'url' => home_url('/tuyen-dung')],
  ['label' => get_the_title(), 'url' => ''],
];

get_template_part('template-part/block/breadcrumbs', null, [
  'page_title' => $page_title,
  'breadcrumbs' => $breadcrumbs,
]);

?>

<section class="py-12">
  <div class="max-w-3xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-[#E7292B]"><?php the_title(); ?></h1>
    <div class="space-y-2 text-gray-800">
      <p><strong>Số lượng:</strong> <?= esc_html($number); ?></p>
      <p><strong>Nơi làm việc:</strong> <?= esc_html($location); ?></p>
      <p><strong>Hạn nộp hồ sơ:</strong> <?= esc_html($deadline); ?></p>
      <div class="pt-6">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
