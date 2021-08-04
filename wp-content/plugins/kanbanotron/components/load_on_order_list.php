<?php

include plugin_dir_path(__FILE__) . '../db/qb_db/purchaseorder_request.php';
retrieve_po_data();

// purchaseorder_request referance

?>

<!-- Generated PO Table -->
<div class="purchase-order-container">
    <div class="po-title-container">
        <h5 class="vendor-name">Vendor</h5>
    </div>
    <table class="tablesorter">
        <thead>
            <tr>
                <th>PN</th>
                <th>Vendor PN</th>
                <th>QTY</th>
                <th>Date Ordered</th>
                <th>PO</th>
                <th>ETA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tooltip">PN
                    <p class="tooltiptext">Description</p>
                </td>
                <td class="tooltip">Vendor PN
                    <p class="tooltiptext">Description</p>
                </td>
                <td>QTY</td>
                <td>Date Ordered</td>
                <td>PO</td>
                <td>ETA</td>
            </tr>
        </tbody>
    </table>
</div>
<!-- /Generated PO Table -->