<?php
defined('ABSPATH') || exit;

// Header class
require_once get_template_directory() . '/inc/structures/header.php';
new Theme_Header();

// Footer class
require_once get_template_directory() . '/inc/structures/footer.php';
new Theme_Footer();