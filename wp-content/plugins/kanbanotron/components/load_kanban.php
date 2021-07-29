<?php
if (array_key_exists('xhttp', $_REQUEST)) {
    // grabs kanban unique id from request
    $knbn_uid = $_REQUEST['knbn_uid'];

    // includes
    include '../db/knbn_wp_connection.php';
    include '../db/request.php';
} else {
    // includes
    include plugin_dir_path(__FILE__) . '../db/knbn_wp_connection.php';
    include plugin_dir_path(__FILE__) . '../db/request.php';
}

knbn_info_request($knbn_uid); ?>

<!-- kanban search container -->
<div id="knbn_uid-form">
    <input type="text" id="knbn_uid" placeholder="Load a new kanban (Scan QR Code)" onchange="loadKanban(this.value)" />
</div>
<!-- /kanban search container -->

<h4>Kanban Information</h4>
<table id="kanban-table">
    <tbody>
        <?php if ($knbn_part_number) : ?>
            <tr>
                <th>Part Number</th>
                <td><?php echo $knbn_part_number; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_vendor) : ?><tr>
                <th>Vendor</th>
                <td><?php echo $knbn_vendor; ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>Vendor Part Number</th>
            <td><?php echo $knbn_vendor_part_number; ?></td>
        </tr>
        <?php if ($knbn_description) : ?>
            <tr>
                <th>Description</th>
                <td><?php echo $knbn_description; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_package_quantity) : ?>
            <tr>
                <th>Package Quantity</th>
                <td><?php echo $knbn_package_quantity; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_reorder_quantity) : ?>
            <tr>
                <th>Reorder Quantity</th>
                <td><?php echo $knbn_reorder_quantity; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_blue_bin_quantity) : ?>
            <tr>
                <th>Blue Quantity</th>
                <td><?php echo $knbn_blue_bin_quantity; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_red_bin_quantity) : ?>
            <tr>
                <th>Red Quantity</th>
                <td><?php echo $knbn_red_bin_quantity; ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>Lead Time</th>
            <td>
                <?php if ($knbn_lead_time > 1) {
                    echo $knbn_lead_time . " Days";
                } else {
                    echo $knbn_lead_time . "Day";
                } ?>
            </td>
        </tr>
        <?php if ($knbn_lead_time) : ?>
            <tr>
                <th>ETA</th>
                <td>
                    <?php
                    $date = date('m/d/Y');
                    echo date('m/d/Y', strtotime($date. ' +' . $knbn_lead_time . ' days'));
                    ?>
                </td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_dept_location) : ?>
            <tr>
                <th>Location</th>
                <td><?php echo $knbn_dept_location; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_dept_cell) : ?>
            <tr>
                <th>Cell</th>
                <td><?php echo $knbn_dept_cell; ?></td>
            </tr>
        <?php endif; ?>
        <?php if ($knbn_notes) : ?>
            <tr>
                <th>Notes</th>
                <td><?php echo $knbn_notes; ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="knbn-order-form-container">
    <?php if ($knbn_external_url) : ?>
        <a href="<?php echo $knbn_external_url; ?>" target="_blank">Click to order from <?php echo $knbn_vendor; ?> <i class="far fa-plus-square"></i></a>
    <?php else : ?>
        <button onclick="addToPO('<?php echo $knbn_uid; ?>', document.getElementById('order-selection').value)">Add to PO <i class="far fa-plus-square"></i></button>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>