<?php
defined('ABSPATH') || exit;

class Theme_Header
{
	public function __construct()
	{
		add_action('masthead', [$this, 'render_header_left'], 10);
		add_action('masthead', [$this, 'render_header_center'], 20);
		add_action('masthead', [$this, 'render_header_right'], 30);
		add_action('masthead', [$this, 'render_mobile_header'], 40);
		add_action('masthead', [$this, 'render_mobile_sidebar'], 50);

		// 👇 Add this line for your wrapper
		add_action('theme_header', [$this, 'render_header_wrapper']);
		add_action('header_inner', [$this, 'render_header_inner']);
		add_action('header_water_image', [$this, 'render_water_image']);
	}

	public function render_header_wrapper(): void
	{
?>
		<header class="bg-white relative">
			<?php do_action('header_inner'); ?>
		</header>
	<?php
	}

	public function render_header_inner(): void
	{
	?>
		<div class="max-w-screen mx-auto flex items-center justify-between h-20 lg:h-28 px-6 lg:px-12 relative">
			<?php do_action('masthead'); ?>
			<?php do_action('header_water_image'); ?>
		</div>
	<?php
	}

	public function render_water_image(): void
	{
	?>
		<div id="waterImage"
			class="absolute w-48 lg:w-96 h-auto top-[calc(100%-0.1rem)] left-1/2 -translate-x-1/2 z-10 transition-transform duration-500 ease-[cubic-bezier(0.68,0.95,0.41,1.31)]">
			<img src="data:image/svg+xml,%3csvg%20width='240'%20height='28'%20viewBox='0%200%20240%2028'%20fill='none'%20xmlns='http://www.w3.org/2000/svg'%3e%3cpath%20d='M0%200C72%200%2071.5%2027.5%20119.5%2027.5C167.5%2027.5%20168%200%20240%200H0Z'%20fill='%23FFFEFD'/%3e%3c/svg%3e"
				alt="Decorative Water" class="w-full h-full object-contain block" />
		</div>
	<?php
	}


	public function render_header_left(): void
	{
	?>
		<!-- Header Left Navigation + Cart Icon -->
		<div class="flex-1 hidden lg:flex items-center justify-start space-x-4">
			<?php
			wp_nav_menu([
				'theme_location' => 'main_menu_left',
				'container'      => false,
				'menu_class'     => 'flex space-x-4 uppercase font-semibold',
				'fallback_cb'    => false,
				'walker'         => new Walker_Nav_Menu_Custom(),
			]);
			?>

			<!-- Search Icon -->
			<form action="<?php echo home_url(); ?>" method="get" class="flex items-center">
				<input type="text" name="s" placeholder="Tìm kiếm..." class="hidden" />
				<button type="submit" class="bg-[#E7292B] w-9 h-9 flex items-center justify-center rounded-full text-white hover:bg-red-700 transition cursor-pointer">
					<i class="fa-solid fa-search"></i>
				</button>
			</form>

		</div>
		<?php
	}


	public function render_header_center(): void
	{
		$image_group = get_field('image_group', 'option');
		if (!$image_group) return;

		$logo       = $image_group['image_logo'] ?? '';
		$logo_link  = $image_group['link_logo'] ?? [];
		$logo_url   = $logo_link['url'] ?? '/';
		$logo_target = $logo_link['target'] ?? '_self';
		$logo_src   = wp_get_attachment_url($logo);
		$logo_alt   = get_post_meta($logo, '_wp_attachment_image_alt', true) ?: 'Logo';

		if ($logo_src):
		?>
			<a href="<?php echo esc_url($logo_url); ?>" target="<?php echo esc_attr($logo_target); ?>" class="hidden lg:block flex-shrink-0 z-10 items-center">
				<img src="<?php echo esc_url($logo_src); ?>" alt="<?php echo esc_attr($logo_alt); ?>" class="h-28 w-auto" />
			</a>
		<?php
		endif;
	}

	public function render_header_right(): void
	{
		?>
		<div class="flex-1 hidden lg:flex justify-end items-center space-x-4">
			<?php
			wp_nav_menu([
				'theme_location' => 'main_menu_right',
				'container'      => false,
				'menu_class'     => 'hidden xl:flex space-x-4 uppercase',
				'fallback_cb'    => false,
				'walker'         => new Walker_Nav_Menu_Custom(),
			]);
			?>

			<!-- Cart Button -->
			<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="relative mx-3">
				<!-- Main Button -->
				<button class="bg-[#E7292B] w-9 h-9 flex items-center justify-center rounded-full text-white hover:bg-red-700 transition cursor-pointer">
					<i class="fa-solid fa-cart-shopping"></i>
				</button>

				<!-- Count Badge -->
				<?php if (WC()->cart->get_cart_contents_count() > 0): ?>
					<span class="absolute -top-1.5 -right-1.5 bg-white text-[#E7292B] text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none shadow">
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</span>
				<?php endif; ?>
			</a>


			<!-- Phone Info -->
			<div class="flex items-center space-x-2">
				<i class="fa-solid fa-phone-volume text-3xl text-[#E7292B]"></i>
				<div class="flex flex-col leading-tight">
					<span class="text-black font-semibold text-sm">Tư vấn khách hàng</span>
					<span class="text-[#E7292B] font-semibold">(028) 3957 1457</span>
				</div>
			</div>
		</div>
	<?php
	}

	public function render_mobile_header(): void
	{
		$phone_group = get_field('phone_group', 'option');
		$main_title = $phone_group['main_title'] ?? '';
		$phone_number = $phone_group['phone_number'] ?? '';

	?>
		<!-- Mobile Topbar -->
		<div class="relative w-full h-28 px-4 lg:hidden flex items-center justify-between">

			<!-- Hamburger -->
			<button id="menuToggle" class="z-10 w-8 h-8 flex flex-col justify-between items-center p-1">
				<i class="fa-solid fa-bars text-[#E7292B]"></i>
			</button>

			<!-- Logo -->
			<a href="/" class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 z-0">
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/assets/nav-logo-Cf2wKFWa.png" alt="Logo" class="h-20 w-auto" />
			</a>

			<!-- Cart + Phone -->
			<div class="hidden sm:flex items-center space-x-3">
				<!-- Cart Button -->
					<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="relative mx-3">
						<!-- Main Button -->
						<button class="bg-[#E7292B] w-9 h-9 flex items-center justify-center rounded-full text-white hover:bg-red-700 transition cursor-pointer">
							<i class="fa-solid fa-cart-shopping"></i>
						</button>

						<!-- Count Badge -->
						<?php if (WC()->cart->get_cart_contents_count() > 0): ?>
							<span class="absolute -top-1.5 -right-1.5 bg-white text-[#E7292B] text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center leading-none shadow">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
							</span>
						<?php endif; ?>
					</a>
					<div class="flex items-center space-x-1">
						<i class="fa-solid fa-phone-volume text-xl text-[#E7292B]"></i>
						<div class="flex flex-col leading-none text-right text-xs">
							<span class="text-black font-semibold"><?php echo esc_html($main_title); ?></span>
							<span class="text-[#E7292B] font-semibold"><?php echo esc_html($phone_number); ?></span>
						</div>
					</div>
			</div>
		</div>
	<?php
	}

	public function render_mobile_sidebar(): void
	{
		$phone_group = get_field('phone_group', 'option');
		$main_title = $phone_group['main_title'] ?? '';
		$phone_number = $phone_group['phone_number'] ?? '';

	?>
		<!-- Black overlay -->
		<div id="overlaySlide"
			class="fixed top-0 left-0 w-0 h-full bg-black opacity-70 z-30 transition-all duration-500 ease-in-out pointer-events-none touch-none">
		</div>

		<!-- Mobile Menu Sidebar -->
		<div id="mobileMenu"
			class="lg:hidden fixed top-0 left-0 h-full w-64 shadow-lg transform -translate-x-full transition-transform duration-300 z-40 flex flex-col overflow-y-auto"
			style="background: radial-gradient(50% 50% at 50% 50%, #B40303 0%, #7A0202 100%);">

			<!-- Close -->
			<div class="flex justify-end p-4">
				<button id="mobileMenuClose" aria-label="Close Menu"
					class="text-3xl text-[#D6A528] hover:text-[#E7292B] transition duration-300 focus:outline-none">
					&times;
				</button>
			</div>

			<!-- Search -->
			<form action="<?php echo home_url(); ?>" method="GET" class="px-6 mb-4">
				<div class="flex items-center bg-white rounded-lg overflow-hidden w-full">
					<input name="s" type="text" placeholder="Tìm kiếm..." autocomplete="off"
						class="flex-grow px-3 py-2 text-sm text-[#7A0202] focus:outline-none min-w-0">
					<button type="submit" class="flex-shrink-0 px-4 py-2 bg-[#E7292B] text-white hover:bg-[#b40303]">
						<i class="fa-solid fa-search"></i>
					</button>
				</div>
			</form>


			<!-- Navigation -->
			<?php
			wp_nav_menu([
				'theme_location'  => 'mobile_menu',
				'container'       => false,
				'menu_class'      => 'flex flex-col space-y-5 px-6 pb-8 uppercase font-semibold text-white flex-1',
				'walker'          => new Walker_Mobile_Menu(),
				'fallback_cb'     => false,
			]);
			?>

			<!-- Phone -->
			<div class="px-6 py-4 border-t border-[#FFCD27]/30">
				<div class="flex items-center space-x-3">
					<i class="fa-solid fa-phone-volume text-2xl text-[#FFCD27]"></i>
					<div class="leading-tight">
						<span class="block text-xs text-white"><?php echo esc_html($main_title); ?></span>
						<span class="block font-semibold text-[#FFCD27]"><?php echo esc_html($phone_number); ?></span>
					</div>
				</div>
			</div>
		</div>
<?php
	}
}
