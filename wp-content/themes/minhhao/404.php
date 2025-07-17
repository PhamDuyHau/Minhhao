<?php 
defined( 'ABSPATH' ) || exit;
get_header(); 
get_template_part('template-part/block/breadcrumbs');


?>

<section class="min-h-screen flex items-center justify-center bg-white text-center px-4">
  <div class="max-w-xl">
    <h2 class="text-2xl lg:text-3xl font-semibold text-gray-800 mb-4">Trang bạn tìm không tồn tại</h2>
    <p class="text-gray-600 mb-8">Có thể đường dẫn đã bị thay đổi hoặc không còn tồn tại nữa.</p>
    <a href="<?php echo esc_url(home_url('/')); ?>"
       class="inline-block bg-[#E7292B] hover:bg-[#b40303] text-white text-sm font-medium px-6 py-3 rounded transition">
      Quay lại trang chủ
    </a>
  </div>
</section>

<?php get_footer(); ?>
