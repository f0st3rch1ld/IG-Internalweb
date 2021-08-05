<?php

$knbn_external_yn;
$knbn_order_method;
$knbn_external_url;
$knbn_dept_location;
$knbn_dept_cell;
$knbn_vendor;
$knbn_part_number;
$knbn_vendor_part_number;
$knbn_description;
$knbn_package_quantity;
$knbn_reorder_quantity;
$knbn_blue_bin_quantity;
$knbn_red_bin_quantity;
$knbn_lead_time;
$knbn_notes;

function knbn_info_request($passed_knbn_uid)
{
    include 'knbn_wp_connection.php';

    // Retrieves Kanban Post ID from unique value located inside QR
    $knbn_post_id = "SELECT post_id FROM wp_postmeta WHERE meta_value='" . $passed_knbn_uid . "'";
    $knbn_post_id_result = $conn->query($knbn_post_id);

    // If retrieval process was succesful, assigns correct meta_values to variables to be used on main.php
    if ($knbn_post_id_result->num_rows > 0) {

        // Converts fetched result into a useable format
        $knbn_post_id_return = $knbn_post_id_result->fetch_array(MYSQLI_NUM);
        $knbn_post_id_val = $knbn_post_id_return[0];

        // This builds out the specific sql queries we need from the database
        $knbn_external_url_yn_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='product_setup_product_type'";
        $knbn_order_method_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='product_setup_order_method'";
        $knbn_external_url_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='external_product_url'";
        $knbn_dept_location_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_location_department_location'";
        $knbn_dept_cell_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_location_department_cell'";
        $knbn_vendor_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_vendor'";
        $knbn_part_number_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_part_number_group_part_number'";
        $knbn_vendor_part_number_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_part_number_group_vendor_part_number'";
        $knbn_description_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_description'";
        $knbn_package_quantity_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_quantities_package_quantity'";
        $knbn_reorder_quantity_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_quantities_reorder_quantity'";
        $knbn_blue_bin_quantity_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_quantities_blue_bin_quantity'";
        $knbn_red_bin_quantity_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_quantities_red_bin_quantity'";
        $knbn_lead_time_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_information_lead_time'";
        $knbn_notes_query = "SELECT meta_value FROM wp_postmeta WHERE post_id='" . $knbn_post_id_val . "' AND meta_key='kanban_notes'";

        // This is where the program actually queries the database, and assigns the results to variables.
        $knbn_external_url_yn_result = $conn->query($knbn_external_url_yn_query);
        $knbn_order_method_result = $conn->query($knbn_order_method_query);
        $knbn_external_url_result = $conn->query($knbn_external_url_query);
        $knbn_dept_location_result = $conn->query($knbn_dept_location_query);
        $knbn_dept_cell_result = $conn->query($knbn_dept_cell_query);
        $knbn_vendor_result = $conn->query($knbn_vendor_query);
        $knbn_part_number_result = $conn->query($knbn_part_number_query);
        $knbn_vendor_part_number_result = $conn->query($knbn_vendor_part_number_query);
        $knbn_description_result = $conn->query($knbn_description_query);
        $knbn_package_quantity_result = $conn->query($knbn_package_quantity_query);
        $knbn_reorder_quantity_result = $conn->query($knbn_reorder_quantity_query);
        $knbn_blue_bin_quantity_result = $conn->query($knbn_blue_bin_quantity_query);
        $knbn_red_bin_quantity_result = $conn->query($knbn_red_bin_quantity_query);
        $knbn_lead_time_result = $conn->query($knbn_lead_time_query);
        $knbn_notes_result = $conn->query($knbn_notes_query);

        $knbn_external_url_yn_return = $knbn_external_url_yn_result->fetch_array(MYSQLI_NUM);
        $knbn_order_method_return = $knbn_order_method_result->fetch_array(MYSQLI_NUM);
        $knbn_external_url_return = $knbn_external_url_result->fetch_array(MYSQLI_NUM);
        $knbn_dept_location_return = $knbn_dept_location_result->fetch_array(MYSQLI_NUM);
        $knbn_dept_cell_return = $knbn_dept_cell_result->fetch_array(MYSQLI_NUM);
        $knbn_vendor_return = $knbn_vendor_result->fetch_array(MYSQLI_NUM);
        $knbn_part_number_return = $knbn_part_number_result->fetch_array(MYSQLI_NUM);
        $knbn_vendor_part_number_return = $knbn_vendor_part_number_result->fetch_array(MYSQLI_NUM);
        $knbn_description_return = $knbn_description_result->fetch_array(MYSQLI_NUM);
        $knbn_package_quantity_return = $knbn_package_quantity_result->fetch_array(MYSQLI_NUM);
        $knbn_reorder_quantity_return = $knbn_reorder_quantity_result->fetch_array(MYSQLI_NUM);
        $knbn_blue_bin_quantity_return = $knbn_blue_bin_quantity_result->fetch_array(MYSQLI_NUM);
        $knbn_red_bin_quantity_return = $knbn_red_bin_quantity_result->fetch_array(MYSQLI_NUM);
        $knbn_lead_time_return = $knbn_lead_time_result->fetch_array(MYSQLI_NUM);
        $knbn_notes_return = $knbn_notes_result->fetch_array(MYSQLI_NUM);

        global $knbn_external_url_yn;
        global $knbn_order_method;
        global $knbn_external_url;
        global $knbn_dept_location;
        global $knbn_dept_cell;
        global $knbn_vendor;
        global $knbn_part_number;
        global $knbn_vendor_part_number;
        global $knbn_description;
        global $knbn_package_quantity;
        global $knbn_reorder_quantity;
        global $knbn_blue_bin_quantity;
        global $knbn_red_bin_quantity;
        global $knbn_lead_time;
        global $knbn_notes;

        $knbn_external_url_yn = $knbn_external_url_yn_return[0];
        $knbn_order_method = $knbn_order_method_return[0];
        $knbn_external_url = $knbn_external_url_return[0];
        $knbn_dept_location = $knbn_dept_location_return[0];
        $knbn_dept_cell = $knbn_dept_cell_return[0];
        $knbn_vendor = $knbn_vendor_return[0];
        $knbn_part_number = $knbn_part_number_return[0];
        $knbn_vendor_part_number = $knbn_vendor_part_number_return[0];
        $knbn_description = $knbn_description_return[0];
        $knbn_package_quantity = $knbn_package_quantity_return[0];
        $knbn_reorder_quantity = $knbn_reorder_quantity_return[0];
        $knbn_blue_bin_quantity = $knbn_blue_bin_quantity_return[0];
        $knbn_red_bin_quantity = $knbn_red_bin_quantity_return[0];
        $knbn_lead_time = $knbn_lead_time_return[0];
        $knbn_notes = $knbn_notes_return[0];        
    } else {
        echo 'No matching kanban found.';
    }

    $conn->close();
}