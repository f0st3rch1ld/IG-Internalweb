<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'internalweb' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Ditch1234!' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'KNZu?]6:TyZ_,?0VpZyiRDvJ:acsn,45&}L7NIVkohW#NL[;b[:cR]5aS)K9OzDG' );
define( 'SECURE_AUTH_KEY',  'rk-t6OXf_RGPT*>nwST#SG]>iAw&APGuD??6J7z,}gwNM+R8V>L`E75^fc]FUJ%V' );
define( 'LOGGED_IN_KEY',    'tzNqc[fGllL>f^9?WEz2r?.s!/&nsvG|cP^1A]c@7H.CtqE9T;92jK%8m{o|x2:L' );
define( 'NONCE_KEY',        'BWEhFV>p:kjzplCr=oU43l,j`OhU}2^~ qz~;]@rI%1.p%)dg;o@?NS}T~awEI>.' );
define( 'AUTH_SALT',        ';;1obfDXS|vdAGgeQ:O1 %)h~m3@tuLg8:4)Z+S$q~IzZ<8EX5gg@OxvTNNXGd^M' );
define( 'SECURE_AUTH_SALT', 'ehvzuvn|lp)F$)run`7udW,hWEX^[{jCFi.QQuYOQ<`0GN;m;n;;zC3U7[f1GNHo' );
define( 'LOGGED_IN_SALT',   'zB2i).fLj7[r]#s= iK0fcM23LuZ{HqHR_8&w65,/C:YF)iVRu76-AfD7L{o6_G6' );
define( 'NONCE_SALT',       '*k#j;4Rw#TIjeOOrcmTd?^3~[IzIO(#u-E![S9XK(4j| C$/t!qjeb4a8m)k&)<.' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */

define( 'WP_DEBUG', false );
// define( 'WP_DEBUG_LOG', true );
// define( 'WP_DEBUG_DISPLAY', false );
// @ini_set( 'display_errors', 0 );
// define( 'SCRIPT_DEBUG', true );

define( 'WP_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
