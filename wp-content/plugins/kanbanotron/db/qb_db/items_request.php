<?php

$qbdb_ListID;
$qbdb_FullName;
$qbdb_TableName;
$qbdb_BarCodeValue;

function qbdb_item_request($knbn_name)
{
    // Quickbooks database connection
    include '../db/qb_data_connection.php';

    // globals - so we can set their values
    global $qbdb_ListID;
    global $qbdb_FullName;
    global $qbdb_TableName;
    global $qbdb_BarCodeValue;

    $qbdb_data_request = "SELECT ListID, FullName, TableName, BarCodeValue FROM items WHERE FullName='" . $knbn_name . "'";
    $qbdb_data_result = $conn->query($qbdb_data_request);

    if ($qbdb_data_result->num_rows > 0) {
        while ($row = $qbdb_data_result->fetch_assoc()) {
            $qbdb_ListID = $row['ListID'];
            $qbdb_FullName = $row['FullName'];
            $qbdb_TableName = $row['TableName'];
            $qbdb_BarCodeValue = $row['BarCodeValue'];
        }
    }

    // Closes Quickbooks database connection
    $conn->close();
}
