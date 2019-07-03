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
define( 'DB_NAME', 'devselec_portalV2' );

/** MySQL database username */
define( 'DB_USER', 'devselec_dev' );

/** MySQL database password */
define( 'DB_PASSWORD', '@Jester01#a' );

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
define( 'AUTH_KEY',         '!dP?A_E69@deAw0Xs^roe`ey(HV5cjukWm.ii?X;`Dp0rR33UMmc;qnQBLLm.2Pe' );
define( 'SECURE_AUTH_KEY',  '4cMA2pd0q#v.G,iA]t*T;maz@m,zk^RO <Um&PxGPTh0/1|Iu1ISrRrs:d1$mRs4' );
define( 'LOGGED_IN_KEY',    '+D}kqAPYo#S4=G~;YZhh,aub0R!/V~vAt4QZqHNZQgfil,ko*Zb7)Tec=NJQ^4WX' );
define( 'NONCE_KEY',        '%EpRmq%b]6Q$Wi5zrYz#PgV+_0*v4yj<%_`eqQ@:uu0]cAX#t+=txT..9s(/xAqH' );
define( 'AUTH_SALT',        'Pg[|4%<j,@_ZSY{{_y,u[f[!}5L{pX`xrgSjEfR-CR ,N/7rjpXl-*b*n`WF&(]L' );
define( 'SECURE_AUTH_SALT', '):-*PS>8Q9<Lu91X25K4:>7sucqwKa]%Jpo-XK%B-Z+m2~7m`1Q(%VeGr_E!%Siw' );
define( 'LOGGED_IN_SALT',   '.|Fy;e4+r.3MSVWug<kF&7Cpso/s43}|XjJCg;Cf:VT~|a{S4R;?#v!1|2}ri46b' );
define( 'NONCE_SALT',       ',%LLmK}I%P!ez]DRyRAw_iyNh|Smfs Jmfp6k,oS*)wlgL7th+r3uwqM`MuL`S{!' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wasp_';

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
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
