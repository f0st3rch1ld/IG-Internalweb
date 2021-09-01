<?php

$post_ids = json_decode($_GET['post_ids']);

// empty array to store uid's we need to download
$knbn_uid_to_dwnld = array();

// lets add all the uids to the previous array
foreach ($post_ids as $post_id) {
    $bulk_knbn_uid = get_post_meta($post_id, 'product_setup_knbn_uid', true);
    array_push($knbn_uid_to_dwnld, $bulk_knbn_uid);
}

?>

<style>
    .knbn-lbl-grid-container {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        align-content: center;
        width: 100%;
        height: auto;
    }

    .knbn-lbl {
        background-color: cyan;
        width: 450px;
        min-height: 100px;
        margin: 10px;
    }

    .blue-label,
    .red-label {
        height: calc(103px * 1.76);
        width: calc(234px * 1.76);
        border-radius: 25px;
        border-style: solid;
        border-width: 10px;
        border-color: #000;
    }

    .blue-label {
        background-color: blue;
    }

    .red-label {
        background-color: red;
    }
</style>

<!-- Kanban Label Grid Container -->
<div class="knbn-lbl-grid-container">
    <?php foreach ($knbn_uid_to_dwnld as $knbn_uid) : ?>
        <div class="knbn-lbl">
            <div class="blue-label"></div>
            <div class="red-label"></div>
            <div class="qrcode-container" id="<?php echo $knbn_uid; ?>-qrcode" style="width:100px; height:100px; margin-top:15px;" data="<?php echo $knbn_uid; ?>"></div>
        </div>
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