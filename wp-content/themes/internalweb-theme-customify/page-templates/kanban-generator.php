<?php
/*
Template Name: Kanban Generator
*/
get_header();
?>

<div class="kanban-generator-container">

    <label for="time-period">Time Period (A Period of time to average the amount of parts used per day)
        <input type="number" value="0" name="time-period" id="time-period" class="kanban-gen-field"></input>
    </label>

    <label for="parts-used">Parts Used (The total amount of parts used in the time period specified above)
        <input type="number" value="0" name="parts-used" id="parts-used" class="kanban-gen-field"></input>
    </label>

    <label for="lead-time">Vendor Lead Time in Days (Do not Count Wekeends.)
        <input type="number" value="0" name="lead-time" id="lead-time" class="kanban-gen-field"></input>
    </label>

    <label for="minimum-order">Minimum Re-Order Quantity From Vendor
        <input type="number" value="0" name="minimum-order" id="minimum-order" class="kanban-gen-field"></input>
    </label>

    <label for="parts-per-bin">Parts Bin Kanban - Parts Per Kanban (The total amount of parts you can place in 1 kanban ex. 300 bolts in 1 bin, or 1 rack on 1 shelf space)
        <input type="number" value="0" name="parts-per-bin" id="parts-per-bin" class="kanban-gen-field"></input>
    </label>

    <p>
        Example of Algorithm.<br />
        Blue Kanbans = Minimum Order / Minimum Order<br />
        Red Kanban = (Lead Time * (Parts Used / Time Period)) / Parts Per Bin - rounded-up to nearest integer<br />
        Re-Order Amount = (Lead Time * (Parts Used / Time Period)) + (Parts Used / Time Period) - rounded-up to nearest integer<br />
        <br /><br />
    </p>

    <p>Blue Kanbans (The amount of blue kanbans needed to sustain)</p>
    <p id="blue-bins"></p>

    <p>Red Kanbans (The amount of red kanbans needed to sustain)</p>
    <p id="red-bins"></p>

    <p>Amount to Re-Order (The amount of parts you need to re-order when triggered, to refill both kanbans)</p>
    <p id="re-order-amount"></p>

    <p>------------------------------------------------------</p>
</div>

<script>
    let fields = document.getElementsByClassName('kanban-gen-field');

    for (i = 0; fields.length > i; i++) {
        fields[i].addEventListener('change', function() {

            let timePeriod = document.getElementById('time-period').value;
            let leadTime = document.getElementById('lead-time').value;
            let partsUsed = document.getElementById('parts-used').value;
            let minOrder = document.getElementById('minimum-order').value;
            let partsPerBin = document.getElementById('parts-per-bin').value;

            let dailyAvg = partsUsed / timePeriod; //daily average
            let safetyStock = leadTime * dailyAvg; //minimum safety stock

            let blueBinOut = document.getElementById('blue-bins');
            let redBinOut = document.getElementById('red-bins');
            let reOrderAmount = document.getElementById('re-order-amount');

            blueBinOut.innerHTML = minOrder / minOrder;
            redBinOut.innerHTML = Math.ceil(safetyStock / partsPerBin);
            reOrderAmount.innerHTML = Math.ceil(safetyStock + dailyAvg);

        });
    }
</script>




<?php
get_footer();
?>