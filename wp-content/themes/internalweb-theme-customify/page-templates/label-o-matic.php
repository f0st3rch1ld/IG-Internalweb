<?php

/*
Template Name: Label O Matic
*/

get_header();

?>

<!-- Label App Container -->
<div class="label-app-container">

    <?php

    $current_user = wp_get_current_user();

    if (!is_user_logged_in()) : ?>
        <p>In order to use this tool, you must first log into the website!</p>
        <hr />
        <p>If you don't have a company email, use your department name all lowercase for both the username and password! Example:</p>
        <p>Username: powder coating</p>
        <p>Password: powder coating</p>
        <hr />
        <?php wp_login_form(); ?>

    <?php else : ?>
        <?php include(LBLFP_PATH . 'main.php'); ?>
    <?php endif; ?>


    <?php

    get_footer();

    ?>