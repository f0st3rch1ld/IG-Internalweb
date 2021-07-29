<?php

include 'db-connect.php';

$tabs = array(
    'my-orders',
    'all-orders',
    'waiting-on-lead',
    'lead-approved',
    'ordered-labels',
    'received-labels',
    'delivered-labels'
);
?>

<!-- Change Tracking Form -->
<form id="change-tracking" action="/label-o-matic" method="get">
    <input type="hidden" name="sub" value="tracking" />
    <input type="hidden" name="prev" value="list" />
</form>

<div class="tool-bar">
    <a href="/label-o-matic/?sub=order">Start a new Label Order</a>
</div>

<p style="display:none;"><?php echo var_dump($current_user->employee_department); ?></p>

<?php if (current_user_can('editor') || current_user_can('administrator') || $current_user->roles[0] == 'lead') : ?>

    <!-- Label Order Tabs -->
    <div class="label-order-tabs">
        <?php foreach ($tabs as $tab) : ?>
            <?php if (current_user_can('editor') || current_user_can('administrator') || ($current_user->roles[0] == 'lead' && ($tab == 'my-orders' || $tab == 'all-orders'))) : ?>
                <button class="tablinks <?php if ($tab == 'my-orders') : ?>active<?php endif; ?>" onclick="switchTab(event, '<?php echo $tab; ?>')"><?php echo ucfirst(str_replace('-', ' ', $tab)); ?></button>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <!-- /Label Order Tabs -->

<?php endif; ?>


<?php foreach ($tabs as $tab) : ?>

    <?php

    $all_order_data = "SELECT order_number, date_started, project_name, requester_department, purchase_order, user_id, tracking FROM orders";
    $all_order_data_result = $conn->query($all_order_data);

    ?>

    <?php if (current_user_can('editor') || current_user_can('administrator') || $tab == 'my-orders' || ($current_user->roles[0] == 'lead' && $tab == 'all-orders')) : ?>

        <!-- <?php echo $tab; ?> -->
        <div id="<?php echo $tab; ?>" class="tabcontent" <?php if ($tab == 'my-orders') : ?>style="display:flex;" <?php endif; ?>>

            <h2><?php echo ucfirst(str_replace('-', ' ', $tab)); ?></h2>

            <table class="label-orders-table tablesorter" id="orders-table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Order ID</th>
                        <th>Date Created</th>
                        <th>Label PO#</th>
                        <th>Tracking</th>
                        <th>Edit Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $all_order_data_result->fetch_assoc()) : ?>


                        <?php
                        // Custom exceptions for filtering of listed orders
                        if (
                            // All users can see thier own labels
                            ($tab == 'my-orders' && $current_user->ID == $row['user_id'])
                            ||
                            // Admins can see all tabs and all orders
                            ((current_user_can('editor') || current_user_can('administrator')) && $tab != 'my-orders' && $row['tracking'] == $tab)
                            ||
                            // Leads can see all labels tab and orders pertaining to their departments
                            ($current_user->roles[0] == 'lead' && $current_user->employee_department == strtolower($row['requester_department']) && $tab == 'all-orders')
                            ||
                            // Admins Can see every order on the All Orders Tab
                            ((current_user_can('editor') || current_user_can('administrator')) && $tab == 'all-orders')
                            ||

                            // Other Custom Filters for individuals listed below, are for leads who can see more than one department's labels.

                            // Kyle Davis Custom Filter
                            ($current_user->ID == 54 && ($row['requester_department'] == 'Laser' ||
                                $row['requester_department'] == 'Machine-Shop' ||
                                $row['requester_department'] == 'Powder-Coating' ||
                                $row['requester_department'] == 'Production' ||
                                $row['requester_department'] == 'Press-Brake' ||
                                $row['requester_department'] == 'Purchasing' ||
                                $row['requester_department'] == 'Tube-Fab' ||
                                $row['requester_department'] == 'Engineering')
                                && $tab == 'all-orders')
                            ||
                            // Kristin Robertson Custom Filter
                            ($current_user->ID == 53 && ($row['requester_department'] == 'Freight' ||
                                $row['requester_department'] == 'Shipping')
                                && $tab == 'all-orders')
                            ||
                            // Erika Pedroza Custom Filter
                            ($current_user->ID == 38 && ($row['requester_department'] == 'Admin' ||
                                $row['requester_department'] == 'Accounting')
                                && $tab == 'all-orders')
                            ||
                            // Steve Delaplain Custom Filter
                            ($current_user->ID == 69 && ($row['requester_department'] == 'Parts-IWS' ||
                                $row['requester_department'] == 'Service-IWS' ||
                                $row['requester_department'] == 'Shop-IWS')
                                && $tab == 'all-orders')
                        ) : ?>
                            <tr>
                                <td><?php echo str_replace('\\', '', $row['project_name']); ?></td>
                                <td><?php echo $row['order_number']; ?></td>
                                <td><?php echo $row['date_started']; ?></td>
                                <td><?php echo $row['purchase_order']; ?></td>
                                <td>
                                    <?php echo ucfirst(str_replace('-', ' ', $row['tracking'])); ?>
                                </td>
                                <td>
                                    <a href="/label-o-matic/?sub=order&order_number=<?php echo $row['order_number']; ?>">Edit Order</a>
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <!-- /<?php echo $tab; ?> -->

    <?php endif; ?>

<?php endforeach; ?>

<?php $conn->close(); ?>