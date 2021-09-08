<?php

include 'db-connect.php';

// scandir returns an array of forms located in the order-forms directory
$order_forms_list = scandir(plugin_dir_path(__FILE__) . '/order-forms');

$order_number;
$date_started;
$project_name = "";
$purchase_order;
$tracking;

// Checks to see if order number exists... if it doesn't, then assigns new order number and default project name.
if (array_key_exists('order_number', $_GET)) {

    $order_number = $_GET['order_number'];

    $all_order_data = "SELECT date_started, project_name, purchase_order, tracking FROM orders WHERE order_number='" . $order_number . "'";
    $all_order_data_result = $conn->query($all_order_data);

    if ($all_order_data_result->num_rows > 0) {
        while ($row = $all_order_data_result->fetch_assoc()) {
            $date_started = $row['date_started'];
            $project_name = str_replace('\\', '', $row['project_name']);
            $purchase_order = $row['purchase_order'];
            $tracking = $row['tracking'];
        }
    }
} else {

    // Generates a new 20 char random alphanumeric order number for the current order.
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $generated_number = '';
    for ($i = 0; $i < 20; $i++) {
        $generated_number .= $characters[rand(0, strlen($characters) - 1)];
    }

    $order_number = $generated_number;
    $date_started = date("Y-m-d");
    $tracking = 'my-orders';
}

?>

<!-- Label-o-Matic Container -->
<div class="label-o-matic-container">

    <!-- Label Forms Area -->

    <!-- Main Label Form -->
    <form id="labels-order" action="" method="get" return false;>
        <input type="hidden" name="sub" value="update" />
        <input type="hidden" name="order_number" value="<?php echo $order_number; ?>" />
        <input type="hidden" name="date_started" value="<?php echo $date_started; ?>" />
        <input type="hidden" name="tracking" value="<?php echo $tracking; ?>" />
    </form>

    <!-- Remove Labels Form -->
    <form id="remove-label" action="" method="get" return false;>
        <input type="hidden" name="sub" value="remove" />
        <input type="hidden" name="prev" value="order" />
        <input type="hidden" name="order_number" value="<?php echo $order_number; ?>" />
    </form>

    <!-- Edit Labels Form -->
    <form id="edit-label" action="" method="get" return false;>
        <input type="hidden" name="sub" value="edit" />
        <input type="hidden" name="prev" value="order" />
        <input type="hidden" name="order_number" value="<?php echo $order_number; ?>" />
    </form>

    <!-- Change Tracking Form -->
    <form id="change-tracking" action="" method="get" return false;>
        <input type="hidden" name="sub" value="tracking" />
        <input type="hidden" name="prev" value="order" />
        <input type="hidden" name="order_number" value="<?php echo $order_number; ?>" />
    </form>

    <!-- Approve Labels Form -->
    <form id="approve-labels" action="" method="get" return false;>
        <input type="hidden" name="sub" value="approval" />
        <input type="hidden" name="prev" value="order" />
        <input type="hidden" name="order_number" value="<?php echo $order_number; ?>" />
    </form>

    <!-- /Label Forms Area -->

    <!-- Approval Bar -->
    <div class="approval-area">
        <?php if ($tracking == "waiting-on-lead") : ?>
            <?php if ($current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'lead') : ?>
                <p>By clicking the "Approve Labels Order" button, you are effectively signing off on this order, and stating that it is 100% correct. After the marketing team recieves your approval, it should take around 4 business days to recieve your labels. Please check with marketing if you have any questions about your label order.</p>
            <?php endif; ?>
            <h3 class="needs-approved">Status: Needs Approval</h3>
            <?php if ($current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'lead') : ?>
                <input type="submit" form="approve-labels" value="Approve Labels Order" id="approve-labels-submit" />
            <?php endif; ?>
        <?php elseif ($tracking != "waiting-on-lead" && $tracking != "my-orders") : ?>
            <h3 class="approved">Status: Lead Approved</h3>
        <?php elseif ($tracking == "my-orders") : ?>
            <h3 class="not-sent">Status: New Order</h3>
        <?php endif; ?>
    </div>
    <!-- /Approval Bar -->

    <!-- Tool Bar -->

    <?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>

    <div class="tool-bar">
        <div>
            <input type="submit" form="labels-order" value="Save Label Order" id="save-label-order" />
            <a href="/label-o-matic/?sub=order">Start a new Label Order</a>
            <a onclick="copyShareUrl()">Share Label Order</a>
            <input type="text" value="<?php echo $actual_link; ?>" id="share-order-url" />
        </div>

        <a href="/label-o-matic">
            < Back to My Orders</a>
    </div>
    <!-- /Tool Bar -->


    <?php
    $tabs = array(
        'my-orders',
        'waiting-on-lead',
        'lead-approved',
        'ordered-labels',
        'received-labels',
        'delivered-labels'
    );
    ?>
    <div class="tracking-container" <?php if (current_user_can('editor') || current_user_can('administrator')) : ?><?php else : ?>style="display:none;" <?php endif; ?>>
        <select name="tracking" form='change-tracking'>
            <?php foreach ($tabs as $option) : ?>
                <option value="<?php echo $option; ?>" <?php if ($option == $tracking) : ?>selected<?php endif; ?>><?php echo $option ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" form="change-tracking" value="Update Tracking" id="change-tracking-submit" />
    </div>


    <!-- Order Form -->
    <div class="column form-area">

        <!-- Add Label Select Container -->
        <div class="add-label-select-container">

            <button class="accordion-button">Project Details&nbsp;<i class="fas fa-caret-down"></i></button>
            <div class="group accordion-panel">
                <h4>Project Details</h4>
                <!-- Project Name -->
                <input type="hidden" id="project-name" value="" form="labels-order" name="project_name" required />

                <?php

                $exploded_project_name;

                if ($project_name != '') {
                    $exploded_project_name = explode('-', $project_name);
                }
                ?>

                <input type="text" class="project-name-part" id="requester-first-name" placeholder="First Name" name="first_name" form="labels-order" value="<?php if ($project_name != '') {
                                                                                                                                                                    echo $exploded_project_name[1];
                                                                                                                                                                } ?>" required />

                <input type="text" class="project-name-part" id="requester-last-name" placeholder="Last Name" name="last_name" form="labels-order" value="<?php if ($project_name != '') {
                                                                                                                                                                echo $exploded_project_name[0];
                                                                                                                                                            } ?>" required />

                <label for="requester-dept">Choose Your Department</label>
                <select name="requester_dept" class="project-name-part" id="requester-dept" form="labels-order" required>
                    <option value=""></option>

                    <option value="Admin" <?php if ($project_name != '' && $exploded_project_name[2] == 'Admin') : ?>selected<?php endif; ?>>Admin</option>

                    <option value="Accounting" <?php if ($project_name != '' && $exploded_project_name[2] == 'Accounting') : ?>selected<?php endif; ?>>Accounting</option>

                    <option value="Engineering" <?php if ($project_name != '' && $exploded_project_name[2] == 'Engineering') : ?>selected<?php endif; ?>>Engineering</option>

                    <option value="Freight" <?php if ($project_name != '' && $exploded_project_name[2] == 'Freight') : ?>selected<?php endif; ?>>Freight</option>

                    <option value="Laser" <?php if ($project_name != '' && $exploded_project_name[2] == 'Laser') : ?>selected<?php endif; ?>>Laser</option>

                    <option value="Machine-Shop" <?php if ($project_name != '' && $exploded_project_name[2] == 'Machine') : ?>selected<?php endif; ?>>Machine Shop</option>

                    <option value="Marketing" <?php if ($project_name != '' && $exploded_project_name[2] == 'Marketing') : ?>selected<?php endif; ?>>Marketing</option>

                    <option value="Powder-Coating" <?php if ($project_name != '' && $exploded_project_name[2] == 'Powder') : ?>selected<?php endif; ?>>Powder Coating</option>

                    <option value="Press-Brake" <?php if ($project_name != '' && $exploded_project_name[2] == 'Press') : ?>selected<?php endif; ?>>Press Brake</option>

                    <option value="Production" <?php if ($project_name != '' && $exploded_project_name[2] == 'Production') : ?>selected<?php endif; ?>>Production</option>

                    <option value="Purchasing" <?php if ($project_name != '' && $exploded_project_name[2] == 'Purchasing') : ?>selected<?php endif; ?>>Purchasing</option>

                    <option value="Sales" <?php if ($project_name != '' && $exploded_project_name[2] == 'Sales') : ?>selected<?php endif; ?>>Sales</option>

                    <option value="Shipping" <?php if ($project_name != '' && $exploded_project_name[2] == 'Shipping') : ?>selected<?php endif; ?>>Shipping</option>

                    <option value="Tube-Fab" <?php if ($project_name != '' && $exploded_project_name[2] == 'Tube') : ?>selected<?php endif; ?>>Tube-Fab</option>

                    <option value="Welding" <?php if ($project_name != '' && $exploded_project_name[2] == 'Welding') : ?>selected<?php endif; ?>>Welding</option>

                    <option value="Parts-IWS" <?php if ($project_name != '' && $exploded_project_name[2] == 'Parts') : ?>selected<?php endif; ?>>Parts (IWS)</option>

                    <option value="Service-IWS" <?php if ($project_name != '' && $exploded_project_name[2] == 'Service') : ?>selected<?php endif; ?>>Service (IWS)</option>

                    <option value="Shop-IWS" <?php if ($project_name != '' && $exploded_project_name[2] == 'Shop') : ?>selected<?php endif; ?>>Shop (IWS)</option>

                    <option value="Test" <?php if ($project_name != '' && $exploded_project_name[2] == 'Test') : ?>selected<?php endif; ?>>Test</option>

                </select>

                <!-- Marketing PO Number -->
                <input type="<?php if (current_user_can('editor') || current_user_can('administrator')) : ?>text<?php else : ?>hidden<?php endif; ?>" id="purchase-order" value="<?php if (!empty($purchase_order)) : ?><?php echo $purchase_order; ?><?php endif; ?>" form="labels-order" name="purchase_order" placeholder="PO#" />

                <!-- Label Order Number -->
                <p id="order-number-title">Order ID: <?php echo $order_number; ?></p>
            </div>

            <button class="accordion-button" <?php if ($tracking != 'my-orders' && $tracking != 'waiting-on-lead') : ?>style="display:none;" <?php endif; ?>>Add Labels to Order&nbsp;<i class="fas fa-caret-down"></i></button>
            <div class="group accordion-panel" <?php if ($tracking != 'my-orders' && $tracking != 'waiting-on-lead') : ?>style="display:none;" <?php endif; ?>>
                <h4>Add Labels to Order</h4>
                <!-- Select Which Label you would like to add to the order -->
                <select id="add-label-select" form="" name="label_data" required>
                    <?php for ($i = 0; count($order_forms_list) > $i; $i++) : ?>
                        <?php if ($i == 0) : ?>
                        <?php elseif ($i == 1) : ?>
                            <option value="">Select a label to add to your order</option>
                        <?php else : ?>
                            <option value="<?php echo str_replace('.php', '', $order_forms_list[$i]) ?>"><?php echo ucwords(str_replace(['-', '.php'], ' ', $order_forms_list[$i])) ?></option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>

                <!-- Order Form Container -->
                <div class="order-forms-container" id="load-form">
                    <?php for ($i = 0; count($order_forms_list) > $i; $i++) : ?>
                        <?php if ($i != 0 && $i != 1) : ?>
                            <div class="order-form" id="<?php echo str_replace('.php', '', $order_forms_list[$i]) . '-form' ?>">
                                <?php include 'order-forms/' . $order_forms_list[$i]; ?>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <!-- /Order Form Container -->

                <!-- Add Label-->
                <input type="submit" form="labels-order" value="Add to Label Order" id="add-to-label-order" />
            </div>

        </div>
        <!-- /Add Label Select Container -->

        <button class="accordion-button" <?php if ($tracking != 'my-orders') : ?>style="display:none;" <?php endif; ?>>Submit Label Request&nbsp;<i class="fas fa-caret-down"></i></button>
        <div class="dark-group accordion-panel" <?php if ($tracking != 'my-orders') : ?>style="display:none;" <?php endif; ?>>
            <h4>Submit Label Request</h4>
            <!-- Email form -->
            <form id="email-order" action="" method="get" return false;>
                <input type="hidden" name="sub" value="mail" />
                <input type="hidden" name="order-number" id="order-number" value="<?php echo $order_number; ?>" />
                <input type="hidden" name="emp-name" id="emp-name">
                <input type="hidden" name="dept" id="dept">
                <p>Ready to email your label request to your lead?<br> Fill out the info below and click "Email Label Request".</p>
                <label for="date">Date*</label>
                <input type="date" name="date" id="date" required>

                <input type="submit" value="email label request" id="email-order-submit">
            </form>
            <!-- /Email Form -->
        </div>



    </div>
    <!-- /Order Form -->

    <!-- Order Preview -->
    <div class="column preview-area">

        <!-- Preview Container -->
        <div class="preview-container">

            <h2>Current Label Order:</h2>

            <?php if (array_key_exists('order_number', $_GET)) {
                include 'preview-loop.php';
            } ?>

        </div>
        <!-- /Preview Container -->

    </div>
    <!-- /Order Preview -->

</div>
<!-- /Label-o-Matic Container -->



<?php

$conn->close();
