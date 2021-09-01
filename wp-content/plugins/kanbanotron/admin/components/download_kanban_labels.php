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
        display: grid;
        grid-template-columns: auto auto auto auto auto;
        justify-content: space-evenly;
        align-content: center;
    }

    .knbn-lbl {
        background-color: cyan;
        width: 100px;
        height: 100px;
    }
</style>

<div class="knbn-lbl-grid-container">
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
    <div class="knbn-lbl"></div>
</div>