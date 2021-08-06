<?php
// Kanban Importer
?>

<style>
    .update-kanbans-app-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        margin-left: 20px
    }

    .update-kanbans-app-container .inner-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: auto;
        max-width: 950px;
        border-radius: 0px 0px 15px 15px;
        background-color: #fff;
    }

    .update-kanbans-app-container .inner-container div {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 90%;
        height: auto;
        margin: 20px;
    }


    #knbn-example-table {
        width: 100%;
        max-width: 1200px;
        background-color: #fff;
        box-shadow: rgba(0, 0, 0, .2) 2px 3px 5px;
        border-style: solid;
        border-width: 1px;
        border-color: lightgrey;
        border-radius: 4px;
        text-align: center;
    }

    #knbn-example-table thead {
        background-color: grey;
        height: 30px;
        color: #fff;
        border-style: none;
    }

    hr {
        border-color: lightgrey;
        border-style: dashed;
        border-width: 1px;
        width: 90%;
    }

    th {
        padding: 3px;
    }

    form {
        margin: 20px;
    }
</style>

<div class="update-kanbans-app-container">
    <div class="inner-container">
        <div>
            <h1>Kanbanotron - Update Kanbans</h1><br />
            <hr />
        </div>

        <div>
            <h3>CSV Update</h3>
            <p>
                Use the CSV updater when you want to update both kanbanotron, and quickbooks with new kanbans. It will read your .csv, importing it into both the kanbanotron database, as well as the quickbooks database, creating new records, or updating ones that already exist.
                <br />
                Here is an example table of how the .csv needs to be formatted:
            </p>

            <table id="knbn-example-table">
                <thead>
                    <tr>
                        <th>vendor</th>
                        <th>itd_part_number</th>
                        <th>location</th>
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

            <p><strong>In order to upload, your file must be a .csv, and it must be named "kanban-upload.csv"</strong></p>

            <form method="post" action="options.php" enctype="multipart/form-data">
                <?php settings_fields('kanbanotron_settings_group'); ?>
                <?php do_settings_sections('kanbanotron_settings_group'); ?>
                Upload your .csv
                <input type="file" name="csv" />
                <input type="submit" value="import kanbans" />
            </form>
        </div>

        <hr />

        <div>
            <h3>QuickBooks Sync</h3>
            <p>Use the QuickBooks Sync if you would like to sync/update kanbans inside the database with new information straight to and from QuickBooks. Kanbans generated using the Kanbanotron will be sent directly to the QB database, and any records changed inside QuickBooks will be updated inside the Kanbanotron database.</p>
        </div>

        <div>
            <label>
                <input type="radio" name="sync-type" value="Manual Sync"
                checked="checked" />
                Manual Sync
            </label>
            <label>
                <input type="radio" name="sync-type" value="Automatic Sync" />
                Automatic Sync
            </label>

        </div>

        <div>
            <button>Sync Databases</button>
        </div>

        <hr />

    </div>
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