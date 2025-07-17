<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action(hook_name: 'woocommerce_before_single_product');

// custom Hero 
$hero_img_left_id = get_field('hero_img_left', 'option');
$hero_img_right_id = get_field('hero_img_right', 'option');
$hero_img_left_url = wp_get_attachment_image_url($hero_img_left_id, 'full');
$hero_img_right_url = wp_get_attachment_image_url($hero_img_right_id, 'full');
$link_hotline   = get_field('link_hotline', 'option');
$link_sign_up   = get_field('link_sign_up', 'option');
$desc_title     = get_field('title_description', 'option') ?: '';
$rel_title      = get_field('title_relative', 'option') ?: '';
$related_level  = get_field('related_category_level', 'option') ?: 'sub';
$related_limit  = (int) get_field('related_product_limit', 'option') ?: 1;
?>

<?php
// Only proceed if this is a product and the fields are set
if (is_product()) :
	// Get terms
	$terms = get_the_terms(get_the_ID(), 'product_cat');
	$cat_ids = [];

	if ($terms && !is_wp_error($terms)) {
		foreach ($terms as $term) {
			if ($related_level === 'main') {
				// Only add the parent ID
				if ($term->parent && $term->parent != 0) {
					$cat_ids[] = $term->parent;
				} else {
					$cat_ids[] = $term->term_id;
				}
			} else {
				// Only add the subcategory if it's a child
				if ($term->parent && $term->parent != 0) {
					$cat_ids[] = $term->term_id;
				}
			}
		}
		$cat_ids = array_unique($cat_ids);
	}

	$related = new WP_Query([
		'post_type'      => 'product',
		'posts_per_page' => $related_limit,
		'post__not_in'   => [get_the_ID()],
		'tax_query'      => [[
			'taxonomy' => 'product_cat',
			'field'    => 'term_id',
			'terms'    => $cat_ids,
		]]
	]);

	if ($related->have_posts()) :
?>
		<!-- Hero -->
		<section class="relative flex items-center justify-between h-[100vh] overflow-hidden"
			style="background: var(--main-bg);">
			<!-- Left Image -->
			<?php if ($hero_img_left_url): ?>
				<div class="max-w-[50%] w-full hidden md:block">
					<img src="<?= esc_url($hero_img_left_url); ?>" alt="Left Dumpling"
						class="w-[50%] h-auto object-contain mt-10" />
				</div>
			<?php endif; ?>

			<!-- Right Image -->
			<?php if ($hero_img_right_url): ?>
				<div class="max-w-[50%] w-full hidden md:block">
					<img src="<?= esc_url($hero_img_right_url); ?>" alt="Right Dumpling"
						class="w-[30%] h-auto object-contain float-right" />
				</div>
			<?php endif; ?>

			<!-- Background wave at the bottom -->
			<img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20fill='none'%20viewBox='0%200%201727%20144.552'%20style='max-height:%20500px'%20width='1727'%20height='144.552'%3e%3cpath%20fill='%23FF9C3D'%20d='M1241.72%2072.629C1100.69%2091.6666%20969.11%20108.944%20863%20108.944C756.89%20108.944%20625.31%2091.6666%20484.28%2072.629C292.94%2046.8787%20113.66%2020.2481%20-1%200V163.966H863H1727V0C1612.34%2020.2481%201433.06%2046.8787%201241.72%2072.629Z'/%3e%3cpath%20fill='%23F3F3F3'%20d='M1252.25%2078.1624C1100.69%2096.7046%20965.87%20113.289%20863%20113.289C760.13%20113.289%20625.31%2096.7046%20473.75%2078.1624C216.26%2046.7213%2061.01%2050.7522%20-1%2085.6483L-1%201902H1727V85.6483C1664.99%2050.7522%201509.74%2046.7213%201252.25%2078.1624Z'/%3e%3c/svg%3e" alt="Hero Background Wave"
				class="absolute bottom-0 left-0 w-full pointer-events-none z-0" />
		</section>

		<?php
		// ✅ Continue Woo logic
		if (post_password_required()) {
			echo get_the_password_form();
			return;
		}
		?>
		<div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>

			<?php
			/**
			 * Hook: woocommerce_before_single_product_summary.
			 *
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action('woocommerce_before_single_product_summary');
			?>

			<section class="relative py-12" style="height: clamp(0px, 30vw, 250px);">
				<div class="max-w-7xl mx-auto px-4 relative">
					<div
						class="swiper dumpling-detail-main-swiper animate-bounce-skew border-[6px] border-[#FFAE19] rounded-3xl bg-[#7A0202] w-full max-w-[600px] aspect-square transform -translate-y-[430px] z-10">
						<div class="swiper-wrapper">
							<?php
							// Main image
							$featured_id = $product->get_image_id();
							if ($featured_id):
								$featured_url = wp_get_attachment_image_url($featured_id, 'full');
							?>
								<div class="swiper-slide flex items-center justify-center bg-gray-100 overflow-visible rounded-lg">
									<img src="<?= esc_url($featured_url); ?>" alt="<?= esc_attr(get_the_title()); ?>"
										class="object-cover w-full h-full" />
								</div>
							<?php endif; ?>

							<?php
							// Gallery images
							foreach ($product->get_gallery_image_ids() as $gallery_id):
								$gallery_url = wp_get_attachment_image_url($gallery_id, 'full');
							?>
								<div class="swiper-slide flex items-center justify-center bg-gray-100 overflow-hidden rounded-lg">
									<img src="<?= esc_url($gallery_url); ?>" alt="<?= esc_attr(get_the_title()); ?>"
										class="object-cover w-full h-full" />
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Navigation + Pagination -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
						<div class="swiper-pagination"></div>
					</div>
				</div>
			</section>

			<div class="summary entry-summary">
				<?php
				/**
				 * Hook: woocommerce_single_product_summary.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action('woocommerce_single_product_summary');
				?>
			</div>

			<!-- Name (Bánh Bao Xá Xíu) -->
			<section class="max-w-4xl mx-auto px-4 py-6">
				<div class="text-center">
					<?php
					global $product;
					$product_name = get_the_title();
					$is_in_stock = $product->is_in_stock();
					?>

					<h1 class="text-2xl sm:text-3xl uppercase text-[#E7292B] font-bold mb-6 fade-up">
						<?= esc_html($product_name); ?>
					</h1>

					<!-- Short Description -->
					<?php if ($product->get_short_description()) : ?>
						<div class="text-black leading-relaxed mb-4 fade-up delay-2s">
							<?= wpautop($product->get_short_description()); ?>
						</div>
					<?php endif; ?>

					<!-- Price + Quantity + Add to Cart Layout -->
					<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-6 fade-up delay-2s">

						<!-- Price -->
						<div class="text-2xl font-bold text-[#B40303]">
							<span id="product-total-price"><?= $product->get_price_html(); ?></span>
							<span class="hidden" data-unit-price="<?= esc_attr($product->get_price()); ?>"></span>
						</div>

						<!-- Quantity Selector -->
						<div class="flex items-center border border-gray-300 rounded-md overflow-hidden">
							<button type="button"
								class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-xl font-bold text-gray-700 minus-btn">
								−
							</button>
							<input type="number"
								min="1"
								value="1"
								class="w-14 text-center border-l border-r border-gray-300 quantity-input" />
							<button type="button"
								class="w-10 h-10 flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-xl font-bold text-gray-700 plus-btn">
								+
							</button>
						</div>
					</div>

					<!-- Stock + Brand Info -->
					<p class="mb-4 text-lg text-black font-semibold fade-up delay-2s">
						Tình trạng:
						<span class="font-bold <?= $is_in_stock ? 'text-green-600' : 'text-red-600'; ?>">
							<?= $is_in_stock ? 'Còn hàng' : 'Hết hàng'; ?>
						</span>

						<?php
						// Get brand (assuming taxonomy is 'product_brand')
						$brands = get_the_terms(get_the_ID(), 'product_brand');
						if (!is_wp_error($brands) && !empty($brands)) :
							$brand_names = wp_list_pluck($brands, 'name');
						?>
							<span class="mx-4 text-gray-400">|</span>
							<span>
								Nhà máy sản xuất:
								<span class="font-bold text-[#7A0202]"><?= esc_html(implode(', ', $brand_names)); ?></span>
							</span>
						<?php endif; ?>
					</p>

				</div>

				<!-- Buttons with icons -->
				<div class="flex flex-col sm:flex-row justify-center gap-4 fade-up delay-6s">
					<!-- Hotline Button -->
					<?php if ($link_hotline): ?>
						<a href="<?= esc_url($link_hotline['url']); ?>"
							target="<?= esc_attr($link_hotline['target'] ?: '_self'); ?>"
							class="inline-flex flex-row items-center gap-3 font-semibold pl-1 pr-6 py-1 rounded-full text-white cursor-pointer uppercase btn-hover-unique btn-gradient-animated transition-transform duration-300 transform hover:scale-105"
							style="background: linear-gradient(360deg, #064DA1 -56.52%, #0059C3 59.78%)">
							<span class="w-10 h-10 rounded-full bg-[#FF0006] flex items-center justify-center border-2 border-white">
								<img src="data:image/svg+xml,%3csvg%20width='27'%20height='27'%20viewBox='0%200%2027%2027'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M20.1446%2026.6411C18.8941%2026.6411%2017.9562%2026.3285%2017.0184%2026.0158C14.2048%2025.078%2011.7038%2023.5149%209.51541%2021.6391C6.38918%2019.1381%203.8882%2016.0119%202.01246%2012.573C1.07459%2011.0099%200.449342%209.13419%200.136719%207.57107C0.136719%206.94582%200.136719%206.32058%200.449342%206.00795C1.69983%204.44484%202.95033%202.5691%204.51344%201.31861C4.51344%201.00598%204.82607%201.00598%205.13869%200.693359C5.45131%200.693359%205.76394%200.693359%205.76394%201.00598C6.07656%201.00598%206.38918%201.31861%206.38918%201.31861C7.63968%202.88172%208.57755%204.75746%209.51541%206.6332C10.1407%207.57107%209.82804%207.88369%209.20279%208.50894C8.57755%209.13419%207.9523%209.44681%207.63968%2010.0721C7.32705%2010.0721%207.32705%2010.3847%207.32705%2010.6973C8.26492%2013.1983%209.51541%2015.074%2011.7038%2016.9498C13.2669%2018.2003%2014.83%2019.1381%2016.3931%2019.4508C16.7057%2019.4508%2016.7057%2019.4508%2016.7057%2019.4508C17.0184%2018.8255%2017.6436%2018.5129%2017.9562%2017.8876C18.8941%2016.9498%2019.2067%2016.9498%2020.1446%2017.2624C22.0203%2018.2003%2023.5835%2019.1381%2025.1466%2020.3886C25.4592%2020.3886%2025.4592%2020.7012%2025.7718%2021.0139C26.0844%2021.3265%2026.0844%2021.6391%2025.7718%2021.9517C25.7718%2022.2644%2025.1466%2022.577%2024.834%2023.2022C23.5835%2024.4527%2022.333%2025.3906%2021.0825%2026.3285C20.7698%2026.3285%2020.4572%2026.6411%2020.1446%2026.6411Z'%20fill='white'/%3e%3cpath%20d='M26.0839%2012.8857C25.4587%2012.8857%2024.8334%2012.8857%2024.2082%2012.8857C24.2082%2010.0721%2023.2703%207.57107%2021.0819%205.69533C19.2062%203.81959%2016.7052%202.88172%2013.8916%202.5691C13.8916%201.94385%2013.8916%201.31861%2013.8916%200.693359C20.4567%200.693359%2026.0839%206.00795%2026.0839%2012.8857Z'%20fill='white'/%3e%3cpath%20d='M21.3944%2012.8858C20.7692%2012.8858%2020.1439%2012.8858%2019.5187%2012.8858C19.5187%2011.3227%2018.8934%2010.0722%2017.9556%208.82168C17.0177%207.88381%2015.4546%207.25856%2014.2041%207.25856C14.2041%206.63332%2014.2041%206.00807%2014.2041%205.38282C17.3303%205.0702%2021.3944%208.19643%2021.3944%2012.8858Z'%20fill='white'/%3e%3c/svg%3e" alt="Detail Icon">
							</span>
							<?= esc_html($link_hotline['title']); ?>
						</a>
					<?php endif; ?>

					<!-- Đăng ký tư vấn -->
					<?php if ($link_sign_up): ?>
						<a href="<?= esc_url($link_sign_up['url']); ?>"
							target="<?= esc_attr($link_sign_up['target'] ?: '_self'); ?>"
							class="inline-flex flex-row items-center gap-3 font-semibold pl-1 pr-6 py-1 rounded-full text-white cursor-pointer transition hover:opacity-90 bg-[#FF0006] uppercase btn-hover-unique btn-gradient-animated transition-transform duration-300 transform hover:scale-105">
							<span class="w-10 h-10 rounded-full bg-[#FF0006] flex items-center justify-center border-2 border-white">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/dumpling-detail-avatar-icon-BtWVhJ5X.svg" alt="Avatar Icon">
							</span>
							<?= esc_html($link_sign_up['title']); ?>
						</a>
					<?php endif; ?>

					<!-- Thêm vào giỏ hàng -->
					<?php if ($product->is_purchasable() && $product->is_in_stock()) : ?>
						<form class="cart" method="post" enctype="multipart/form-data" action="<?php echo esc_url(add_query_arg([], get_permalink())); ?>">

							<?php do_action('woocommerce_before_add_to_cart_button'); ?>

							<input type="hidden" name="add-to-cart" value="<?= esc_attr($product->get_id()); ?>" />
							<input type="hidden" name="quantity" id="form-quantity" value="1" />

							<button type="submit"
								class="inline-flex flex-row items-center gap-3 font-semibold pl-1 pr-6 py-1 rounded-full text-white cursor-pointer uppercase btn-hover-unique btn-gradient-animated transition-transform duration-300 transform hover:scale-105"
								style="background: linear-gradient(360deg, #B40303 -56.52%, #FF0006 59.78%)">
								<span class="w-10 h-10 rounded-full bg-[#FF0006] flex items-center justify-center border-2 border-white">
									<i class="fas fa-shopping-cart text-white text-lg"></i>
								</span>
								Thêm vào giỏ
							</button>


							<?php do_action('woocommerce_after_add_to_cart_button'); ?>
						</form>
					<?php else : ?>
						<p class="text-red-600 font-bold">⚠️ This product is not purchasable or out of stock.</p>
					<?php endif; ?>
				</div>
			</section>

			<!-- Long Describe (Mô tả sản phẩm) -->
			<section class="max-w-7xl mx-auto px-4 py-6">
				<div class="bg-white rounded-xl p-6 my-6 shadow-md mx-auto animate-boxOpen">
					<h2 class="text-2xl font-bold mb-6 text-center"><?= esc_html($desc_title); ?></h2>
					<div class="text-gray-700 leading-relaxed">
						<?= apply_filters('the_content', $post->post_content); ?>
					</div>
				</div>
			</section>

			<?php
			do_action('woocommerce_after_single_product_summary');
			?>

			<!-- Related Products -->
			<section class="max-w-7xl mx-auto py-6">
				<div class="px-2 md:px-3 lg:px-4">
					<div class="flex flex-col md:flex-row gap-8 items-center text-center md:text-left">
						<div class="flex-1 text-left uppercase">
							<h2 class="text-[#E7292B] font-bold text-2xl sm:text-3xl md:text-4xl mt-1 fade-left">
								<?= esc_html($rel_title); ?>
							</h2>
						</div>
					</div>

					<div class="dumpling-detail-sub-swiper swiper mt-16 w-full relative overflow-visible fade-up delay-4s">
						<div class="swiper-wrapper pb-12">
							<?php while ($related->have_posts()) : $related->the_post();
								global $product;
								$external_url = '';
								if ($product && $product->is_type('external')) {
									$external_url = $product->get_product_url();
								}
							?>
								<div class="swiper-slide max-w-[90vw]">
									<div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300 flex flex-col h-full min-h-[500px]">

										<!-- Product Image -->
										<a href="<?= esc_url(get_post_permalink($product->get_id())); ?>" class="block relative">
											<?= get_the_post_thumbnail($product->get_id(), 'medium', [
												'class' => 'w-full h-64 object-cover transition-transform duration-500 ease-in-out hover:scale-105'
											]); ?>
											<?php if ($product->is_on_sale()) : ?>
												<span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow">Giảm giá</span>
											<?php endif; ?>
										</a>

										<!-- Card Body -->
										<div class="p-4 flex flex-col flex-grow justify-between text-left">

											<!-- Title -->
											<h3 class="font-semibold text-base text-gray-800 leading-snug mb-1 line-clamp-2">
												<a href="<?= esc_url(get_post_permalink($product->get_id())); ?>" class="hover:text-[#B40303] transition">
													<?= get_the_title(); ?>
												</a>
											</h3>

											<!-- Description -->
											<?php if ($desc = get_the_excerpt()) : ?>
												<p class="text-sm text-gray-600 line-clamp-2 flex-grow"><?= truncate_chars($desc, 50); ?></p>
											<?php else: ?>
												<div class="flex-grow"></div> <!-- reserve stretchable space if no desc -->
											<?php endif; ?>

											<!-- Price + Action -->
											<div class="pt-4 mt-4 border-t border-gray-200 flex items-center justify-between">
												<div class="text-base font-bold text-[#B40303]">
													<?= $product->get_price_html(); ?>
												</div>

												<!-- Button -->
												<?php if ($product->is_type('external') && $external_url) : ?>
													<a href="<?= esc_url($external_url); ?>" target="_blank"
														class="w-10 h-10 flex items-center justify-center rounded-full border border-red-200 bg-[#FFF4EC] hover:bg-red-100 hover:scale-105 hover:shadow transition duration-300"
														title="Mua trên Shopee">
														<img src="<?= get_stylesheet_directory_uri(); ?>/dist/assets/dumpling-detail-shopee-sub-icon-ZTO8N0g-.svg"
															alt="Shopee Icon"
															class="w-6 h-6 object-contain" />
													</a>
												<?php else : ?>
													<a href="<?= esc_url(get_post_permalink($product->get_id())); ?>"
														class="w-10 h-10 flex items-center justify-center rounded-full border border-red-200 bg-[#FFF4EC] text-[#B40303] hover:bg-red-100 hover:scale-105 hover:shadow transition duration-300"
														title="Xem chi tiết sản phẩm">
														<i class="fa-solid fa-cart-plus text-base"></i>
													</a>
												<?php endif; ?>
											</div>
										</div>

									</div>
								</div>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>

						<!-- Swiper Controls -->
						<div class="swiper-pagination"></div>
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				</div>
			</section>


	<?php endif;
endif; ?>
		</div>

		<?php do_action('woocommerce_after_single_product'); ?>