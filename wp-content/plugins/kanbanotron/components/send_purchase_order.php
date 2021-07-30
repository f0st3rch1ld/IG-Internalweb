<?php

$active_po = $_GET['active_po'];
$vendor = $_GET['vndr'];

$order_data;

$order_data_to_send = array();


// Retreives order data from the kanbanotron database
include '../db/kanbanotron_connection.php';

$order_data_query = "SELECT order_data FROM Purchase_orders WHERE order_id='" . $active_po . "'";
$order_data_result = $conn->query($order_data_query);

while ($row = $order_data_result->fetch_assoc()) {
    $order_data = json_decode($row['order_data']);
}

// closes kanbanotron_connection
$conn->close();

include '../db/request.php';

// request reference

// $knbn_external_url;
// $knbn_dept_location;
// $knbn_dept_cell;
// $knbn_vendor;
// $knbn_part_number;
// $knbn_vendor_part_number;
// $knbn_description;
// $knbn_package_quantity;
// $knbn_reorder_quantity;
// $knbn_blue_bin_quantity;
// $knbn_red_bin_quantity;
// $knbn_lead_time;
// $knbn_notes;

// Queries wordpress database to check to see what vendor specific product belongs to.
function vendor_check($x)
{
    global $order_data_to_send;
    global $knbn_vendor;
    global $knbn_vendor_part_number;
    global $vendor;

    knbn_info_request($x);

    if ($knbn_vendor == $vendor) {
        array_push($order_data_to_send, $knbn_vendor_part_number);
    }
}

// Loops through all items in order data array pulled from database, and runs vendor_check function on them.
for ($i = 0; count($order_data) > $i; $i++) {
    vendor_check($order_data[$i]);
}

var_dump($order_data_to_send);

include '../db/qb_db/items_request.php';

// items_request reference

// $qbdb_ListID;
// $qbdb_FullName;
// $qbdb_TableName;
// $qbdb_BarCodeValue;

$qbdb_items_request_array = array();

for ($i = 0; count($order_data_to_send) > $i; $i++) {
    qbdb_item_request($order_data_to_send[$i]);
    $temp_array = array($qbdb_ListID, $qbdb_fullName, $qbdb_TableName, $qbdb_BarCodeValue);
    array_push($qbdb_items_request_array, $temp_array);
}

echo var_dump($qbdb_items_request_array);




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
 * 
 * 
 * We will use this table to add individual items to purchase orders
 * Table: purchaseorderlineret
 * --TxnLineID
 * --ItemRef_ListID
 * --ItemRef_FullName
 * --ManufacturerPartNumber
 * --Description
 * --Quantity
 * --Rate
 * --Amount
 * --ReceivedQuantity
 * --IsBilled
 * --IsManuallyClosed
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
 * --PARENT_IDKEY
 * --GroupPARENT_IDKEY
 * --SeqNum
 * --LSData
 * 
 * 
 * We will reference this table for the ListID of the items to add to the purchaseorderlineret table
 * Table: items
 * --ListID
 * --FullName
 * --TableName
 * --BarCodeValue
 * 
 * NOTE: May need to also reference itemservice or itemoninventory tables depending on how we use the items table. We would probably pull the same columns out of those tables as well.. unsure where all the item descriptions come from? straight from Quickbooks?
 * 
 * Table: vendor
 * --ListID
 * --Name
 * --isActive
 * --CompanyName
 * --FirstName
 * --MiddleNamer
 * --LastName
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
 */
