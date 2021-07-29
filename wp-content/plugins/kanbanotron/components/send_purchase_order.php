<?php

$active_po = $_GET['active_po'];
$knbn_index = $_GET['knbn_index'];
$order_data;

include '../db/qb_data_connection.php';

$conn->close();