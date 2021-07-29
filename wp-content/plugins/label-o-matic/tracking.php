<?php

include 'db-connect.php';

$order_number = $_GET['order_number'];
$previous_page = $_GET['prev'];
$tracking = $_GET['tracking'];

$update_order = "UPDATE orders SET tracking= '$tracking' WHERE order_number='" . $order_number . "'";

if ($conn->query($update_order) === TRUE) {
    echo "Existing record updated successfully<br>";
} else {
    echo "Error: " . $update_order . "<br>" . $conn->error;
}

$conn->close();

?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.location.href = "/label-o-matic/?sub=user_update&order_number=<?php echo $order_number; ?>&prev=<?php echo $previous_page; ?>";
    }, false);
</script>