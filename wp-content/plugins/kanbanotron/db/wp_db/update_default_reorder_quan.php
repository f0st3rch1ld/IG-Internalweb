<?php 

$knbn_uid = $_GET['knbn_uid'];
$quan = $_GET['quan'];

$retreived_id;

// Connects to WP Database
include '../knbn_wp_connection.php';

// Retrieves Kanban Post ID from unique value located inside QR
$knbn_post_id = "SELECT post_id FROM wp_postmeta WHERE meta_value='" . $passed_knbn_uid . "'";
$knbn_post_id_result = $conn->query($knbn_post_id);

while ($row = $knbn_post_id_result->fetch_assoc()) {
    $retreived_id = $row['post_id'];
}

$knbn_set_reorder_quan = "UPDATE wp_postmeta SET meta_value=$quan WHERE meta_key='kanban_information_quantities_reorder_quantity' AND post_id=$retrieved_id";

if ($conn->query($knbn_set_reorder_quan) === TRUE) {
    echo "Default quantity updated";
} else {
    echo "Error setting default quantity: " . $conn->error;
}

// Closes connection to WP Database
$conn->close();