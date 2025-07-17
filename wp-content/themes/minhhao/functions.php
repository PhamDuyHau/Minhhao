<?php
defined('ABSPATH') || exit;

/**
 * Theme functions and definitions
 */

const THEME_VERSION = '1.0.0';
const THEME_TEXT_DOMAIN = 'minhhao';

define('THEME_PATH', untrailingslashit(get_template_directory()) . DIRECTORY_SEPARATOR);
define('THEME_URL', untrailingslashit(get_template_directory_uri()) . '/');
define('ASSETS_URL', THEME_URL . 'assets/');
define('INC_PATH', THEME_PATH . 'inc' . DIRECTORY_SEPARATOR);

// Setup & Core
require_once INC_PATH . 'setting.php';
require_once INC_PATH . 'init.php';

// Classes
require_once INC_PATH . 'classes/nav-menu.php';

// Enqueue styles & scripts
require_once INC_PATH . 'enqueue-assets.php';

// WooCommerce support
require_once INC_PATH . 'woocommerce.php';

// Custom Post Types
require_once INC_PATH . 'post-types/job.php';

// Ajax
require_once INC_PATH . 'ajax/product-filter.php';
require_once INC_PATH . 'ajax/mini-cart.php';

