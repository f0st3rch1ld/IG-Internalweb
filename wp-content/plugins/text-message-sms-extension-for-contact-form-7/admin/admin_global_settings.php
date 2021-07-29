<?php 
if ( !defined('ABSPATH') ) die; 

if ( get_option(WPBIZTEXTC7_OPTIONS) == false){
    add_option(WPBIZTEXTC7_OPTIONS);
}

//add admin page as submenu of contact 7
function wpcf7biztext_admin_add_page(){
    add_submenu_page('wpcf7', 
                     'Biz Text Integration', 
                     'Biz Text Integration', 
                     WPCF7_ADMIN_READ_WRITE_CAPABILITY, 
                     'wpcf7biztext',
                     'wpcf7biztext_settings_page'
    );
}
add_action('admin_menu', 'wpcf7biztext_admin_add_page');

$wpbiztextc7_default_options = array(
    'wpbiztextc7_setting_biztext_id' => '',
    'wpbiztextc7_setting_verification_status' => 'N',
    'wpbiztextc7_setting_email_notif_number' => ''
);

$wpbiztextc7_options = get_option(WPBIZTEXTC7_OPTIONS);


function wpcf7biztext_settings_page(){
    global $wpbiztextc7_default_options, $wpbiztextc7_options;
    ?>
    <div class='wrap wpbiztextc7-main-settings'>
        <h1>Biz Text Configurations</h1>
        <?php 
        if (isset($_POST['wpbiztextc7-default_settings'])){
            echo "<div class='notice notice-success is-dismissible'><p><strong>Default Settings Restored</p></strong></div>";
        } else {
            settings_errors(); //default saved alerts shown here; can customtize with add_settings_errors() 
        }

        ?> 
        <form action='options.php' method='post' id='wpbiztextc7_global_settings_form'>
            <?php settings_fields(WPBIZTEXTC7_OPTIONS); ?>
            <?php do_settings_sections(WPBIZTEXTC7_OPTIONS); ?>
            <input id='wpbiztextc7-global-settings-submit' type='button' data-link='<?= admin_url('admin-ajax.php'); ?>' onclick='isBizTextIdValid()' class='button-primary' value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
    <?php
    if (! function_exists('biztext_options_page') ){
    ?>
    <div class='wrap'>
        <h2>Biz Text Solutions Text Message Plugin</h2>
        Receive and Send Text Messages to Give Better Customer Service & Support from your WordPress website. 
        <ul class='wpbiztextc7-list'>
            <li>Receive and Reply from your phone or online</li>
            <li>Affordable monthly plans with no contracts and cancel anytime</li>
            <li>Less phone calls, better service, change your business forever</li>
        </ul>
        <p><a target='_blank' class='button-primary' href="https://www.biztextsolutions.com/integrations/wordpress/text-message-plugin-sms/">Learn more about the Text Message Plugin</a></p>
    <?php
    }
    ?>
     <h3>Restore Default Settings</h3>
        <form method='POST' action="" id='wpbiztextc7_reset_settings_form'>
            <input name='wpbiztextc7-default_settings' type='hidden' value='wpbiztextc7-default_settings' />
            <input name='wpbiztextc7-default_settings' type='submit' class='button-secondary' value="<?php esc_attr_e('Restore Defaults')?>" />
        </form>
    <?php
}

//define form specific constants here


function wpbiztextc7_admin_init(){
    global $wpbiztextc7_default_options, $wpbiztextc7_options;
    
    if(false == get_option(WPBIZTEXTC7_OPTIONS)){
        add_option(WPBIZTEXTC7_OPTIONS);
        update_option(WPBIZTEXTC7_OPTIONS, $wpbiztextc7_default_options);

    }

    if (isset($_POST['wpbiztextc7-default_settings'])){
        update_option(WPBIZTEXTC7_OPTIONS, $wpbiztextc7_default_options);
    }
 
    add_settings_section('wpbiztextc7_settings_section', 
                        'Global Settings', 
                        'wpbiztextc7_settings_section_cb', 
                        WPBIZTEXTC7_OPTIONS
                       );
          
    // biztext id text field
    add_settings_field( 'wpbiztextc7_setting_biztext_id',
                        'Biz Text ID',
                        'wpbiztextc7_setting_biztext_id_cb',
                        WPBIZTEXTC7_OPTIONS,
                        'wpbiztextc7_settings_section'
                    );

    // biztext email notification number
    add_settings_field('wpbiztextc7_setting_email_notif_number',
                       'Email Notification Phone Number',
                       'wpbiztextc7_setting_email_notif_number_cb',
                        WPBIZTEXTC7_OPTIONS,
                       'wpbiztextc7_settings_section'
                       );

    register_setting(WPBIZTEXTC7_OPTIONS, WPBIZTEXTC7_OPTIONS, 'wpbiztextc7_handle_sanitization');

}

function wpbiztextc7_handle_sanitization($option){
    $option = array_map('sanitize_text_field', $option);
    
    return $option;
}

add_action('admin_init', 'wpbiztextc7_admin_init');

function wpbiztextc7_settings_section_cb(){
    echo "<a href='https://www.biztextsolutions.com/integrations/wordpress/text-message-sms-extension-for-contact-form-7-tutorial/#biz-text-id' target='_blank'>Documentation for Global Settings</a>";
    echo "<p>Enter Information below.</p>";
}

function wpbiztextc7_setting_biztext_id_cb(){
    $options = get_option(WPBIZTEXTC7_OPTIONS);
    $id_field = "<input id='wpbiztextc7_setting_biztext_id' name='" . WPBIZTEXTC7_OPTIONS . "[wpbiztextc7_setting_biztext_id]" . "' size='40' type='text' value='{$options['wpbiztextc7_setting_biztext_id']}' />";
    $verify_button = "<input id='wpbiztextc7_setting_btid_btn' name='wpbiztextc7_setting_btid_btn' class='button-secondary' data-link='" . admin_url('admin-ajax.php') ."' type='button' onclick='isBizTextIdValid()' value='Verify'/>";
    $verification_hidden_field = "<input id='wpbiztextc7_setting_verification_status' name='" . 
                                        WPBIZTEXTC7_OPTIONS . "[wpbiztextc7_setting_verification_status]" . "' type='hidden'  value='{$options['wpbiztextc7_setting_verification_status']}' />";
    echo $verification_hidden_field;
    echo $id_field . '<span id="wpbiztextc7-spinner" class="spinner"></span>';
    $verification_status_text = ($options['wpbiztextc7_setting_verification_status'] == 'Y') ? 'Biz Text Id verified.' : 'Biz Text Id not verified.';
    $status_class = ($options['wpbiztextc7_setting_verification_status'] == 'Y') ? 'wpbiztextc7-success' : 'wpbiztextc7-error'; 
    echo "<p id='wpbiztextc7-verification-text' class='$status_class'><strong>$verification_status_text</strong></p>";
}

function wpbiztextc7_setting_email_notif_number_cb(){
    $options = get_option(WPBIZTEXTC7_OPTIONS);
    echo "<input id='wpbiztextc7_setting_email_notif_number' name='" . WPBIZTEXTC7_OPTIONS . "[wpbiztextc7_setting_email_notif_number]" . "' size='40' type='text' 
                                value='{$options['wpbiztextc7_setting_email_notif_number']}' />";   
}

add_action('wp_ajax_wpbiztextc7_verify_id', 'wpbiztextc7_verify_id');
add_action('wp_ajax_nopriv_wpbiztextc7_verify_id', 'wpbiztextc7_verify_id');

function wpbiztextc7_verify_id(){
   
    $id = sanitize_text_field(trim($_POST['id']));
  
    $bizTextData = array(
        'websiteId' => $id,
            'txt' => '',
            'from' => ''
        );

    $bizTextData = wp_json_encode($bizTextData);
     
    $url = 'https://www.biztextsolutions.com/api/send/to-business';
    $response = wp_remote_post($url, array(
            'headers' => array('Content-Type' => 'application/json'),
            'body' => $bizTextData,
            'data_format' => 'body'
    ));
    
    if ($response['response']['code'] == 400) {
        $wpbiztextc7_options = get_option(WPBIZTEXTC7_OPTIONS);
        $wpbiztextc7_options['wpbiztextc7_setting_biztext_id'] = $id;
        update_option(WPBIZTEXTC7_OPTIONS, $wpbiztextc7_options );
        echo 1;
    } else {
        echo 0;
    } 

   die();
}
?>