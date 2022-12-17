<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'relaxy_database' );

/** Database username */
define( 'DB_USER', 'relaxydb' );

/** Database password */
define( 'DB_PASSWORD', 'relaxy@jahnjoyshopnil' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         'lurM$ Yc4:eBl6=A-lt,4|F.H;%~CJjr0-OOh9gLxvL^;a]Fy*gbgH06tQ>Shp4f' );
define( 'SECURE_AUTH_KEY',  'RK*}lU@`jIHtT<-s#mEY:o~2ST4@jYb_S%&y,_16ia L_zL9Hth]1SSX.{lDo@/U' );
define( 'LOGGED_IN_KEY',    '2N%D_V#yIH6$LjcE$d=LIIP8k%<}--fcn3qR8ddo:C;$,m5c2v4|>GBO<6lvD$7R' );
define( 'NONCE_KEY',        '+n1--BCKkQT.*T3Sd5.v]Uvk<(d)`|PZfZNv`kABwl;*6ss>2(5}AOxdK:WJ&tf7' );
define( 'AUTH_SALT',        '>KMLei`aedO5s0AaC//Zm;A5M*?yWosEJR9N}EcmvvzO$9TAx#3c1,8{B6?DdiVM' );
define( 'SECURE_AUTH_SALT', 'O#3km$6DXq^H)?Dx?)d./-2!%+(B=YLpp5Uy=onM]U36NTuH`Ic)?-rdDIHZ677y' );
define( 'LOGGED_IN_SALT',   '57aM$U|_~y9WSY>h~l1wP_7vaj b9kh I^AiR?p@7}uy}b+GB<<a*E&9)29`W~[f' );
define( 'NONCE_SALT',       '!_ms1!=3w2putr3D9T6@y$BA/X,HP//}b>mk~!K]yJIyf0@eEF<ldf<?[SkZ&?}+' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_relaxy_';

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
define( 'FS_METHOD', 'direct' );
define( 'AS3CF_SETTINGS', serialize( array(
	'provider' => 'aws',
	'access-key-id' => 'AKIA35K2I3WFDRBGKTEN',
	'secret-access-key' => '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',
) ) );



/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
