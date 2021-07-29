<?php

include 'db-connect.php';

$order_number = $_GET['order_number'];
$date_started = $_GET['date_started'];
$project_name = $_GET['project_name'];
$project_name = $conn->real_escape_string($project_name);
$purchase_order = $_GET['purchase_order'];
$new_label_data = $_GET;
$user_id = $current_user->ID;
$tracking = $_GET['tracking'];
$requester_dept = $_GET['requester_dept'];

// Checks order number against database
$order_number_check = "SELECT order_number FROM orders WHERE order_number='" . $order_number . "'";
$result = $conn->query($order_number_check);


$decoded_label_data = array();
$added_labels = array();

if (array_key_exists('label_data', $_GET)) {
    // Added labels array generation
    foreach ($new_label_data as $key => $value) {
        if ($key != 'sub' && $key != 'order_number' && $key != 'date_started' && $key != 'tracking' && $key != 'project_name' && $key != 'purchase_order' && $key != 'first_name' && $key != 'last_name' && $key != 'requester_dept') {
            $decoded_label_data[str_replace('\\', '', $key)] = str_replace('\\', '', $value);
        }
    }

    foreach ($decoded_label_data as $key => $value) {
        $added_labels[$conn->real_escape_string($key)] = $conn->real_escape_string($value);
    }
}

// PHP SQL request from server
$label_data;
$label_data_query = "SELECT label_data FROM orders WHERE order_number='" . $order_number . "'";
$label_data_result = mysqli_query($conn, $label_data_query);

while ($ld_row = $label_data_result->fetch_assoc()) {
    $label_data = $ld_row["label_data"];
}

// Checks to see if any current label data was found, and makes a decision
if ($result->num_rows > 0 && $label_data != '[]' && array_key_exists('label_data', $_GET)) {

    // If the order was found, and there is label data

    $decoded_row = json_decode($label_data);
    $prepared_array = array();

    for ($i = 0; count($decoded_row) > $i; $i++) {
        $temp_array = array();
        foreach ($decoded_row[$i] as $key => $value) {
            $temp_array[$conn->real_escape_string($key)] = $conn->real_escape_string($value);
        }
        array_push($prepared_array, $temp_array);
    }

    array_push($prepared_array, $added_labels);
    $new_array = json_encode($prepared_array);

    $update_order = "UPDATE orders SET project_name= '$project_name', requester_department='$requester_dept', purchase_order='$purchase_order', label_data= '$new_array', tracking='$tracking' WHERE order_number='" . $order_number . "'";

    if ($conn->query($update_order) === TRUE) {
        echo "Existing record updated successfully<br>";
    } else {
        echo "Error: " . $update_order . "<br>" . $conn->error;
    }
} elseif ($result->num_rows > 0 && ($label_data == '[]' || !array_key_exists('label_data', $_GET))) {

    // If the order was found, and there wasn't any label data

    if (array_key_exists('label_data', $_GET)) {
        $added_labels_enc = json_encode(array($added_labels));

        $add_labels = "UPDATE orders SET label_data= '$added_labels_enc' WHERE order_number='" . $order_number . "'";

        if ($conn->query($add_labels) === TRUE) {
            echo "Labels added to existing record successfully<br>";
        } else {
            echo "Error: " . $add_labels . "<br>" . $conn->error;
        }
    }

    $update_order = "UPDATE orders SET project_name= '$project_name', requester_department='$requester_dept', purchase_order='$purchase_order', tracking='$tracking' WHERE order_number='" . $order_number . "'";

    if ($conn->query($update_order) === TRUE) {
        echo "Existing record updated successfully<br>";
    } else {
        echo "Error: " . $update_order . "<br>" . $conn->error;
    }
} else {

    // If there was no order found, and it needs to be created

    $new_order = "INSERT INTO orders (order_number, date_started, project_name, requester_department, purchase_order, user_id, tracking) VALUES ('$order_number', '$date_started', '$project_name', '$requester_dept', '$purchase_order', '$user_id', '$tracking')";

    if ($conn->query($new_order) === TRUE) {
        echo "New record created successfully<br>";
    } else {
        echo "Error: " . $new_order . "<br>" . $conn->error;
    }

    if (array_key_exists('label_data', $_GET)) {
        $added_labels_enc = json_encode(array($added_labels));

        $update_order = "UPDATE orders SET label_data= '$added_labels_enc' WHERE order_number='" . $order_number . "'";

        if ($conn->query($update_order) === TRUE) {
            echo "Labels added to new record successfully<br>";
        } else {
            echo "Error: " . $update_order . "<br>" . $conn->error;
        }
    }
}

// terminates connection
$conn->close();

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.location.href = "/label-o-matic/?sub=order&<?php echo 'order_number=' . $order_number; ?>"
    }, false);
</script>