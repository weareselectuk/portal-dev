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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'select_portal' );

/** MySQL database username */
define( 'DB_USER', 'select_portal' );

/** MySQL database password */
define( 'DB_PASSWORD', 'J%9iHTp3Z(Lc' );

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
define( 'AUTH_KEY',         'dll,2NJBxAiWqD]F>ssse/X/Z=U1iwf-#|7:C$xKX_BwscjhnV}n;y?;;#jw` 5{' );
define( 'SECURE_AUTH_KEY',  'OJNT};u.g5&^7-AyM8Ej=D2r8 89QS e&dvQ|-cPM}#pe2b_(_m}n7r<,^UB8rGp' );
define( 'LOGGED_IN_KEY',    ')=d64Zf?^:O.I.D1ip<=&rFSan$c[p_]U JcU7pO|+.mIn5b2*$Ucw2b<PmXEd&{' );
define( 'NONCE_KEY',        'S3W;4}VH?y=}/<aJ4pkyy^AdkgzfIs5WC5JU84|1p>+W2#AC[PX;F;F,6VP^_)*N' );
define( 'AUTH_SALT',        'AJ0;dxf@S>Ir{lXNmC ^a7aDK{s A2K`pu5Y*=/JZVI%i.ziN.WLJq?/+r/}B$LJ' );
define( 'SECURE_AUTH_SALT', '8>^YVJ0k<ODl;7iWvzTd`cs^{//$4m}ET|2xBeAk_z;p!ND#a-YEJe0kI8ou{KmT' );
define( 'LOGGED_IN_SALT',   'oqF]uT}xG2L4G(fn&|F{Xe|TTp7)d)&[%4P/OxeQ5*A.B,BnH9SB%(6OH@SoxXC,' );
define( 'NONCE_SALT',       'DynsxEFAPKs0=3gxb[*;u7iYPWVOUF1.9^g$g0$XqRQWQ*#GZX.Ar#+H[P6i~l-M' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
