<?php

function retrieve_po_data()
{
    $purchaseorder_table_data_array = array();

    // QuickBooks Database Connection
    include 'qb_data_connection.php';

    $purchaseorder_request = "SELECT TxnID, TimeCreated, VendorRef_FullName, Memo FROM purchaseorder WHERE IsManuallyClosed='0'";
    $purchaseorder_request_result = $conn->query($purchaseorder_request);

    if ($purchaseorder_request_result->num_rows > 0) {
        while ($row = $purchaseorder_request_result->fetch_assoc()) {
            $temp_po_array = array(
                'TxnID' => $row['TxnID'],
                'TimeCreated' => $row['TimeCreated'],
                'VendorRef_FullName' => $row['VendorRef_FullName'],
                'Memo' => $row['Memo']
            );
            array_push($purchaseorder_table_data_array, $temp_po_array);
        }
    }

    echo var_dump($purchaseorder_table_data_array);

    $conn->close();
}
