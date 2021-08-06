<?php
// Kanban Importer
?>
<div class="wrap">
    <h1>Kanbanotron - Import Kanbans</h1><br />
    <p>Use this form to upload a .csv to the website and create / update kanbans!<br /> <strong>In order to upload, your file must be a .csv, and it must be named "kanban-upload.csv"</strong><br /> Thank you!<br />When you're ready to upload or update, just click the "import kanbans" button below!</p>
    <hr />
    <p>Here is an example table of how the .csv needs to be formatted:</p>

    <style>
        #knbn-example-table {
            width: 100%;
            background-color: #fff;
            box-shadow: rgba(0, 0, 0, .2) 2px 3px 5px;
            border-style: solid;
            border-width: 1px;
            border-color: lightgrey;
            border-radius: 4px;
            text-align: center;
        }
    </style>

    <table id="knbn-example-table">
        <thead>
            <tr>
                <th>vendor</th>
                <th>itd_part_number</th>
                <th>location</th>
                <th>cell</th>
                <th>man_part_number</th>
                <th>description</th>
                <th>blue_qty</th>
                <th>red_qty</th>
                <th>freight_policy</th>
                <th>package_qty</th>
                <th>lead_time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>McMaster-Carr</td>
                <td>ITD7104</td>
                <td>Hardware</td>
                <td>H34</td>
                <td>9283K14</td>
                <td>1" Internal Poly Plug</td>
                <td>100</td>
                <td>100</td>
                <td>Fed Ex</td>
                <td>100</td>
                <td>2 Days</td>
            </tr>
        </tbody>
    </table>

    <hr />

    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('kanbanotron_settings_group'); ?>
        <?php do_settings_sections('kanbanotron_settings_group'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Upload your .csv</th>
                <td>
                    <input type="file" name="csv" />
                </td>
            </tr>
        </table>
        <input type="submit" value="import kanbans" />
    </form>
</div>

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
                'itd_part_number' => $data[1],
                'location' => $data[2],
                'cell' => $data[3],
                'man_part_number' => $data[4],
                'description' => $data[5],
                'blue_qty' => $data[6],
                'red_qty' => $data[7],
                'freight_policy' => $data[8],
                'package_qty' => $data[9],
                'lead_time' => $data[10]
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
                'post_title' => ucwords(str_replace(' ', '-', $all_data[$i]['vendor']) . '-' . str_replace(' ', '-', $all_data[$i]['description'])),
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'knbn_action',
                'meta_input' => array(
                    'kanban_information_part_number_group_part_number' => $all_data[$i]['itd_part_number'],
                    'kanban_information_description' => $all_data[$i]['description'],
                    'kanban_information_location_department_location' => $all_data[$i]['location'],
                    'kanban_information_location_department_cell' => $all_data[$i]['cell'],
                    'kanban_information_vendor' => $all_data[$i]['vendor'],
                    'kanban_information_part_number_group_vendor_part_number' => $all_data[$i]['man_part_number'],
                    'kanban_information_quantities_package_quantity' => $all_data[$i]['package_qty'],
                    'kanban_information_quantities_blue_bin_quantity' => $all_data[$i]['blue_qty'],
                    'kanban_information_quantities_red_bin_quantity' => $all_data[$i]['red_qty'],
                    'kanban_information_lead_time' => $converted_lead_time,
                    'external_product_url' => ''
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