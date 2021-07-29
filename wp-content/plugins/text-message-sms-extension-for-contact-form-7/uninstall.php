<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ){
    die();
}

function wpbiztextc7_delete_plugin(){
    global $wpdb;

    delete_option('wpbiztextc7_options');

    $plugin_options = $wpdb->get_results( "SELECT option_name FROM $wpdb->options WHERE option_name LIKE 'wpbiztextc7-tab-settings-%'" );

    foreach( $plugin_options as $option ) {
        delete_option( $option->option_name );
    }
}

wpbiztextc7_delete_plugin();
?>