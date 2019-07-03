<?php
define('WP_CACHE', false);
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
define('DB_NAME', 'devselec_portalV2');

/** MySQL database username */
define('DB_USER', 'devselec_dev');

/** MySQL database password */
define('DB_PASSWORD', '@Jester01#a');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '):BbsKK9,)%MOp<d&5/HQI?y1k[dk{FjaU^q6$MvazuF:R3lpBaEFJmHG(^*D?zu');
define('SECURE_AUTH_KEY',  'bI~MNcx9+-qCpNKm!=;avs7sa~}tKHswrEv90*xsZoI5.8`}nB-k(D&2^A_B6L])');
define('LOGGED_IN_KEY',    'E^CV(A uqgL0QS]c1K[- Tj,%g>RyeHPm`MXRi3I0Z.eVQdq]ZCy{4:_UeqoKD>i');
define('NONCE_KEY',        'XqCm[F.oNLC?: ;9|Ay$,,2>A&qFwmd}.6;7tnH=QG|ZXQ<_#nqa28JaGbLUU&E4');
define('AUTH_SALT',        'U8>D33<s9?_&.kl/Ex<yMy,HzcCK3y%^e`(=G}a?:/DFoXrNMs7I;cE%B3UaV`ge');
define('SECURE_AUTH_SALT', 'gO&P&@ecwcLNqa.LWe,*c2aVzT6P`XZGlnTYWk,-O(~/L(:I0!jHUyR(KHo/9EkS');
define('LOGGED_IN_SALT',   '{31PfND+H2*@g^Jl8oca}Fb{;tqen;;1Vp@GQ.qJ]9aab55;rr1E.v)_!nhp[NT>');
define('NONCE_SALT',       '{HT{];o|UpCz._ArVqIeVOr;]xGiGx?41%N+2mJ:b_*?*BD2!<->xz[j!Jsk+AC:');
define('AUTOSAVE_INTERVAL', 300); // seconds
define('WP_POST_REVISIONS', false);
define('WP_ALLOW_MULTISITE', false);
define( 'WP_MAX_MEMORY_LIMIT', '256M' );
/* Multisite */
define('WP_ALLOW_MULTISITE', false );



/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wasp_';

define( 'DISALLOW_FILE_EDIT', true );
define( 'AUTOMATIC_UPDATER_DISABLED', true );

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
define('WP_DEBUG', false);
define( 'SUNRISE', 'on' );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
