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

// vendors array holds which vendors have already been processed inside this loop
$vendors = array();

?>

<?php for ($i = 0; count($purchaseorder_table_data_array) > $i; $i++) : ?>

    <?php if (!in_array($purchaseorder_table_data_array[$i]['VendorRef_FullName'], $vendors)) : ?>
        <?php
        $temp_array = array(
            $purchaseorder_table_data_array[$i]['VendorRef_FullName'],
            $purchaseorder_table_data_array[$i]['TxnID']
        );
        array_push($vendors, $temp_array);
        ?>

        <!-- Generated PO Table -->
        <div class="purchase-order-container">
            <div class="po-title-container">
                <h5 class="vendor-name">
                    <?php echo $purchaseorder_table_data_array[$i]['VendorRef_FullName']; ?>
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

                    <?php for ($y = 0; count($purchaseorderlineret_table_data_array) > $y; $y++) : ?>
                        <?php if ($purchaseorderlineret_table_data_array[$y]['PARENT_IDKEY'] == $purchaseorder_table_data_array[$i]['TxnID']) : ?>
                            <tr>
                                <td class="tooltip"><?php echo $purchaseorderlineret_table_data_array[$y]['ItemRef_FullName']; ?>
                                    <p class="tooltiptext"><?php echo $purchaseorderlineret_table_data_array[$y]['Description']; ?></p>
                                </td>
                                <td><?php echo $purchaseorderlineret_table_data_array[$y]['Quantity']; ?></td>
                                <td><?php echo $purchaesorder_table_data_array[$i]['TimeCreated']; ?></td>
                                <td><?php echo $purchaesorder_table_data_array[$i]['Memo']; ?></td>
                                <td>ETA</td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor; ?>

                </tbody>
            </table>
        </div>
        <!-- /Generated PO Table -->

    <?php endif; ?>

<?php endfor; ?>