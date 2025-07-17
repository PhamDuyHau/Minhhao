<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8 bg-white shadow rounded-lg mt-12">

	<?php if ($order) :
		do_action('woocommerce_before_thankyou', $order->get_id());
	?>

		<?php if ($order->has_status('failed')) : ?>
			<p class="text-red-600 font-semibold text-lg mb-4">
				<?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?>
			</p>

			<p class="flex flex-wrap gap-4">
				<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
					<?php esc_html_e('Pay', 'woocommerce'); ?>
				</a>
				<?php if (is_user_logged_in()) : ?>
					<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
						<?php esc_html_e('My account', 'woocommerce'); ?>
					</a>
				<?php endif; ?>
			</p>

		<?php else : ?>

			<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

			<ul class="woocommerce-order-overview grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6 bg-gray-50 p-6 rounded-md order_details">

				<li class="woocommerce-order-overview__order">
					<span class="text-gray-500"><?php esc_html_e('Order number:', 'woocommerce'); ?></span>
					<strong class="block text-lg text-gray-900"><?php echo $order->get_order_number(); ?></strong>
				</li>

				<li class="woocommerce-order-overview__date">
					<span class="text-gray-500"><?php esc_html_e('Date:', 'woocommerce'); ?></span>
					<strong class="block text-lg text-gray-900"><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
				</li>

				<?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
					<li class="woocommerce-order-overview__email">
						<span class="text-gray-500"><?php esc_html_e('Email:', 'woocommerce'); ?></span>
						<strong class="block text-lg text-gray-900"><?php echo $order->get_billing_email(); ?></strong>
					</li>
				<?php endif; ?>

				<li class="woocommerce-order-overview__total">
					<span class="text-gray-500"><?php esc_html_e('Total:', 'woocommerce'); ?></span>
					<strong class="block text-lg text-red-600"><?php echo $order->get_formatted_order_total(); ?></strong>
				</li>

				<?php if ($order->get_payment_method_title()) : ?>
					<li class="woocommerce-order-overview__payment-method">
						<span class="text-gray-500"><?php esc_html_e('Payment method:', 'woocommerce'); ?></span>
						<strong class="block text-lg text-gray-900"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
					</li>
				<?php endif; ?>

			</ul>

		<?php endif; ?>

		<?php
		do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id());
		do_action('woocommerce_thankyou', $order->get_id());
		?>

	<?php else : ?>
		<?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>
	<?php endif; ?>

</div>