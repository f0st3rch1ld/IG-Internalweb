<?php

include plugin_dir_path(__FILE__) . '../db/qb_db/purchaseorder_request.php';
retrieve_po_data();

// purchaseorder_request referance

// --$purchaseorder_table_data_array;
// ----TxnID
// ----TimeCreated
// ----VendorRef_FullName
// ----Memo

// --$purchaseorderlineret_table_data_array;
// ----ItemRef_FullName
// ----Description
// ----Quantity
// ----PARENT_IDKEY

// order_txnid_array array holds which vendors have already been processed inside this loop
$order_txnid_array = array();

?>

<?php
// Loops through all purchaseorder data, and groups / pushes vendors and vendor ids to array
for ($i = 0; count($purchaseorder_table_data_array) > $i; $i++) {
    if (!array_key_exists($purchaseorder_table_data_array[$i]['VendorRef_FullName'], $order_txnid_array)) {
        $order_txnid_array[$purchaseorder_table_data_array[$i]['VendorRef_FullName']] = $purchaseorder_table_data_array[$i]['TxnID'];
    } else {
        array_push($order_txnid_array[$purchaseorder_table_data_array[$i]['VendorRef_FullName']], $purchaseorder_table_data_array[$i]['TxnID']);
    }
}
?>

<?php echo print_r($order_txnid_array); ?>

<?php for ($i = 0; count($order_txnid_array) > $i; $i++) : ?>
    <!-- Generated PO Table -->
    <div class="purchase-order-container">
        <div class="po-title-container">
            <h5 class="vendor-name">
                <?php echo key($order_txnid_array[$i]); ?>
            </h5>
        </div>
        <table class="tablesorter">
            <thead>
                <tr>
                    <th>PN</th>
                    <th>QTY</th>
                    <th>Date Ordered</th>
                    <th>PO</th>
                    <th>ETA</th>
                </tr>
            </thead>
            <tbody>

                <?php for ($y = 0; count($purchaseorder_table_data_array) > $y; $y++) : ?>
                    <?php if ($order_txnid_array[$i][$y] == $purchaseorder_table_data_array[$y]['TxnID']) : ?>
                        <tr>
                            <td class="tooltip"><?php echo $purchaseorderlineret_table_data_array[$y]['ItemRef_FullName']; ?>
                                <p class="tooltiptext"><?php echo $purchaseorderlineret_table_data_array[$y]['Description']; ?></p>
                            </td>
                            <td><?php echo $purchaseorderlineret_table_data_array[$y]['Quantity']; ?></td>
                            <td><?php echo $purchaseorder_table_data_array[$i]['TimeCreated']; ?></td>
                            <td><?php echo $purchaseorder_table_data_array[$i]['Memo']; ?></td>
                            <td>ETA</td>
                        </tr>
                    <?php endif; ?>
                <?php endfor; ?>

            </tbody>
        </table>
    </div>
    <!-- /Generated PO Table -->
<?php endfor; ?>