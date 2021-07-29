<?php

if (array_key_exists('sub', $_GET)) {
    // One switch case to rule them all.
    switch ($_GET['sub']) {
        case 'list':
            include 'list.php';
            break;
        case 'order':
            include 'order-form.php';
            break;
        case 'update':
            include 'update.php';
            break;
        case 'tracking':
            include 'tracking.php';
            break;
        case 'remove':
            include 'remove-label.php';
            break;
        case 'edit':
            include 'edit-label.php';
            break;
        case 'mail':
            include 'mail-label.php';
            break;
        case 'approval';
            include 'approval.php';
            break;
        case 'user_update':
            include 'user-update.php';
            break;
        default:
            include 'list.php';
    }
} else {
    include 'list.php';
}

?>

<!-- Load Scripts -->
<script src="<?php echo plugin_dir_url(__DIR__) . 'label-o-matic/js/main.js'; ?>"></script>