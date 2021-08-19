<?php

// Kanbanotron Update Kanbans Admin Page

?>

<div class="update-kanbans-app-container">
    <div class="inner-container">
        <div>
            <h1 style="color:#2271b1;">Kanbanotron - Update Kanbans</h1>
        </div>

        <hr style="margin:0px" />

        <?php if (!wp_is_mobile()) : ?>
            <!-- knbn settings tabs -->
            <div style="flex-direction:row; flex-wrap:wrap; justify-content:flex-start; margin:0px">
                <div class="knbn-admin-tab active" id="knbn-auto-sync">
                    <h4>QuickBooks Sync</h4>
                </div>
                <div class="knbn-admin-tab" id="knbn-csv-update">
                    <h4>CSV Update</h4>
                </div>
            </div>
            <!-- /knbn settings tabs -->
        <?php endif; ?>

        <!-- qb sync container -->
        <div class="knbn-admin-container" id="knbn-auto-sync-container" style="display:flex;">
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

        <?php if (!wp_is_mobile()) : ?>
            <!-- csv update container -->
            <div class="knbn-admin-container" id="knbn-csv-update-container" style="display:none">
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

                <form method="post" action="/wp-content/plugins/kanbanotron/admin/components/csv_update.php" enctype="multipart/form-data">
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
        <?php endif; ?>

        <hr />

        <!-- manual update container -->
        <div id="manual-knbn-update-container">
            <div>
                <h3>Manual Kanban Update</h3>
                <p>If you need to manually update a kanbans info, or add a new kanban, you can do so here. This will pull a list of all the kanbans currently synced between QuickBooks & Kanbanotron. You can select which kanban you would like to edit, or you can create a new kanban if you can't find the one you're trying to work on. After you Update the databases, changes made will automatically be synced with quickbooks. No more importation!</p>
            </div>

            <div class="mku-form-container">

                <form name="manual-knbn-update" action=""></form>

                <label style="width:100%; max-width:none;">
                    Select a kanban to edit - Or add a new kanban
                    <select id="kanban-selection" style="width:100%; max-width:none;">
                        <!-- Default Option -->
                        <option value selected></option>

                        <!-- Add New Option -->
                        <optgroup label="Can't find your kanban? Add a new kanban.">
                            <option value="add-new-knbn">Add a New Kanban</option>
                        </optgroup>

                        <!-- Generated Kanbans List -->
                        <optgroup label="Currently Available Kanbans">
                            <?php
                            // Connection to Wordpress Database
                            include plugin_dir_path(__FILE__) . '../db/knbn_wp_connection.php';

                            $wp_knbn_post_list = array();

                            $wp_knbn_posts_query = "SELECT ID, post_title FROM wp_posts WHERE post_status='publish' AND post_type='knbn_action'";
                            $wp_knbn_posts_query_result = $conn->query($wp_knbn_posts_query);

                            if ($wp_knbn_posts_query_result->num_rows > 0) {
                                while ($row = $wp_knbn_posts_query_result->fetch_assoc()) {
                                    $temp_array = array(
                                        'ID' => $row['ID'],
                                        'post_title' => $row['post_title']
                                    );
                                    array_push($wp_knbn_post_list, $temp_array);
                                }
                            } else {
                                echo 'Error retrieving data: ' . $conn->error;
                            }

                            // post_list test
                            //echo var_dump($wp_knbn_post_list);

                            asort($wp_knbn_post_list);

                            for ($i = 0; count($wp_knbn_post_list) > $i; $i++) : ?>
                                    <option value="<?php echo $wp_knbn_post_list[$i]['ID']; ?>"><?php echo $wp_knbn_post_list[$i]['post_title']; ?></option>
                            <?php endfor;
                            
                            // closes connection to Wordpress Database
                            $conn->close();
                            ?>
                        </optgroup>

                    </select>
                </label>
            </div>

            <div class="mku-form-container" id="mku-form-fields">
                <?php include plugin_dir_path(__FILE__) . '../admin/components/load_mku_form_fields.php'; ?>
            </div>

            <div id="sync-databases">
                <button>Update Kanban</button>
            </div>
        </div>
        <!-- /manual update container -->

    </div>
</div>