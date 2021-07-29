<?php

include 'db-connect.php';

$order_number = $_GET['order_number'];
$previous_page = $_GET['prev'];
$label_index = $_GET['label_index'];

$label_data = "SELECT label_data FROM orders WHERE order_number='" . $order_number . "'";
$label_data_result = mysqli_query($conn, $label_data);
$row = mysqli_fetch_array($label_data_result, MYSQLI_BOTH);
$decoded_row = json_decode($row[0]);

array_splice($decoded_row, $label_index, 1);

$new_array = json_encode($decoded_row);

$update_order = "UPDATE orders SET label_data= '$new_array' WHERE order_number='" . $order_number . "'";

if ($conn->query($update_order) === TRUE) {
    echo "Label removed successfully from order";
} else {
    echo "Error: " . $update_order . "<br>" . $conn->error;
}

$conn->close();

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.location.href = "/label-o-matic/?sub=<?php echo $previous_page; ?><?php if ($previous_page != 'list') { echo '&order_number=' . $order_number; }  ?>"
}, false);
</script>