<?php

@ini_set( 'upload_max_size' , '5000M' );


// Fix for Enqueing StyleSheets

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles()
{
    $parenthandle = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}


// Code for adding extra fields to user's profile section.

add_action('show_user_profile', 'show_extra_profile_fields');
add_action('edit_user_profile', 'show_extra_profile_fields');

function show_extra_profile_fields($user)
{ ?>
    <h3>Extra profile information</h3>
    <table class="form-table">
        <tr>
            <th><label for="employee_company">Employee Company</label></th>
            <td>

                <?php
                // get dropdown saved value
                $comp_selected = get_the_author_meta('employee_company', $user->ID);

                // controls what companies get listed inside the dropdown
                $company_list = array(
                    "all-companies",
                    "inventive-group",
                    "iws"
                );
                ?>

                <select name="employee_company" id="employee_company">
                    <?php foreach ($company_list as $comp_val) : ?>
                        <option value="<?php echo $comp_val; ?>" <?php if ($comp_selected == $comp_val) {
                                                                        echo 'selected="selected"';
                                                                    } ?>>
                            <?php switch ($comp_val) {
                                case "all-companies":
                                    echo 'All Companies (This user sees everything)';
                                    break;
                                case "inventive-group":
                                    echo 'Inventive-Group (In The Ditch, Razorback Offroad, Fish Fighter Products, Inventive Products)';
                                    break;
                                case "iws":
                                    echo 'IWS (Idaho Wrecker Sales, Motorcoach Sales, Trailer Sales)';
                                    break;
                            } ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <br />

                <span>This field controls what content the user will see when viewing the Internal Web.</span>
            </td>
        </tr>
        <!-- <tr>
            <th><label for="employee_image_url">Employee Image</label></th>
            <td>
                <input type="url" name="employee_image_url" id="employee_image_url" value="<?php //echo esc_attr(get_the_author_meta('employee_image_url', $user->ID)); 
                                                                                            ?>" />
                <br />
                <span>Copy the URL of the employee's profile image from the media library into this field, and it will be used to populate different areas across the entire Internal Web</span>
            </td>
        </tr> -->
        <tr>
            <th><label for="employee_department">Employee Department</label></th>
            <td>

                <?php
                // get dropdown saved value
                $dept_selected = get_the_author_meta('employee_department', $user->ID);

                // controls what departments get listed inside the dropdown
                $departments_list = array(
                    "accounting",
                    "administration",
                    "engineering",
                    "frieght",
                    "laser",
                    "machine-shop",
                    "marketing",
                    "maintenance",
                    "night-shift",
                    "powder-coating",
                    "press-brake",
                    "production",
                    "sales",
                    "sewing-upholstery-silkscreening",
                    "shipping",
                    "tube-fab",
                    "welding",
                    "hot-rods-iws",
                    "parts-iws",
                    "service-iws",
                    "shop-iws"
                );
                ?>

                <!-- employee department dropdown -->
                <select name="employee_department" id="employee_department">
                    <?php foreach ($departments_list as $dept_val) : ?>
                        <option value="<?php echo $dept_val; ?>" <?php if ($dept_selected == $dept_val) {
                                                                        echo 'selected="selected"';
                                                                    } ?>>
                            <?php echo ucfirst(str_replace("-", " ", $dept_val)); ?></option>
                    <?php endforeach; ?>
                </select>
                <!-- /employee department dropdown -->

                <br />

                <span>What department the employee works in.</span>
            </td>
        </tr>
        <tr>
            <th><label for="employee_phone">Employee Phone</label></th>
            <td>
                <input type="text" name="employee_phone" id="employee_phone" value="<?php echo esc_attr(get_the_author_meta('employee_phone', $user->ID)); ?>" />
                <br />
                <span>If the employee has a company phone, this is where that number is placed.</span>
            </td>
        </tr>
        <tr>
            <th><label for="employee_extension">Employee Extension</label></th>
            <td>
                <input type="text" name="employee_extension" id="employee_extension" value="<?php echo esc_attr(get_the_author_meta('employee_extension', $user->ID)); ?>" />
                <br />
                <span>The extension where the employee is available at.</span>
            </td>
        </tr>
    </table>
<?php }

add_action('personal_options_update', 'save_extra_profile_fields');
add_action('edit_user_profile_update', 'save_extra_profile_fields');

function save_extra_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'employee_company', $_POST['employee_company']);
    // update_user_meta($user_id, 'employee_image_url', $_POST['employee_image_url']);
    update_user_meta($user_id, 'employee_department', $_POST['employee_department']);
    update_user_meta($user_id, 'employee_phone', $_POST['employee_phone']);
    update_user_meta($user_id, 'employee_extension', $_POST['employee_extension']);
}


//* Add custom message to WordPress login page

function smallenvelop_login_message($message)
{
    if (empty($message)) {
        return '<p style="text-align:center; margin:20px;"><strong>If logging in using a department account, make sure your department is spelled out with no capitals letters and spaces where they are needed.<br /><br />Example:<br />Username: welding Password: welding <br />or<br />Username: tube fab Password: tube fab<br /> Both username and password for department accounts is exactly the same.</strong></p>';
    } else {
        return $message;
    }
}

add_filter('login_message', 'smallenvelop_login_message');


// Redirects on successful login to the previous page
add_action('wp', 'sc_capture_before_login_page_url');
function sc_capture_before_login_page_url()
{
    if (!is_user_logged_in()) :
        $_SESSION['referer_url'] = get_the_permalink();
    endif;
}

/*@ After login redirection */
if (!function_exists('sc_after_login_redirection')) :
    function sc_after_login_redirection()
    {

        $redirect_url = home_url('/');
        if (isset($_SESSION['referer_url'])) :
            $redirect_url = $_SESSION['referer_url'];
            unset($_SESSION['referer_url']);
        endif;

        return $redirect_url;
        exit;
    }
    add_filter('login_redirect', 'sc_after_login_redirection');
endif;


// Adds lead cutom role to wordpress
add_role('lead', 'Lead', get_role('subscriber')->capabilities);


// Removes admin bar for everyone but admins
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
