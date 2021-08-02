<?php

/**
 * 
 * Updated purchaseorder table rows need operation column set to 'add' in order to be pushed back to the QBD database.
 * 
 * Needed tables & columns from QB Database to create purchase orders
 * Table: purchaseorder
 * --TxnID
 * --EditSequence
 * --TxnNumber
 * --VendorRef_ListID
 * --VendorRef_FullName (Optional?)
 * --TemplateRef_ListID
 * --TemplateRef_Fullname (Optional?)
 * --RefNumber
 * --VendorAddress_Addr1 (Optional?)
 * --VendorAddress_Addr2 (Optional?)
 * --VendorAddress_Addr3 (Optional?)
 * --VendorAddress_Addr4 (Optional?)
 * --VendorAddress_Addr5 (Optional?)
 * --VendorAddress_City (Optional?)
 * --VendorAddress_State (Optional?)
 * --VendorAddress_PostalCode (Optional?)
 * --VendorAddress_Country (Optional?)
 * --VendorAddress_Note (Optional?)
 * --ShipAddress_Addr1 (Optional?)
 * --ShipAddress_Addr2 (Optional?)
 * --ShipAddress_Addr3 (Optional?)
 * --ShipAddress_Addr4 (Optional?)
 * --ShipAddress_Addr5 (Optional?)
 * --ShipAddress_City (Optional?)
 * --ShipAddress_State (Optional?)
 * --ShipAddress_PostalCode (Optional?)
 * --ShipAddress_Country (Optional?)
 * --ShipAddress_Note (Optional?)
 * --TermsRef_ListID (Optional?)
 * --TermsRef_FullName (Optional?)
 * --DueDate
 * --ExpectedDate
 * --TotalAmount
 * --IsToBePrinted
 * --IsToBeEmailed
 * --IsManuallyClosed
 * --IsFullyReceived
 * --ExternalGUID
 * --CustomField1
 * --CustomField2
 * --CustomField3
 * --CustomField4
 * --CustomField5
 * --CustomField6
 * --CustomField7
 * --CustomField8
 * --CustomField9
 * --CustomField10
 * --CustomField11
 * --CustomField12
 * --CustomField13
 * --CustomField14
 * --CustomField15
 * --UserData
 * --Operation
 * --LSData
 */

//$purchaseorder_Table_data = array();

function purchaseorder_update($qbdb_items_request_array)
{

    //global $purchaseorder_table_data;

    // Quickbooks database connection
    include 'qb_data_connection.php';

    $purchaseorder_table_query = "SELECT TxnID, TxnNumber, RefNumber FROM purchaseorder";
    $purchaseorder_table_query_result = $conn->query($purchaseorder_table_query);

    if ($purchaseorder_table_query_result->num_rows > 0) {
        while ($row = $purchaseorder_table_query_result->fetch_assoc()) {
            echo $row['TxnID'] . ' ' . $row['TxnNumber'] . ' ' . $row['RefNumber'];
        }
    }

    for ($i = 0; count($qbdb_items_request_array) > $i; $i++) {

        // Console Logs Content
        foreach ($qbdb_items_request_array[$i] as $key => $value) {
            if (!$value) {
                echo $key . ' : NULL ; ';
            } else {
                echo $key . ' : ' . $value . ' ; ';
            }
        }

        //$purchaseorder_table_insertion = "INSERT INTO purchaseorder";

    }

    // Closes Quickbooks database connection
    $conn->close();
}
