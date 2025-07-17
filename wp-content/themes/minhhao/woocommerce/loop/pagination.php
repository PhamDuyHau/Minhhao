<?php

/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

if (! defined('ABSPATH')) {
	exit;
}

$total   = isset($total) ? $total : wc_get_loop_prop('total_pages');
$current = isset($current) ? $current : wc_get_loop_prop('current_page');
$base    = isset($base) ? $base : esc_url_raw(str_replace(999999999, '%#%', remove_query_arg('add-to-cart', get_pagenum_link(999999999, false))));
$format  = isset($format) ? $format : '';

if ($total <= 1) {
	return;
}
?>
<?php
defined('ABSPATH') || exit;

global $wp_query;

$total   = $wp_query->max_num_pages;
$current = max(1, get_query_var('paged'));
$base    = str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999)));

if ($total <= 1) {
	return;
}
?>

<!-- Custom Tailwind-style Pagination Controls -->
<div class="flex justify-center items-center mt-8 space-x-2">

	<!-- Prev Button -->
	<?php if ($current > 1) : ?>
		<a href="<?php echo esc_url(get_pagenum_link($current - 1)); ?>"
			class="px-4 py-2 bg-gray-200 text-gray-600 rounded hover:bg-gray-300">
			<i class="fa-solid fa-angle-left"></i>
		</a>
	<?php else : ?>
		<span class="px-4 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed opacity-50">
			<i class="fa-solid fa-angle-left"></i>
		</span>
	<?php endif; ?>

	<!-- Number Buttons -->
	<div class="flex space-x-1">
		<?php
		$links = paginate_links([
			'base'      => $base,
			'format'    => '',
			'current'   => $current,
			'total'     => $total,
			'type'      => 'array',
			'prev_next' => false,
		]);

		if ($links) {
			foreach ($links as $link) {
				// If it's the current page, wrap with <span>
				if (strpos($link, 'current') !== false) {
					echo str_replace(
						'page-numbers current',
						'px-3 py-2 bg-red-600 text-white rounded font-semibold',
						$link
					);
				} else {
					echo str_replace(
						'page-numbers',
						'px-3 py-2 bg-gray-200 text-gray-600 rounded hover:bg-gray-300 transition',
						$link
					);
				}
			}
		}
		?>
	</div>

	<!-- Next Button -->
	<?php if ($current < $total) : ?>
		<a href="<?php echo esc_url(get_pagenum_link($current + 1)); ?>"
			class="px-4 py-2 bg-gray-200 text-gray-600 rounded hover:bg-gray-300">
			<i class="fa-solid fa-angle-right"></i>
		</a>
	<?php else : ?>
		<span class="px-4 py-2 bg-gray-100 text-gray-400 rounded cursor-not-allowed opacity-50">
			<i class="fa-solid fa-angle-right"></i>
		</span>
	<?php endif; ?>

</div>