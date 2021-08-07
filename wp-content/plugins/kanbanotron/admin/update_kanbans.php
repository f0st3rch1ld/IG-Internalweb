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

    label {
        margin: 5px;
    }

    .mku-form-container {
        flex-direction: row !important;
        flex-wrap: wrap !important;
    }

    .mku-form-container label {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-content: center;
        width: 100%;
        min-width: 215px;
        max-width: 315px;
    }

    .knbn-admin-tab {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 20px !important;
        width: auto !important;
        padding: 10px;
        font-weight: bold;
        border-style: solid;
        border-color: lightgrey;
        border-width: 0px 1px 1px 1px;
        border-radius: 0px 0px 5px 5px;
        cursor: pointer;
        margin: 2px !important;
    }

    .knbn-admin-tab:hover,
    .knbn-admin-tab.active {
        border-color: #2271b1;
        background-color: #2271b1;
        color: #fff;
    }

    .knbn-admin-tab h4 {
        margin: none;
    }
</style>

<div class="update-kanbans-app-container">
    <div class="inner-container">
        <div>
            <h1 style="color:#2271b1;">Kanbanotron - Update Kanbans</h1>
        </div>

        <hr style="margin:0px" />



        <div style="flex-direction:row; flex-wrap:wrap; justify-content:flex-start; margin:0px">
            <div class="knbn-admin-tab active" id="knbn-auto-sync">
                <h4>QuickBooks Sync</h4>
            </div>
            <div class="knbn-admin-tab" id="knbn-csv-update">
                <h4>CSV Update</h4>
            </div>
        </div>

        <!-- qb sync container -->
        <div id="knbn-qb-sync-container" style="display:flex;">
            <div>
                <h3>QuickBooks Sync</h3>
                <p>Use the QuickBooks Sync if you would like to sync/update kanbans inside the database with new information straight to and from QuickBooks. Kanbans generated using the Kanbanotron will be sent directly to the QB database, and any records changed inside QuickBooks will be updated inside the Kanbanotron database.</p>
            </div>

            <!-- <div style="flex-direction:row;">
                <label>
                    <input type="radio" name="sync-type" value="Manual Sync" checked="checked" />
                    Manual Sync
                </label>
                <label>
                    <input type="radio" name="sync-type" value="Automatic Sync" />
                    Automatic Sync
                </label>
            </div> -->

            <!-- <div>
                <label>
                    <input type="number" name="sync-frequency" />
                    Sync Frequency (In Minutes)
                </label>
            </div> -->

            <div id="sync-databases">
                <button>Sync Databases</button>
            </div>

            <!-- <div id="auto-sync-databases">
                <button>Save Changes</button>
            </div> -->
        </div>
        <!-- /qb sync container -->

        <!-- csv update container -->
        <div id="knbn-csv-update-container" style="display:none">
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
                <?php settings_fields('kanbanotron_settings_group');
                ?>
                <?php do_settings_sections('kanbanotron_settings_group');
                ?>
                Upload your .csv
                <input type="file" name="csv" />
                <input type="submit" value="import kanbans" />
            </form>
        </div>
        <!-- /csv update container -->

        <hr />

        <div>
            <h3>Manual Kanban Update</h3>
            <p>If you need to manually update a kanbans info, or add a new kanban, you can do so here. This will pull a list of all the kanbans currently synced between QuickBooks & Kanbanotron. You can select which kanban you would like to edit, or you can create a new kanban if you can't find the one you're trying to work on. After you Update the databases, changes made will automatically be synced with quickbooks. No more importation!</p>
        </div>

        <div class="mku-form-container">
            <label>
                Select a kanban to edit - Or add a new kanban
                <select id="kanban-selection">
                    <!-- Default Option -->
                    <option value selected></option>

                    <!-- Add New Option -->
                    <optgroup label="Can't find your kanban? Add a new kanban.">
                        <option value="add-new-knbn">Add a New Kanban</option>
                    </optgroup>

                    <!-- Generated Kanbans List -->
                    <optgroup label="Currently Available Kanbans">
                        <option>Option 1</option>
                        <option>Option 2</option>
                        <option>Option 3</option>
                        <option>Option 4</option>
                    </optgroup>

                </select>
            </label>
        </div>

        <div class="mku-form-container">
            <label>Vendor
                <input type="text" name="vendor" id="vendor" placeholder="Vendor" />
            </label>
            <label>ITD Part Number
                <input type="text" name="itd_part_number" id="itd_part_number" placeholder="ITD Part Number" />
            </label>
            <label>Location
                <input type="text" name="Location" id="Location" placeholder="Location" />
            </label>
            <label>Manufacturer's Part Number
                <input type="text" name="man_part_number" id="man_part_number" placeholder="Manufacturer's Part Number" />
            </label>
            <label>Description
                <input type="text" name="description" id="description" placeholder="Description" />
            </label>
            <label>Kanban Quantities
                <input type="text" name="knbn_qty" id="knbn_qty" placeholder="Kanban Quantities (ex. 'blue'/'red', 100/100)" />
            </label>
            <label>Freight Policy
                <input type="text" name="freight_policy" id="freight_policy" placeholder="Freight Policy" />
            </label>
            <label>Package Quantity
                <input type="text" name="package_qty" id="package_qty" placeholder="Package Quantity" />
            </label>
            <label>Minimum Reorder Quantity
                <input type="text" name="min_reorder_qty" id="min_reorder_qty" placeholder="Minimum Reorder Quantity" />
            </label>
            <label>Lead Time
                <input type="text" name="lead_time" id="lead_time" placeholder="Lead Time" />
            </label>
        </div>

        <div id="sync-databases">
            <button>Update Kanban</button>
        </div>
    </div>
</div>

<script src="js/knbn_admin.js"></script>

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