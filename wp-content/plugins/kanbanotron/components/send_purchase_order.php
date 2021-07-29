<?php

$active_po = $_GET['active_po'];
$vendor = $_GET['vndr'];

echo $active_po . '<br />';
echo $vendor . '<br />';

$order_data;

$order_data_to_send = array();


// Retreives order data from the kanbanotron database
include '../db/kanbanotron_connection';

$order_data_query = "SELECT order_data FROM Purchase_orders WHERE order_id='" . $active_po . "'";
$order_data_result = $conn->query($order_data_query);

while ($row = $order_data_result->fetch_assoc()) {
    $order_data = json_decode($row['order_data']);
}

// closes kanbanotron_connection
$conn->close();


include '../db/request.php';

// request reference

// $knbn_external_url;
// $knbn_dept_location;
// $knbn_dept_cell;
// $knbn_vendor;
// $knbn_part_number;
// $knbn_vendor_part_number;
// $knbn_description;
// $knbn_package_quantity;
// $knbn_reorder_quantity;
// $knbn_blue_bin_quantity;
// $knbn_red_bin_quantity;
// $knbn_lead_time;
// $knbn_notes;

// Queries wordpress database to check to see what vendor specific product belongs to.
function vendor_check($x) {
    global $order_data_to_send;

    include '../db/knbn_wp_connection.php';
    knbn_info_request($x);

    if ($knbn_vendor == $vndr) {
        array_push($order_data_to_send, $x);
    }

    $conn->close();
}

// Loops through all items in order data array pulled from database, and runs vendor_check function on them.
for ($i = 0; count($order_data) > $i; $i++) {
    vendor_check($order_data[$i]);
}

// temporary check on order_data_to_send variable to see if the values got pushed correctly.
foreach ($order_data_to_send as $item) {
    echo 'Item UID: ' . $item . ' -> ' . $vendor . '<br />';
}


include '../db/qb_data_connection.php';

$conn->close();