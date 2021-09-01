<?php

$post_ids = json_decode($_GET['post_ids']);

// empty array to store uid's we need to download
$knbn_uid_to_dwnld = array();

// lets add all the uids to the previous array
foreach ($post_ids as $post_id) {
    $bulk_knbn_uid = get_post_meta($post_id, 'product_setup_knbn_uid', true);
    array_push($knbn_uid_to_dwnld, $bulk_knbn_uid);
}

// Now we need to include the wp database connection
include '../../db/knbn_wp_connection.php';
include '../../db/request.php';

// request.php reference
// $knbn_external_yn;
// $knbn_order_method;
// $knbn_external_url;
// $knbn_location;
// $knbn_vendor;
// $knbn_part_number;
// $knbn_vendor_part_number;
// $knbn_description;
// $knbn_package_quantity;
// $knbn_reorder_quantity;
// $knbn_quantity;
// $knbn_lead_time;
// $knbn_notes;

?>

<!-- Kanban Label Grid Container -->
<div class="knbn-lbl-grid-container">
    <?php foreach ($knbn_uid_to_dwnld as $knbn_uid) : ?>
        <?php knbn_info_request($knbn_uid); ?>

        <!-- <?php echo $knbn_uid; ?> Kanban Label -->
        <div class="knbn-lbl">

            <!-- Blue Label -->
            <div class="blue-label">
                <div class="title-container">
                    <h4><?php echo $knbn_part_number; ?></h4>
                </div>
                <div class="lower-label-container"></div>
            </div>
            <!-- /Blue Label -->

            <!-- Red Label -->
            <div class="red-label">
                <div class="title-container">
                    <h4><?php echo $knbn_part_number; ?></h4>
                </div>
                <div class="lower-label-container"></div>
            </div>
            <!-- /Red Label -->

            <div class="qrcode-container" id="<?php echo $knbn_uid; ?>-qrcode" style="width:100px; height:100px; margin-top:15px;" data="<?php echo $knbn_uid; ?>"></div>

        </div>
        <!-- /<?php echo $knbn_uid; ?> Kanban Label -->

    <?php endforeach; ?>
</div>
<!-- /Kanban Label Grid Container -->

<script>
    window.addEventListener('load', function() {
        let allDaCodez = document.getElementsByClassName('qrcode-container');
        for (i = 0; allDaCodez.length > i; i++) {
            let uid = allDaCodez[i].getAttribute('data');
            let newCode = `http://internalweb/kanbanotron/?knbn_uid=${uid}`;
            let qrcode = new QRCode(document.getElementById(`${uid}-qrcode`), {
                width: 100,
                height: 100,
            });
            qrcode.makeCode(newCode);
        }
    });
</script>

<?php $conn->close(); ?>