<?php

$post_ids = json_decode($_GET['post_ids']);

// empty array to store uid's we need to download
$knbn_uid_to_dwnld = array();

// lets add all the uids to the previous array
foreach ($post_ids as $post_id) {
    $bulk_knbn_uid = get_post_meta($post_id, 'product_setup_knbn_uid', true);
    array_push($knbn_uid_to_dwnld, $bulk_knbn_uid);
}

echo var_dump($knbn_uid_to_dwnld);

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
</style>

<div class="knbn-lbl-grid-container">
    <div class="knbn-lbl">
        <div id="1l234978asgfd7olua34ifrlkagsdlcv7-qrcode" style="width:100px; height:100px; margin-top:15px;" onload="makeCode('1l234978asgfd7olua34ifrlkagsdlcv7')"></div>
    </div>
</div>



<script type="text/javascript">
    let qrcode;

    function makeCode(x) {
        let qrcode = new QRCode(document.getElementById(`${x}-qrcode`), {
            width: 100,
            height: 100
        });
        var elText = `http://internalweb/kanbanotron/?knbn_uid=${x}`;
        qrcode.makeCode(elText.value);
    }
</script>