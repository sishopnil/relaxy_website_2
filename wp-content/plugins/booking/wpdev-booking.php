<?php
/*
Plugin Name: Booking Calendar
Plugin URI: https://wpbookingcalendar.com/demo/
Description: Online reservation and availability checking service for your site.
Author: wpdevelop, oplugins
Author URI: https://wpbookingcalendar.com/
Text Domain: booking
Domain Path: /languages/
Version: 9.4.2
*/

/*  Copyright 2009 - 2022  www.wpbookingcalendar.com  (email: info@wpbookingcalendar.com),

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
    
if ( ! defined( 'ABSPATH' ) ) die( '<h3>Direct access to this file do not allow!</h3>' );       // Exit if accessed directly


if ( ! defined( 'WP_BK_VERSION_NUM' ) ) {       define( 'WP_BK_VERSION_NUM',    '9.4.2' ); }
if ( ! defined( 'WP_BK_MINOR_UPDATE' ) ) {      define( 'WP_BK_MINOR_UPDATE',   ! true ); }

if ( ! defined( 'WPBC_EXIST_NEW_BOOKING_LISTING' ) ) { define( 'WPBC_EXIST_NEW_BOOKING_LISTING', true  ); }             //FixIn: 9.2.1
if ( ! defined( 'WPBC_EXIST_NEW_AVAILABILITY' ) ) {    define( 'WPBC_EXIST_NEW_AVAILABILITY',    ! true ); }            //FixIn: 9.3.0.1

/*
if (
	   ( WP_DEBUG )
	&& (  version_compare( PHP_VERSION, '8.1', '>=' ) )                     // If   PHP >= 8.1
	&& (  version_compare( get_bloginfo( 'version' ), '6.1', '<' ) )        //      WordPress < 6.1
	&& (
		       (  ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) )
			|| (  ( isset( $_SERVER['SCRIPT_FILENAME'] ) ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'wpbookingcalendar.com' ) !== false ) )
			|| (  ( isset( $_SERVER['HTTP_HOST'] ) ) && ( strpos( $_SERVER['HTTP_HOST'], 'wpbookingcalendar.com' ) !== false )  )

	   )
) {
	// Remove it in WordPress 6.1, because there will be Update Requests library to version 2.0.0, which generate most of such messages: Deprecated: Return type of Requests_Cookie_Jar:
	$current_error_reporting = error_reporting();
	error_reporting( $current_error_reporting ^ ( E_DEPRECATED ) );

	add_filter( 'deprecated_constructor_trigger_error', '__return_false' );
	add_filter( 'deprecated_function_trigger_error', '__return_false' );
	add_filter( 'deprecated_file_trigger_error', '__return_false' );
	add_filter( 'deprecated_argument_trigger_error', '__return_false' );
	add_filter( 'deprecated_hook_trigger_error', '__return_false' );
}
*/

////////////////////////////////////////////////////////////////////////////////
// PRIMARY URL CONSTANTS                        
////////////////////////////////////////////////////////////////////////////////

// ..\home\siteurl\www\wp-content\plugins\plugin-name\wpdev-booking.php
if ( ! defined( 'WPBC_FILE' ) )             define( 'WPBC_FILE', __FILE__ ); 

// wpdev-booking.php
if ( ! defined('WPBC_PLUGIN_FILENAME' ) )   define('WPBC_PLUGIN_FILENAME', basename( __FILE__ ) );                     

// plugin-name    
if ( ! defined('WPBC_PLUGIN_DIRNAME' ) )    define('WPBC_PLUGIN_DIRNAME',  plugin_basename( dirname( __FILE__ ) )  );  

// ..\home\siteurl\www\wp-content\plugins\plugin-name
if ( ! defined('WPBC_PLUGIN_DIR' ) )        define('WPBC_PLUGIN_DIR', untrailingslashit( plugin_dir_path( WPBC_FILE ) )  );

// http: //website.com/wp-content/plugins/plugin-name
if ( ! defined('WPBC_PLUGIN_URL' ) )        define('WPBC_PLUGIN_URL', untrailingslashit( plugins_url( '', WPBC_FILE ) )  );     

if ( ! defined('WP_BK_MIN_WP_VERSION' ) )   define('WP_BK_MIN_WP_VERSION',  '4.0');    //Minimum required WP version        //FixIn: 7.0.1.6

require_once WPBC_PLUGIN_DIR . '/core/wpbc.php';