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
define('DB_NAME', 'GEN_pots_WEB_sitio');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '2<.UNQ T8*X(?N+<pxpDpBa-&<ZH+}I6OK+Y/b,1k l_h6;T0fp[$)->Z/z|ksjp');
define('SECURE_AUTH_KEY',  '<F.QoZ+}W-b{[jXnfl$zF(#LQVZwLLQ}/Jq|-bAZILy7<%5N-p$8j:PI/i^vm:i#');
define('LOGGED_IN_KEY',    '[IfUUTZTQ9.KfpE0j>yJ*5r/KoMU}c^hQJ)FQ2~gwC(T{%&mm}xM~U>]0=yAuk.J');
define('NONCE_KEY',        '2B+lNd)ly;uw,-C8?aM(I-|#8lY6jHmxPL*~(Zagaw~<c+ [!;+MFBbd`!qP[&O2');
define('AUTH_SALT',        '}JTXzUy CH7gCzr>+d1]7VZ?S3d2;% hk++)wvmO4eT$xk+`q>]-0Y-dnU:iVmf,');
define('SECURE_AUTH_SALT', 'lV]i4f$g$y3d=LIhAI#R%@|yL=<Ul3ETyd1>)9.JGuxEkJc=1w2wW(NjqG AXHr}');
define('LOGGED_IN_SALT',   '.|F=bzA5-?p@!NjQC!LM_c*SaJwB7,)~@I$&+~LSgvd&q/pe;%Bs}*|g;XsA]tu)');
define('NONCE_SALT',       '_-j<MRjnw[L5cwrkVSw80+.+<7=|7hhSh,.Do)S),%<Pl(O[12!)qU?3JB+}ATi,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'pots_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('WP_POST_REVISIONS', false);

define('UPLOADS', 'files' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
