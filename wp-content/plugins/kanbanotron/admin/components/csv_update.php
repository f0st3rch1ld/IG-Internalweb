<?php

// CSV Update Page

?>

<div class="update-kanbans-app-container">
    <div class="inner-container">
        <div>
            <h4>CSV Update</h4>

            <?php

            $csv_loc =  WP_CONTENT_DIR . '/uploads/kanban-upload.csv';

            if (file_exists($csv_loc)) {
                echo 'File Uploaded<br /><p>-----------------------------------<p><br />';

                $file = fopen($csv_loc, "r");

                // converts csv data into a php array
                if (($handle = $file) !== FALSE) {
                    $all_data = array();

                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

                        $all_data[] = array(
                            'vendor' => $data[0],
                            'part_number' => $data[3],
                            'man_part_number' => $data[1],
                            'location' => $data[2],
                            'description' => $data[4],
                            'knbn_qty' => $data[7],
                            'package_qty' => $data[5],
                            'lead_time' => $data[6]
                        );
                    }
                }

                fclose($file);

                include plugin_dir_path(__FILE__) . '../db/knbn_wp_connection.php';

                for ($i = 0; count($all_data) > $i; $i++) {

                    // skip first row
                    if ($i != 0) {

                        // cross referencing existing posts to check and see if one already exists using either the part number or vendor part number so we don't make any extra posts we don't need.
                        $knbn_vendor_part_number_query = "SELECT post_id FROM wp_postmeta WHERE meta_value='" . $all_data[$i]['man_part_number'] . "'";
                        $knbn_vendor_part_number_result = $conn->query($knbn_vendor_part_number_query);

                        $knbn_post_id = 0;

                        if ($knbn_vendor_part_number_result->num_rows > 0) {
                            while ($row = $knbn_vendor_part_number_result->fetch_assoc()) {
                                $knbn_post_id = $row['post_id'];
                            }
                        }

                        // Product Type Determination
                        $product_type_determination;

                        $internal_vendors_array = array(
                            'IWS',
                            'ITD',
                            'RBO',
                            'FFP',
                            'Razorback Offroad',
                            'Fish Fighter Products',
                            'Fish Fighter'
                        );

                        if (in_array($all_data[$i]['vendor'], $internal_vendors_array)) {
                            $product_type_determination = 'internal';
                        } else {
                            $product_type_determination = 'external';
                        }

                        // Order Method Determination
                        $order_method_determination = '';
                        $online_external_vendors_array = array(
                            'Amazon',
                            'McMaster',
                            'Uline',
                            'Staples'
                        );
                        if ($product_type_determination == 'external' && in_array($all_data[$i]['vendor'], $online_external_vendors_array)) {
                            $order_method_determination = 'website';
                        } elseif ($product_type_determination == 'external') {
                            $order_method_determination = 'generated-po';
                        }

                        // Reorder Quantity Determination
                        $reorder_qty_determination = NULL;

                        if ($all_data[$i]['knbn_qty'] && $all_data[$i]) {
                            $exploded_knbn_qty = explode('/', $all_data[$i]['knbn_qty']);
                            $reorder_qty_determination = $exploded_knbn_qty[0];
                        }

                        // Lead Time Conversion
                        $converted_lead_time;
                        $lowercase_lead_time = strtolower($all_data[$i]['lead_time']);

                        if (strpos($lowercase_lead_time, 'weeks') != false || strpos($lowercase_lead_time, 'week') != false) {
                            $converted_lead_time = intval($lowercase_lead_time) * 7;
                        } else {
                            $converted_lead_time = intval($lowercase_lead_time);
                        }

                        $my_post = array(
                            'ID' => $knbn_post_id,
                            'post_title' => ucwords(str_replace(' ', '-', $all_data[$i]['vendor']) . '-' . $all_data[$i]['part_number'] . str_replace(' ', '-', $all_data[$i]['description'])),
                            'post_content' => '',
                            'post_status' => 'publish',
                            'post_type' => 'knbn_action',
                            'meta_input' => array(
                                'product_setup_product_type' => $product_type_determination,
                                'product_setup_order_method' => $order_method_determination,
                                'kanban_information_location' => $all_data[$i]['location'],
                                'kanban_information_vendor' => $all_data[$i]['vendor'],
                                'kanban_information_part_number_group_part_number' => $all_data[$i['part_number']],
                                'kanban_information_part_number_group_vendor_part_number' => $all_data[$i]['man_part_number'],
                                'kanban_information_description' => $all_data[$i]['description'],
                                'kanban_information_quantities_kanban_quantity' => $all_data[$i]['knbn_qty'],
                                'kanban_information_quantities_package_quantity' => $all_data[$i]['package_qty'],
                                'kanban_information_quantities_reorder_quantity' => $reorder_qty_determination,
                                'kanban_information_lead_time' =>  $converted_lead_time
                            )
                        );

                        $post_id = wp_insert_post($my_post, true);

                        if (is_wp_error($post_id)) {
                            $errors = $post_id->get_error_messages();
                            foreach ($errors as $error) {
                                echo "- " . $error . "<br />";
                            }
                        } else {
                            if ($knbn_post_id != 0) {
                                echo "Kanban successfully updated!<br />";
                            } else {
                                echo "Kanban successfully added!<br />";
                            }

                            foreach ($all_data[$i] as $key => $value) {
                                echo $key . " : " . $value . "<br />";
                                if ($key == 'lead_time') {
                                    echo "<p>-----------------------------------<p><br />";
                                }
                            }
                        }
                    }
                }

                $conn->close();

                if (unlink($csv_loc)) {
                    echo 'Kanbans succesfully uploaded<br />';
                } else {
                    echo 'There has been an error with the upload, please try again later.<br />';
                }
            }

            ?>

        </div>
    </div>
</div>