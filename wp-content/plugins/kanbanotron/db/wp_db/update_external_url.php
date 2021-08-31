<?php

$knbn_uid = $_GET['knbn_uid'];
$ext_url = $_GET['ext_url'];

$retrieved_id;

// Connects to WP Database
include '../knbn_wp_connection.php';

// Retrieves Kanban Post ID from unique value located inside QR
$knbn_post_id = "SELECT post_id FROM wp_postmeta WHERE meta_value='" . $knbn_uid . "'";
$knbn_post_id_result = $conn->query($knbn_post_id);

while ($row = $knbn_post_id_result->fetch_assoc()) {
    $retrieved_id = $row['post_id'];
}

$knbn_does_url_exist = "SELECT meta_value FROM wp_postmeta WHERE post_id='$retrieved_id' AND meta_key='external_product_url'";
$knbn_does_url_exist_result = $conn->query($knbn_does_url_exist);

if ($knbn_does_url_exist_result->num_rows > 0) {
    $knbn_set_ext_url = "UPDATE wp_postmeta SET meta_value='$ext_url' WHERE meta_key='external_product_url' AND post_id='$retrieved_id'";

    if ($conn->query($knbn_set_ext_url) === TRUE) {
        echo "External URL updated";
    } else {
        echo "Error updating external URL: " . $conn->error;
    }
} else {
    $select_max_meta_id = "SELECT MAX(meta_id) FROM wp_postmeta";
    $select_max_meta_result = $conn->query($select_max_meta_id);
    $new_max_meta;

    echo var_dump($select_max_meta_result->fetch_assoc());
    echo 'max_meta: ' . $new_max_meta;
    
    while ($row = $select_max_meta_result->fetch_assoc()) {
        $new_max_meta = intval($row['MAX(meta_id)']);
        $new_max_meta++;
    }

    $knbn_set_ext_url = "INSERT INTO wp_postmeta (meta_id, post_id, meta_key, meta_value) VALUES ($new_max_meta, $retrieved_id, 'external_product_url', $ext_url)";


}

// Closes connection to WP Database
$conn->close();