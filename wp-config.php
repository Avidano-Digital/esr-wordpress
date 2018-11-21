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
define('DB_NAME', 'endangered_species_revenge_2019');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'nJ%my-WQAON;P)[bTp?xGH6 >4+*DPH=VCQ/sQgEz[LoK-ME{5:)g7aaxAQ/c:{2');
define('SECURE_AUTH_KEY',  '2G}3olcEjQ7lrc!U5OV<f=9rGZ:XdYg<x~%_OCg>0-*dOt2*o]{#5cW&(XZFlCc9');
define('LOGGED_IN_KEY',    'Y3yDc3enu$ToE&_|;;b{y^yTLQ6w^5BPLoEsHK8v4b+_t~<p-f :eNasSq]hhY&y');
define('NONCE_KEY',        '&ajk2H [EfD#s[5Ypb#-[}9)p4_,)_4TLqOH%n96F,Y/qz<0FpL4uTAcuyyr5yY5');
define('AUTH_SALT',        'L$hX<x}IuJVng3#I Km14@2&*S:%~ZS}h.NfsqTOI2WZn.yo(vUB^P 9!f,pi[Xs');
define('SECURE_AUTH_SALT', 'Pd]H&42vdkHP323V-|EbeBLXO %-Vj9njI`UB;3>Jl}/PV~EON8h]ylA(>i{1DSB');
define('LOGGED_IN_SALT',   'gU>T-d:=SVS`2D.!CYwNe,q`.9Qq}le1ow^bwqc!T>=_ChM>3/uweN7b&+D<C}1_');
define('NONCE_SALT',       'DqRV6j|#R;DnZnoZzBd)(`vI@ulV)[H&xP=S;W2We`~TDWd1%$rmoRlz9urKVv(y');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'esr_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
