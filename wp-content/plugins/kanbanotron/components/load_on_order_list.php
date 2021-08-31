<?php

if (array_key_exists('xhttp', $_REQUEST)) {
    // includes
    include '../db/qb_db/purchaseorder_request.php';
} else {
    // includes
    include plugin_dir_path(__FILE__) . '../db/qb_db/purchaseorder_request.php';
}

retrieve_po_data();

// purchaseorder_request referance

// --$purchaseorder_table_data_array;
// ----TxnID
// ----TimeCreated
// ----VendorRef_FullName
// ----Memo
// ----IsFullyReceived

// --$purchaseorderlineret_table_data_array;
// ----ItemRef_FullName
// ----Description
// ----Quantity
// ----PARENT_IDKEY

// order_txnid_array array holds which vendors have already been processed inside this loop
$order_txnid_array = array();

// Loops through all purchaseorder data, and groups / pushes vendors and vendor ids to array
for ($i = 0; count($purchaseorder_table_data_array) > $i; $i++) {
    if (!array_key_exists($purchaseorder_table_data_array[$i]['VendorRef_FullName'], $order_txnid_array)) {
        $vendorName = $purchaseorder_table_data_array[$i]['VendorRef_FullName'];
        $order_txnid_array[$vendorName] = array($purchaseorder_table_data_array[$i]['TxnID']);
    } else {
        array_push($order_txnid_array[$purchaseorder_table_data_array[$i]['VendorRef_FullName']], $purchaseorder_table_data_array[$i]['TxnID']);
    }
}

ksort($order_txnid_array);

echo var_dump($order_txnid_array);

?>

<?php foreach ($order_txnid_array as $key => $value) : ?>
    <!-- Generated PO Table -->
    <div class="purchase-order-container">
        <div class="po-title-container">
            <h5 class="vendor-name">
                <?php echo $key; ?>
            </h5>
        </div>
        <table class="tablesorter">
            <thead>
                <tr>
                    <th>PN</th>
                    <th>Description</th>
                    <th>QTY</th>
                    <th>Date Ordered</th>
                    <th>PO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($value as $ind_purchase_order) : ?>
                    <?php foreach ($purchaseorderlineret_table_data_array as $ind_products) : ?>
                        <?php if ($ind_purchase_order == $ind_products['PARENT_IDKEY']) : ?>
                            <tr>
                                <td class="full-name"><?php echo $ind_products['ItemRef_FullName']; ?></td>
                                <td class="description"><?php echo $ind_products['Description']; ?></td>
                                <td class="quantity"><?php echo number_format($ind_products['Quantity'], 0); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- /Generated PO Table -->
<?php endforeach; ?>