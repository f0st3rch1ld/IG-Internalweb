<!--Blank Card Labels-->

<label for="blank-card-labels">Choose your Blank Card Label:</label>

<div class="order-form-label-preview" id="blank-cards-preview-container" style="display:none;"></div>

<select class="dynamic-form blank-card-labels" name="type" id="blank-card-labels" form="" required>
    <option value selected></option>

    <option value="blank-build-order-card">Blank Build Order Card (4.82" x 3.06")</option>

    <option value="blank-engineering-build-order-card">Blank Engineering Build Order Card (4.82" x 3.06")</option>

    <option value="blank-priority-build-order-card">Blank Priority Build Order Card (4.82" x 3.06")</option>

    <option value="blank-sent-out-for-finishing-card">Blank Sent Out For Finishing Card (4.82" x 3.06")</option>

    <option value="blank-recut-card">Blank Recut Card (4.82" x 3.06")</option>

    <option value="blank-order-card">Blank Order Card (3.35" x 2.3")</option>

    <option value="blank-kanban-card">Blank Kanban Card (3.35" x 2.3")</option>

    <option value="blank-label-being-made-card">Blank Label Being Made Card (3.35" x 2.3")</option>

    <option value="blank-extra-stock-card">Blank Extra Stock Card (3.35" x 2.3")</option>

    <option value="video-dept-in-use-card">Video Department In Use Card (3.35" x 2.3")</option>

</select>

<label for="blank-card-labels-qty">Qty</label>

<input class="dynamic-form blank-card-labels" type="number" name="blank-card-labels-qty" id="blank-card-labels-qty"
    form="" required>

<script>
document.getElementById('blank-card-labels').addEventListener("change", function() {
    let labelToPreview = document.getElementById('blank-card-labels').value;

    labelPreviewDir = "<?php echo plugin_dir_url(__DIR__) . 'label-previews/'; ?>";

    let label = labelPreviewDir + labelToPreview + ".jpg";

    if (label != '') {
        document.getElementById('blank-cards-preview-container').setAttribute('style',
            `background-image:url('${label}');`);
    } else {
        document.getElementById('blank-cards-preview-container').setAttribute('style',
            `display:none;`);
    }

});
</script>