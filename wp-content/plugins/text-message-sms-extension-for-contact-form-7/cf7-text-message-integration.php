<?php

/** 
 * Plugin Name: Text Message SMS Extension for Contact Form 7
 * Description: Integrates Biz Text services with Contact Form 7 plugin. Requires Contact Form 7 plugin. 
 * Version: 1.5
 * Author: Biz Text
 * Author URI: https://www.biztextsolutions.com/
 * License: GPL2
 */
if ( !defined('ABSPATH') ) die;

/*
// Hook for additional special mail tags for users
    add_filter( 'wpcf7_special_mail_tags', 'wpbiztextc7_mail_tag', 20, 3 );
 
    function wpbiztextc7_mail_tag( $output, $name, $html ) {
        // For backwards compatibility
        $name = preg_replace( '/^wpcf7\./', '_', $name );
        $current_user = wp_get_current_user();
        $phone_number = "billing_phone";
        $address_one = "billing_address_1";
    
 
       if ( '_' . $phone_number == $name ) {
     
            $all_meta_for_user = get_user_meta($current_user->ID, $phone_number, true);
            $output = $all_meta_for_user ;
       }
   
        if ( '_' . $address_one == $name ) {
     
            $all_meta_for_user = get_user_meta($current_user->ID, $address_one, true);
            $output = $all_meta_for_user ;
       }
 
       return $output;
    }

*/

//define constants below
if ( ! defined( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY' ) ) {
	define( 'WPCF7_ADMIN_READ_WRITE_CAPABILITY', 'publish_pages' );
}

define('WPBIZTEXTC7_OPTIONS', 'wpbiztextc7_options');



function wpbiztextc7_load_scripts_js() {
    $js_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'admin/js/script_biztextc7admin.js'));
    wp_enqueue_script('script_biztextc7admin.js', plugins_url('admin/js/script_biztextc7admin.js', __FILE__), array(), $js_ver);

}

function wpbiztextc7_load_scripts_css() {
    $cs_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . 'admin/css/biztextc7admin-style.css'));
    wp_enqueue_style('biztextc7admin-style.css', plugins_url('admin/css/biztextc7admin-style.css', __FILE__), array(), $cs_ver);
}

if (isset($_GET['page'])) {

	if ($_GET['page'] == "wpcf7biztext") {

		add_action('admin_print_scripts', 'wpbiztextc7_load_scripts_js', 5);
		add_action('admin_head', 'wpbiztextc7_load_scripts_css');
	} else if ($_GET['page'] == "wpcf7"){
        add_action('admin_head', 'wpbiztextc7_load_scripts_css');
    }
}

require_once 'admin/admin_global_settings.php';
require_once 'admin/wpbiztextc7_tab_form_settings.php';

 ?>