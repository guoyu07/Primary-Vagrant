<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'stable.wordpress.pv' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'password' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY', 'U,eJvxHM2YlpN/]i>{kB;hC:g;u$m>/>G)GI/O!AzSN(jE?-a},_$fvd*=gh|twO' );
define( 'SECURE_AUTH_KEY', 'I&!WNZ?r$T=;,_.?h|y*2Hek.W}&VW( uV O(5ea 2nov.&o*nLZGy+U=%k{Upbi' );
define( 'LOGGED_IN_KEY', 'tQq7(+L3<S&@3/0x+y2|KSptW7pObZS&2Y`=F{z- .6*%U-RDaySj5y+HB. (-u8' );
define( 'NONCE_KEY', ']N4xB#MI4/-Wx._rE9E{lsGk-}:>xCkqdc=|Oj-w^|@&FXyCYx6ErQh{dMBPgv7Y' );
define( 'AUTH_SALT', '.]LgNmm]@+FENhi3:.H$)V4*kwzLwae~u([<bAoFCqDp5AZ}=d16 5>QXwym-I-L' );
define( 'SECURE_AUTH_SALT', 'Kq1,_7S2}~F5$Sxh,bxIyeb?+-yS/XuzyjlZ@nNpFX3&dckwr4#7Y.}5v4PrjYS?' );
define( 'LOGGED_IN_SALT', 'HHq+Wvj;> +`1[1?_%IZ4|*}/[Pg~L7?{R|ek:JAH&?9aP0G@#tr z%|%_QpU%uv' );
define( 'NONCE_SALT', 'XhHpm-ZZMKXJ3w;!L1.~58~eS!2cL|O_r$Kw9B_1-g[]BF>d/-.++K07p+V;T8w~' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true );
define( 'WP_LOCAL_DEV', true );

define( 'WP_AUTO_UPDATE_CORE', false );

define( 'WP_CONTENT_DIR', '/var/www/default-sites/wordpress/content' );
define( 'WP_CONTENT_URL', 'http://stable.wordpress.pv/content' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
