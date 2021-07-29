<!--Tool Labels-->

<?php

// If you need to update this form, please read how to edit the array below.

$tool_labels = array(
    // Each form of label is grouped by placing it into an array ex. "hand-tools => array()" then each individual label is placed into the array where the file name without the extension is the key, and the displayed name is the value.

    // Hand Tools Array
    'hand-tools' => array(
        // File Name Without Extension => Display Name
        'Caulk-Gun-HND1005' => 'Caulk Gun',
        'Caution-Tape-HND1008' => 'Caution Tape',
        'Chalk-HND1013' => 'Chalk',
        'Drinks-HND1015' => 'Drinks',
        'LABEL-Step-Ladder-HND0032-Stocked' => 'Step Ladder',
        'LABEL-Hand-Broom-HND0048-Stocked' => 'Hand Broom',
        'LABEL-Small-Broom-HND0049-Stocked' => 'Small Broom',
        'LABEL-Large-Broom-HND0050-Stocked' => 'Large Broom',
        'LABEL-Scrub-Broom-HND0051-Stocked' => 'Scrub Broom',
        'LABEL-Dust-Pan-HND0052-Stocked' => 'Dust Pan',
        'LABEL-Grease-Gun-HND0053-Stocked' => 'Grease Gun',
        'LABEL-Floor-Scraper-HND0054-Stocked' => 'Floor Scraper',
        'LABEL-Snow-Shovel-HND0055-Stocked' => 'Snow Shovel',
        'LABEL-Walking-Wheel-HND0056-Stocked' => 'Walking Wheel',
        'LABEL-Tape-Measure-HND0057-Stocked' => 'Tape Measure',
        'LABEL-Folding-Ladder-HND0058-Stocked' => 'Folding Ladder',
        'Zip-Ties-HND1000' => 'Zip Ties',
        'Note-Pads-HND1001' => 'Note Pads',
        'Large-Dead-Blow-HND1002' => 'Large Dead Blow',
        'Small-Dead-Blow-HND1003' => 'Small Dead Blow',
        'Pipe-Vise-HND1004' => 'Pipe Vise',
        'Caulk-Gun-HND1005' => 'Caulk Gun',
        'Quick-Grip-Clamp-HND1006' => 'Quick Grip Clamp',
        'Quick-Grip-Spreader-HND1007' => 'Quick Grip Spreader',
        'Caution-Tape-HND1008' => 'Caution Tape',
        'Long-Fish-Tape-HND1009' => 'Long Fish Tape',
        'Short-Fish-Tape-HND1010' => 'Short Fish Tape',
        'Long-Chalk-Line-HND1011' => 'Long Chalk Line',
        'Short-Chalk-Line-HND1012' => 'Short Chalk Line',
        'Chalk-HND1013' => 'Chalk',
        'String-Line-HND1014' => 'String Line'
    ),
    // /Hand Tools Array

    // Power Tools Array
    'power-tools' => array(
        'LABEL-Air-Hose-PWR0007-Stocked' => 'Air Hose',
        'LABEL-110-Cord-PWR0015-Stocked' => '110 Cord',
        'LABEL-220-Cord-PWR0016-Stocked' => '220 Cord',
        'LABEL-Water-Hose-PWR0017-Stocked' => 'Water Hose',
        'Die-Grinder-PWR1000' => 'Die Grinder',
        'Finger-Sander-PWR1001' => 'Finger Sander',
        'Air-Nozzle-PWR1002' => 'Air Nozzle',
        'Cut-Off-Tool-PWR1003' => 'Cut Off Tool',
        'Air-Buffer-PWR1004' => 'Air Buffer'
    ),
    // /Power Tools Array

    // Fixtures Array
    'fixture' => array(
        'LABEL-Coat-Rack-FIX0029-STOCKED' => 'Coat Rack',
        'LABEL-Trash-Can-FIX0030-STOCKED' => 'Trash Can'
    ),
    // /Fixtures Array

    // Electronic Tools Array
    'electronic' => array(
        'LABEL-Stop-Watch-ELEC0017-STOCKED' => 'Stop Watch',
        'Phone-Headset-ELEC1000' => 'Phone Headset',
        'Radios-ELEC1001' => 'Radios',
        'Charging-Station-ELEC1002' => 'Charging Station'
    )
    // /Electronic Tools Array
);

?>

<label for="tool-label-select">Select the tool label you would like made.</label>

<select class="dynamic-form tool-labels" name="type" id="tool-label-select" form="" onchange="showRequestNewTool()" onblur="showRequestNewTool()" required>

    <!-- Default Option -->
    <option value selected></option>

    <!-- Request New Option -->
    <optgroup label="Dont see what you are looking for?">
        <option value="request-new">Request to have a tool label added to the list</option>
    </optgroup>

    <?php foreach ($tool_labels as $group => $ind_tool_labels) :
        asort($ind_tool_labels); ?>
        <optgroup label="<?php echo ucwords(str_replace('-', ' ', $group)); ?>">
            <?php foreach ($ind_tool_labels as $key => $value) : ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php endforeach; ?>
        </optgroup>
    <?php endforeach; ?>

</select>

<!-- Request New Options -->
<div class="radio-group" id="request-new-tool-label-group" style="display:none;">

        <p><strong>What kind of tool label do you need?</strong></p>

        <label for="hand-tool">
            <input type="radio" class="dynamic-form tool-labels-condition" name="new-tool-label-type" id="hand-tool" value="hand-tool" form="" />
            Hand Tools
        </label>

        <label for="power-tool">
            <input type="radio" class="dynamic-form tool-labels-condition" name="new-tool-label-type" id="power-tool" value="power-tool" form="" />
            Power Tool
        </label>

        <label for="electronic-tool">
            <input type="radio" class="dynamic-form tool-labels-condition" name="new-tool-label-type" id="electronic-tool" value="electronic-tool" form="" />
            Electronic Tool
        </label>

        <label for="fixture">
            <input type="radio" class="dynamic-form tool-labels-condition" name="new-tool-label-type" id="fixture" value="fixture" form="" />
            Fixture
        </label>

    <label for="tool-label-text">Text:</label>
    <input class="dynamic-form tool-labels-condition" type="text" name="new-tool-label-text" id="tool-label-text" form="">

</div>

<script>
    function showRequestNewTool() {
        let toolLabelSelect = document.getElementById('tool-label-select');
        let requestGroup = document.getElementById('request-new-tool-label-group');

        let conditionalFields = document.getElementsByClassName('tool-labels-condition');

        if (toolLabelSelect.value == 'request-new') {
            requestGroup.setAttribute('style', 'display:flex;');
            for (i = 0; conditionalFields.length > i; i++) {
                conditionalFields[i].setAttribute('form', 'labels-order');
            }
        } else {
            requestGroup.setAttribute('style', 'display:none;');
            for (i = 0; conditionalFields.length > i; i++) {
                conditionalFields[i].setAttribute('form', '');
            }
        }
    }
</script>
<!-- /Request New Options -->

<label for="tool-labels-qty">Qty:</label>
<input class="dynamic-form tool-labels" type="number" name="tool-label-qty" id="tool-labels-qty" form="">