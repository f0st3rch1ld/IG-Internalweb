<?php

// Checks order number against database
$order_number_check = "SELECT order_number FROM orders WHERE order_number='" . $order_number . "'";
$result = $conn->query($order_number_check);
$replace = array(
    'u2019',
    'u201d',
    'u005c',
    'u00b0'
);

$with = array(
    "&rsquo;",
    '&rdquo;',
    '&bsol;',
    '&deg;'
);

if ($result->num_rows > 0) :

    $label_data = "SELECT label_data FROM orders WHERE order_number='" . $order_number . "'";
    $label_data_result = mysqli_query($conn, $label_data);

    $row = mysqli_fetch_array($label_data_result, MYSQLI_BOTH);
    $decoded_row = array_values(json_decode($row[0], true)); ?>

    <?php for ($i = 0; count($decoded_row) > $i; $i++) : ?>

        <div class="ind-label">

            <input type="hidden" id="label-index-<?php echo $i; ?>" name="label_index" value="<?php echo $i; ?>" form="">

            <!-- Number Container -->
            <div class="num-container">
                <h4><?php echo $i + 1; ?></h4>
            </div>
            <!-- /Number Container -->

            <div class="ind-label-right">
                <!-- Preview Container -->
                <div class="preview-container">

                    <h3><?php echo ucwords(str_replace('-', ' ', $decoded_row[$i]['label_data'])); ?></h3>

                    <input type="hidden" class="edit-label-input edit-label-<?php echo $i ?>" form="" name="label_data" value="<?php echo $decoded_row[$i]['label_data']; ?>" />

                    <?php

                    // Preview Generator
                    
                    $label_to_preview;
                    $preview_dir = plugin_dir_url(__DIR__) . 'label-o-matic/label-previews/';

                    switch ($decoded_row[$i]['label_data']) {
                        case 'blank-card-labels':
                            $label_to_preview = $preview_dir . $decoded_row[$i]['type'] . '.jpg';
                            break;
                        default:
                        $label_to_preview = '';
                    }

                    ?>

                    <!-- Generated Preview -->
                    <div class="order-form-label-preview" style="background-image:url('<?php echo $label_to_preview; ?>');"></div>
                    <!-- /Generated Preview -->

                    <?php if ($tracking == 'my-orders' || $tracking == 'waiting-on-lead') : ?>

                        <div class="preview-loop-controls">
                            <input type="submit" form="remove-label" value="Remove" onmouseover="document.getElementById('label-index-<?php echo $i; ?>').setAttribute('form', 'remove-label');" onmouseout="document.getElementById('label-index-<?php echo $i ?>').setAttribute('form', '');" />

                            <input type="submit" form="edit-label" value="Save Edits" class="save-edits-submit" id="save-edits-<?php echo $i; ?>" onmouseover="prepareToSave(<?php echo $i; ?>)" onmouseout="cancelSave(<?php echo $i; ?>)" style="display:none;" onclick="convertToEdit(<?php echo $i; ?>)" />
                        </div>

                    <?php endif; ?>
                </div>
                <!-- /Preview Container -->

                <!-- Label Details Container -->
                <div class="details-container">
                    <?php foreach ($decoded_row[$i] as $key => $value) : ?>
                        <?php if ($key != 'label_data') : ?>
                            <label for="<?php echo $key; ?>"><?php echo ucwords(str_replace('-', ' ', $key)) ?>:
                                <?php if ($tracking == 'my-orders' || $tracking == 'waiting-on-lead') : ?>
                                    <input type="text" name="<?php echo $key; ?>" class="edit-label-input edit-label-<?php echo $i; ?>" id="" value="<?php echo str_replace($replace, $with, $value); ?>" onchange="editLabels(<?php echo $i; ?>)" />
                                <?php else : ?>
                                    <p><?php echo str_replace($replace, $with, $value); ?></p>
                                <?php endif; ?>
                            </label>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($tracking == 'my-orders' || $tracking == 'waiting-on-lead') : ?>
                        <p class="subtext">Click On The Text Above to Edit</p>
                    <?php endif; ?>
                </div>
                <!-- /Label Details Container -->
            </div>

        </div>

    <?php endfor; ?>

<?php endif; ?>