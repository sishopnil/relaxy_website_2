<?php /**
 * @version 1.0
 * @description WPBC_AJX__Availability
 * @category  WPBC_AJX__Availability Class
 * @author wpdevelop
 *
 * @web-site http://oplugins.com/
 * @email info@oplugins.com
 *
 * @modified 2022-10-24
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


class WPBC_AJX__Availability {

	// <editor-fold     defaultstate="collapsed"                        desc=" ///  JS | CSS files | Tpl loading  /// "  >

		/**
		 * Define HOOKs for loading CSS and  JavaScript files
		 */
		public function init_load_css_js_tpl() {

			// Load only  at  specific  Page
			if  ( strpos( $_SERVER['REQUEST_URI'], 'page=wpbc-availability' ) !== false ) {

				add_action( 'wpbc_enqueue_js_files', array( $this, 'js_load_files' ), 50 );
				add_action( 'wpbc_enqueue_css_files', array( $this, 'enqueue_css_files' ), 50 );

				//add_action( 'wpbc_hook_settings_page_footer', array( $this, 'hook__page_footer_tmpl' ) );
			}
		}


		/** JS */
		public function js_load_files( $where_to_load ) {

			$in_footer = true;

			if ( ( is_admin() ) && ( in_array( $where_to_load, array( 'admin', 'both' ) ) ) ) {

				wp_enqueue_script(    'wpbc-ajx_availability_calendar'
									, trailingslashit( plugins_url( '', __FILE__ ) ) . '_out/availability_calendar.js'         /* wpbc_plugin_url( '/_out/js/codemirror.js' ) */
									, array( 'wpbc-global-vars' ), '1.0', $in_footer );
				/**
				 *
				 * wp_localize_script( 'wpbc-global-vars', 'wpbc_live_request_obj'
				 * , array(
				 * 'ajx_booking'  => '',
				 * 'reminders' => ''
				 * )
				 * );
				 */
			}
		}


		/** CSS */
		public function enqueue_css_files( $where_to_load ) {

			if ( ( is_admin() ) && ( in_array( $where_to_load, array( 'admin', 'both' ) ) ) ) {

				wp_enqueue_style( 'wpbc-ajx_availability_calendar'
								, trailingslashit( plugins_url( '', __FILE__ ) ) . '_out/availability_calendar.css'          //, wpbc_plugin_url( '/includes/listing_ajx_booking/o-ajx_booking-listing.css' )
								, array(), WP_BK_VERSION_NUM );
			}
		}

	// </editor-fold>


	// <editor-fold     defaultstate="collapsed"                        desc=" ///  R e q u e s t  /// "  >

	/**
	 * Get params names for escaping and/or default value of such  params
	 *
	 * @return array        array (  'resource_id'      => array( 'validate' => 'digit_or_csd',  	'default' => array( '1' ) )
	 *                             , ... )
	 */
	static public function request_rules_structure(){

		return  array(
												 // 'digit_or_csd' can check about 'digit_or_csd' in arrays, as well
			  'resource_id' => array( 'validate' => 'digit_or_csd',  	'default' => 1 )	                                                // if ['0'] - All  booking resources
			//			, 'ui_wh_booking_date_checkout'     => array( 'validate' => 'digit_or_date',  	'default' => '' )		                    // number | date 2016-07-20
			//			, 'wh_modification_date' 			=> array( 'validate' => 'array',  	'default' => array( "3" ) )		                    // number | date 2016-07-20
			//			, 'ui_wh_modification_date_radio'   => array( 'validate' => 'd',  	            'default' => 0 )		                    // '1' | '2' ....
			//			, 'keyword'     			        => array( 'validate' => 's',  	            'default' => '' )			                //string
			//			, 'wh_cost'  		                => array( 'validate' => 'float_or_empty',  	            'default' => '' )			    // '1' | ''
			//			, 'ui_usr__send_emails'             => array( 'validate' => array( 'send', 'not_send' ),                  'default' => 'send' )
		);

	}

	// </editor-fold>



}

/**
 * Just for loading CSS and  JavaScript files
 */
if ( true ) {
	$ajx_availability_loading = new WPBC_AJX__Availability;
	$ajx_availability_loading->init_load_css_js_tpl();
	//$ajx_availability_loading->define_ajax_hook();
}


/**
 *  A c t i v a t e  - Create new DB Table, for booking dates properties
 *
 * booking date property can be relative to:  	prop_name =  'unavailable', 'available', 'rate', 'allow_start_day_selection', 'allow_days_number_to_select', 'availability_count', ...
 *
 * @return void
 */
function wpbc_activation__dates_availability() {                                                                            //FixIn: 9.3.1.2

	global $wpdb;
	$charset_collate  = ( ! empty( $wpdb->charset ) ) ? "DEFAULT CHARACTER SET $wpdb->charset" : '';
	$charset_collate .= ( ! empty( $wpdb->collate ) ) ? " COLLATE $wpdb->collate" : '';

	if ( ! wpbc_is_table_exists( 'booking_dates_props' ) ) {
		$simple_sql = "CREATE TABLE {$wpdb->prefix}booking_dates_props (
                     booking_dates_prop_id bigint(20) unsigned NOT NULL auto_increment,                     
                     resource_id bigint(10) NOT NULL default 1,
                     calendar_date datetime NOT NULL default '0000-00-00 00:00:00',
                     prop_name varchar(200) NOT NULL default '',
                     prop_value text,
                     PRIMARY KEY  (booking_dates_prop_id)
                    ) {$charset_collate}";
		$wpdb->query( $simple_sql );
	}
}
add_bk_action( 'wpbc_activation_after_db_actions', 'wpbc_activation__dates_availability' );


/**
 * D e a c t i v a t e
 */
function wpbc_deactivation__dates_availability() {

	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}booking_dates_props" );
}
add_bk_action( 'wpbc_other_versions_deactivation', 'wpbc_deactivation__dates_availability' );