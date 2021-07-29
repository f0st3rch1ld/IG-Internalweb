<?php

include 'db-connect.php';

$order_number = $_GET['order_number'];
$previous_page = $_GET['prev'];
$label_index = $_GET['label_index'];
$new_label_data = $_GET;

// Gets edited label data from order page
$decoded_label_data = array();
$added_labels = array();

foreach ($new_label_data as $key => $value) {
    if ($key != 'sub' && $key != 'prev' && $key != 'order_number' && $key != 'label_index') {
        $decoded_label_data[str_replace('\\', '', $key)] = str_replace('\\', '', $value);
    }
    foreach ($decoded_label_data as $key => $value) {
        $added_labels[$conn->real_escape_string($key)] = $conn->real_escape_string($value);
    }
}


// pulls label data from database
$label_data;
$label_data_query = "SELECT label_data FROM orders WHERE order_number='" . $order_number . "'";
$label_data_result = mysqli_query($conn, $label_data_query);

while ($ld_row = $label_data_result->fetch_assoc()) {
    $label_data = $ld_row["label_data"];
}


// Decodes pulled json data, and pushes data to a new workable array
$decoded_row = json_decode($label_data);
$prepared_array = array();

for ($i = 0; count($decoded_row) > $i; $i++) {
    $temp_array = array();
    foreach ($decoded_row[$i] as $key => $value) {
        $temp_array[$conn->real_escape_string($key)] = $conn->real_escape_string($value);
    }
    array_push($prepared_array, $temp_array);
}



// Splices New Label in Place of Old Label
$new_nested_array = array();
array_push($new_nested_array, $added_labels);
array_splice($prepared_array, $label_index, 1, $new_nested_array);

$new_array = json_encode($prepared_array);

$update_order = "UPDATE orders SET label_data= '$new_array' WHERE order_number='" . $order_number . "'";

if ($conn->query($update_order) === TRUE) {
    echo "Label Updated Successfully<br />";
} else {
    echo "Error: " . $update_order . "<br />" . $conn->error;
}

$conn->close();

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.location.href = "/label-o-matic/?sub=order&<?php echo 'order_number=' . $order_number; ?>"
    }, false);
</script>