<?php

$qbdb_vendor_ListID;
$qbdb_vendor_Name;
$qbdb_vendor_isActive;
$qbdb_vendor_CompanyName;
$qbdb_vendor_FirstName;
$qbdb_vendor_MiddleNamer;
$qbdb_vendor_LastName;
$qbdb_vendor_VendorAddress_Addr1;
$qbdb_vendor_VendorAddress_Addr2;
$qbdb_vendor_VendorAddress_Addr3;
$qbdb_vendor_VendorAddress_Addr4;
$qbdb_vendor_VendorAddress_Addr5;
$qbdb_vendor_VendorAddress_City;
$qbdb_vendor_VendorAddress_State;
$qbdb_vendor_VendorAddress_PostalCode;
$qbdb_vendor_VendorAddress_Country;
$qbdb_vendor_VendorAddress_Note;
$qbdb_vendor_ShipAddress_Addr1;
$qbdb_vendor_ShipAddress_Addr2;
$qbdb_vendor_ShipAddress_Addr3;
$qbdb_vendor_ShipAddress_Addr4;
$qbdb_vendor_ShipAddress_Addr5;
$qbdb_vendor_ShipAddress_City;
$qbdb_vendor_ShipAddress_State;
$qbdb_vendor_ShipAddress_PostalCode;
$qbdb_vendor_ShipAddress_Country;
$qbdb_vendor_ShipAddress_Note;
$qbdb_vendor_TermsRef_ListID;
$qbdb_vendor_TermsRef_FullName;

function qbdb_vendor_request()
{

    // Quickbooks database connection
    include 'qb_data_connection.php';
    $conn->close();
};
