<?php
// On Order Overview
?>

<h3>On-Order Overview</h3>

<!-- On Order List Container -->
<div id="on-order-list-container">
    <?php include 'load_on_order_list.php'; ?>
</div>
<!-- /On Order List Container -->

<!-- Page Refresh Script -->
<script>
    document.onload = function() {
        setInterval(refreshOverview(), 10000);
    }
</script>
<!-- /Page Refresh Script -->