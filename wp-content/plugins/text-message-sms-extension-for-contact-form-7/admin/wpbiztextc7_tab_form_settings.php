<?php 

//add tab in contact 7 form settings
add_filter('wpcf7_editor_panels', 'wpbiztextc7_add_editor_panel');

function wpbiztextc7_add_editor_panel($panels){
    if (current_user_can('wpcf7_edit_contact_form')) {
        $panels['wpcf7biztext-texting-panel'] = array(
            'title' => __('Biz Text SMS', 'wpcf7biztext'),
            'callback' => 'wpcf7biztext_editor_panel_texting'
        );
    }
    return $panels;
}

$wpbiztextc7_tab_setting_default_options = array (
    'wpbiztextc7-inquirer-phone-number' => '',
    'wpbiztextc7-inquirer-message' => 'Thank you for your message. We will get back to you as soon as possible.',
    'wpbiztextc7-visitor-nickname' => '',
    'wpbiztextc7-admin-message' => 'A contact form submission has been made.',
    'wpbiztextc7-email-notification-activation' => 1,
    'wpbiztextc7-send-autoreply-only' => '',
    'biztext-sms-status' => 1
);

//content inside biz text tab
function wpcf7biztext_editor_panel_texting($form) {
    global $wpbiztextc7_tab_setting_default_options;
    
    $options_name = 'wpbiztextc7-tab-settings-' . $form->id();
    $options = get_option($options_name); 
    //error_log($options_name);

    if ($options == false){
        add_option($options_name);
        $props = $form->get_properties();
        $original_id = isset($props['messages']['wpbiztextc7_copied']) ? $props['messages']['wpbiztextc7_copied'] : 0;
        if ($original_id != 0){
            $old_post_id=$props['messages']['wpbiztextc7_copied'];
            unset($props['messages']['wpbiztextc7_copied']);
            $form->set_properties($props);

            $old_options_name = 'wpbiztextc7-tab-settings-' . $old_post_id;
            $old_options = get_option($old_options_name);
            update_option($options_name, $old_options);
        } else {
            update_option($options_name, $wpbiztextc7_tab_setting_default_options);
        }
    }

    $options = get_option($options_name);
    
    // value for only send auto reply for existing forms 
    if (!isset($options['wpbiztextc7-send-autoreply-only'])) {
    
        $options['wpbiztextc7-send-autoreply-only'] = '';
    
    }
    
    /*
        // Used to collect user info
        $current_user = wp_get_current_user();
        $meta_for_phone = get_user_meta($current_user->ID, "billing_phone", true);
        $all_meta_for_user =  get_user_meta($current_user->ID,);
        error_log(print_r( $meta_for_phone ,true));
        error_log(print_r( (array_keys($all_meta_for_user)) ,true));
        error_log(print_r( (array_values($all_meta_for_user)) ,true));
    */
    
    ?>
    <!-- visitor sms information and message -->
    <div class='wrap'>
    <?php 
    $global_options = get_option(WPBIZTEXTC7_OPTIONS);

    // configure options
    $text_configure = ($options['wpbiztextc7-send-autoreply-only'] != 1) ? " Receive text & send autoreply text" : " Send autoreply text only";
    $text_email_configure = ($options['wpbiztextc7-email-notification-activation'] != 1) ? "" : " | Receive email notify text";
    
    if ($global_options['wpbiztextc7_setting_verification_status'] == 'Y'){ ?>
        <div class='wpbiztextc7-success'>
            <span><strong>Biz Text Id is verified, SMS activated </strong><a href='<?= get_admin_url() ?>admin.php?page=wpcf7biztext' target='_self'>Global Settings</a></span>
        </div>
    <?php } else { ?>
        <div class='wpbiztextc7-error'>
            <span><strong>Biz Text Id is not verified. SMS will not function without a verified Biz Text Id. </strong><a href='<?= get_admin_url() ?>admin.php?page=wpcf7biztext' target='_self'>Global Settings</a></span>
        </div>
    <?php } ?>
    <span> SMS Text Options configured to: <?php echo $text_configure . " " . $text_email_configure ?></span>
    <span class="biztext"><hr><span>
    <h2 style="display:inline;"><strong>Text to Send</strong> (Autoreply - Visitor SMS) </h2>
    <span class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Configure/edit the phone and message fields to send an autoreply text to your website visitor. Use available tags and special mail-tags for nonsubmission info. *required</span></span>

    <span><a href='https://www.biztextsolutions.com/integrations/wordpress/text-message-sms-extension-for-contact-form-7-tutorial/#sms-visitor' target='_blank'>How To Configure</a></span>
        <fieldset>
            <table class="form-table">
                <tbody>
                   <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <span class="wpbiztextc7-tags">Available tags: <?= $form->suggest_mail_tags(); ?> | <a href='https://contactform7.com/special-mail-tags/' target="_blank"> Special mail-tags</a> <span class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Add information seperate from the form fields or visitors submission. (submissions related, post related, site related, user related)</span></span><span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for='wpbiztextc7-inquirer-phone-number'>*Phone Number</span></div></label>
                        </th>
                        <td>
                            <input type='text' id='wpbiztextc7-inquirer-phone-number' name='<?= $options_name . '[wpbiztextc7-inquirer-phone-number]'; ?>' value='<?= $options['wpbiztextc7-inquirer-phone-number'] ?>' />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for='wpbiztextc7-inquirer-message'>*Message</label>
                        </th>
                        <td>
                            <textarea id='wpbiztextc7-inquirer-message' name='<?= $options_name . '[wpbiztextc7-inquirer-message]'; ?>' cols='100' rows='6' class='large-text code' required ><?= $options['wpbiztextc7-inquirer-message'] ?></textarea>
                           
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    </div>

    <hr>

    <!-- admin sms information and message -->
   
    <div class='wrap'>
    <h2 style="display:inline;"><strong>Text to Receive</strong> (From Form - Your SMS) </h2>
    <span class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Configure/edit the message field to receive a text of the form information and or notification of an email. Use available tags and special mail-tags for nonsubmission info. *required</span></span>
    <span><a href='https://www.biztextsolutions.com/integrations/wordpress/text-message-sms-extension-for-contact-form-7-tutorial/#sms-your' target='_blank'>How To Configure</a></span>
        <fieldset>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <span class="wpbiztextc7-tags">Available tags: <?= $form->suggest_mail_tags(); ?> | <a href='https://contactform7.com/special-mail-tags/' target="_blank"> Special mail-tags</a> <span class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Add information seperate from the form fields or visitors submission. (submissions related, post related, site related, user related)</span></span><span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for='wpbiztextc7-admin-message'>*Message</label>
                        </th>
                        <td>
                            <textarea id='wpbiztextc7-admin-message' name='<?= $options_name . '[wpbiztextc7-admin-message]'; ?>' cols='100' rows='6' class='large-text code' required><?= $options['wpbiztextc7-admin-message'] ?></textarea>
                            <span>Also used for email notify text</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
     </div>
     <span class="biztext"><hr><span>
     <!-- Options -->
    <h2><strong>Text Options</strong></h2>
    <div class='wrap'>
        <fieldset>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                        </th>
                        <td>
                            <span class="wpbiztextc7-tags">Available tags: <?= $form->suggest_mail_tags(); ?><span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="wpbiztextc7-visitor-nickname">Nickname <div class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Used as a label for conversation on Texting Dashboard and forwarded text.</span></div></label>
                        </th>
                        <td>
                            <input type='text' id='wpbiztextc7-visitor-nickname' name='<?= $options_name . '[wpbiztextc7-visitor-nickname]'; ?>' value='<?= $options['wpbiztextc7-visitor-nickname'] ?>' />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for='wpbiztextc7-send-autoreply-only'>Send Only <div class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Only send text, auto-response text to visitor (Enable if not receiving a message, no admin text sent to you)</span></div><label>
                        </th>
                        <td>
                            <input type="checkbox" id='wpbiztextc7-send-autoreply-only' name='<?= $options_name . '[wpbiztextc7-send-autoreply-only]'?>' value='1' <?php checked( 1, $options['wpbiztextc7-send-autoreply-only'] ); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for='wpbiztextc7-email-notification-activation'> Email Notice Text <div class="wpbiztextc7-tooltip"><span class="wpbiztextc7-tooltiptext">Receive a text when an email is sent. A number must be entered in global settings. Set message under Text to Recieve.</span></div><label>
                        </th>
                        <td>
                            <input type="checkbox" id='wpbiztextc7-email-notification-activation' name='<?= $options_name . '[wpbiztextc7-email-notification-activation]'?>' value='1' <?php checked( 1, $options['wpbiztextc7-email-notification-activation'] ); ?> />
                            <?php    
                            
                            if ($global_options["wpbiztextc7_setting_email_notif_number"] != ''){ ?>
                                <span class='wpbiztextc7-success'>
                                    <span>Email notify activated <a href='<?= get_admin_url() ?>admin.php?page=wpcf7biztext' target='_self'>Global Settings</a></span>
            
                                </span>
                            <?php } else { ?>
                                <span class='wpbiztextc7-error'>
                                    <span>Email notify not activated. Enter a number. <a href='<?= get_admin_url() ?>admin.php?page=wpcf7biztext' target='_self'>Global Settings</a></span>
                                </span>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
     </div>
    <?php
}


add_filter('wpcf7_copy', 'wpbiztextc7_copy', 10, 2);

function wpbiztextc7_copy($new_form, $current_form){

    $id = $current_form->id();
	$props = $new_form->get_properties();
	$props['messages']['wpbiztextc7_copied'] = $id;
	$new_form->set_properties($props);

	return $new_form;
}


function wpbiztextc7_save_contact_form($form) {
    $options_name = 'wpbiztextc7-tab-settings-' . $form->id();
    
    if (isset( $_POST[$options_name])){
        $options = get_option($options_name);
        $options['wpbiztextc7-inquirer-phone-number'] = trim(sanitize_text_field($_POST[$options_name]['wpbiztextc7-inquirer-phone-number']));
        $options['wpbiztextc7-inquirer-message'] = trim(sanitize_textarea_field($_POST[$options_name]['wpbiztextc7-inquirer-message']));
        $options['wpbiztextc7-visitor-nickname'] = trim(sanitize_text_field($_POST[$options_name]['wpbiztextc7-visitor-nickname']));
        $options['wpbiztextc7-admin-message'] = trim(sanitize_textarea_field($_POST[$options_name]['wpbiztextc7-admin-message']));
        $options['wpbiztextc7-email-notification-activation'] = trim(sanitize_text_field($_POST[$options_name]['wpbiztextc7-email-notification-activation']));
        $options['wpbiztextc7-send-autoreply-only'] = trim(sanitize_text_field($_POST[$options_name]['wpbiztextc7-send-autoreply-only']));
        
        update_option($options_name, $options);
    }
}

add_action('wpcf7_save_contact_form', 'wpbiztextc7_save_contact_form');

function wpbiztextc7_before_send_email($form, &$abort, $submission){


    $options_name = 'wpbiztextc7-tab-settings-' . $form->id();
    $options = get_option($options_name);
    
    $data = 0;
    $props = $form->get_properties();

    $raw_customer_phone = trim(wpcf7_mail_replace_tags($options['wpbiztextc7-inquirer-phone-number']));
   
    $options['biztext-sms-status'] = -1;
    $options['biztext-mail-failed-message'] = (isset($props['messages']['mail_sent_ng'])) ?  $props['messages']['mail_sent_ng'] : 'There was an error trying to send your message. Please try again later.';
    $options['biztext-mail-sent-message'] = (isset($props['messages']['mail_sent_ok'])) ?  $props['messages']['mail_sent_ok'] : 'Thank you for your message. It has been sent.';
    update_option($options_name, $options);
    
    $customer_auto_response = $options['wpbiztextc7-inquirer-message'];
    if ($raw_customer_phone != '' && $customer_auto_response != '' ){

        $customer_phone = preg_replace('/[^0-9]/', '', $raw_customer_phone);
        if (strlen($raw_customer_phone) == 10){
            $customer_phone = 1 . $customer_phone;
        }
        $customer_auto_response = trim(wpcf7_mail_replace_tags($customer_auto_response));
        $admin_message = trim(wpcf7_mail_replace_tags($options['wpbiztextc7-admin-message']));
        
        $bizTextId = get_option(WPBIZTEXTC7_OPTIONS)['wpbiztextc7_setting_biztext_id'];
        
        // check if only sending auto reply 
        
        if ($options['wpbiztextc7-send-autoreply-only'] == 1) {
        
            // only send to client 
            $bizTextData = array(
                'websiteId' => $bizTextId,
                'txt' => $customer_auto_response,
                'to'=> $customer_phone, // changed for sending only
            );
            $url = 'https://www.biztextsolutions.com/api/send/to-client'; // changed for sending only
        
        } else {
        
            // send to client and business
            $bizTextData = array(
                'websiteId' => $bizTextId,
                'txt' => $admin_message,
                'from' => $customer_phone, //text notification number here if ther
                'response' => $customer_auto_response
            );
            $url = 'https://www.biztextsolutions.com/api/send/to-business'; 
            
        
        }

        $nickname = wpcf7_mail_replace_tags($options['wpbiztextc7-visitor-nickname']);
        if ($nickname != ''){
            $bizTextData = array_merge($bizTextData, array('nickname' => $nickname));
        }

        $bizTextData = wp_json_encode($bizTextData);
               
        
        
        $response = wp_remote_post($url, array(
                'headers' => array('Content-Type' => 'application/json'),
                'body' => $bizTextData,
                'data_format' => 'body'
        ));

        $data = $response['response']['code'];
        if ($data == 200){
            $options['biztext-sms-status'] = 1;
            update_option($options_name, $options);
        } else {
            $options['biztext-sms-status'] = 0;
            
            update_option($options_name, $options);
        }
    }


    if($props['mail']['recipient'] == ''){
        $abort = true;
    }

}

add_filter('wpcf7_ajax_json_echo', 'wpbiztextc7_ajax_json_echo', 10, 2);

function wpbiztextc7_ajax_json_echo($response, $result){

    $options_name = 'wpbiztextc7-tab-settings-' . $result['contact_form_id'];
    $options = get_option($options_name);
    $customer_phone = $options['wpbiztextc7-inquirer-phone-number'];
    $raw_email_notif_number = get_option(WPBIZTEXTC7_OPTIONS)['wpbiztextc7_setting_email_notif_number'];
    
    if ($options['wpbiztextc7-email-notification-activation'] == 1){
        if ($raw_email_notif_number != '' && ($response['status'] == 'mail_sent' || $response['status'] == 'mail_failed')){
     
            $admin_message = trim(wpcf7_mail_replace_tags($options['wpbiztextc7-admin-message']));
            $txt = $admin_message;

            if ($response['status'] == 'mail_sent'){
                $txt = 'Email Sent - ' . $txt;
            } else if ($response['status'] == 'mail_failed'){
                $txt = 'Email Failed to Send - ' . $txt;
            }
            
            $bizTextId = get_option(WPBIZTEXTC7_OPTIONS)['wpbiztextc7_setting_biztext_id'];
            $email_notif_number = 1 . preg_replace('/[^0-9]/', '', $raw_email_notif_number);
            $msg_came_from = "(" . get_bloginfo('name') . " - Website) ";

            $bizTextData = array(
                'websiteId' => $bizTextId,
                'txt' => $msg_came_from . $txt,
                'from' => $email_notif_number, //text notificatoin number here if ther
                "nickname" => 'Email Notification Text'
            );
            
            $bizTextData = wp_json_encode($bizTextData);
                
            $url = 'https://www.biztextsolutions.com/api/send/to-business';
            $biztext_response = wp_remote_post($url, array(
                    'headers' => array('Content-Type' => 'application/json'),
                    'body' => $bizTextData,
                    'data_format' => 'body'
            ));

        }

    }

    if ($options['biztext-sms-status'] == 1 && ($response['status'] == 'mail_sent' || $response['status'] == 'mail_failed' || $response['status'] == 'aborted')){
        $response['status'] = 'mail_sent';
        $response['message'] = $options['biztext-mail-sent-message'];
    } else if ($options['biztext-sms-status'] == 0 && ($response['status'] == 'aborted')){
        $response['status'] = 'mail_failed';
        $response['message'] = $options['biztext-mail-failed-message'];
    } 

    return $response;
}

add_action('wpcf7_before_send_mail', 'wpbiztextc7_before_send_email', 15 ,3);
?>