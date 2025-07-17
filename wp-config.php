<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */


define( 'WP_ENVIRONMENT_TYPE', 'development' );

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'banhbao' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'VPLJeSD2a860TTywp8t8reIokEP6jwId9KCVTsLctCRbcelSpi3xVIKKYGNgM7v2' );
define( 'SECURE_AUTH_KEY',  'Ag7TwKlmcgVwQixMmmskbrlg3XinWZz0UckQnERF5NXzSQ88bxhsocLcRbX5gvNk' );
define( 'LOGGED_IN_KEY',    'kcsh1zBlpoWG7meUFQ8FngJGgG8oU5pgU7Dj3FxuF4BFNLxIMltNBKRItYZgO5ev' );
define( 'NONCE_KEY',        'h7R5TgUAVrjpZJkLGK6drlFfteCSCmhInVbS5kn3hsocegd3ZfxYhu5mynJbtZZs' );
define( 'AUTH_SALT',        'lkD0myAFE8gwXZm9uhhe6UXemjfH8tN6wGxvHJY5Uhf1kPoPXxd5BG3qDuWgTMiV' );
define( 'SECURE_AUTH_SALT', '9J8lx9B53TntVhIMvdBquvsHLhMS5doxzGB3ISnCLcqwGVN4vJiufqVi4e562te4' );
define( 'LOGGED_IN_SALT',   'm7BM1Evc3RizKCUhyMyiRrGXu3jARkfwLSYfjYWfoOTcRjmr0hdX9qk9lwn8STsF' );
define( 'NONCE_SALT',       'uDQKymNU1RJ5ckPNxbXzSEEQJvq9NibXmdisGrt8gEOZNPpZ1OrBO0MUt2jDyxDI' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);
define('WP_DEBUG_DISPLAY', true);
/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


