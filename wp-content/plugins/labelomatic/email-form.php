<form id="email-order" action="/label-o-tron" method="get">
    <p>Ready to email your label request to your lead?<br> Fill out the info below and click "Email Label Request".</p>
    <label for="emp-name">Your Name*</label>
    <input type="text" name="emp-name" id="emp-name" required>

    <label for="dept">Your Department*</label>
    <select name="dept" id="dept" required>
        <option value=""></option>
        <option value="admin">Admin</option>
        <option value="accounting">Accounting</option>
        <option value="engineering">Engineering</option>
        <option value="freight">Freight</option>
        <option value="laser">Laser</option>
        <option value="machine-shop">Machine Shop</option>
        <option value="marketing">Marketing</option>
        <option value="powder-coating">Powder Coating</option>
        <option value="press-brake">Press Brake</option>
        <option value="production">Production</option>
        <option value="sales">Sales</option>
        <option value="shipping">Shipping</option>
        <option value="welding">Welding</option>
        <option value="iws-service">Service (IWS)</option>
        <option value="iws-shop">Shop (IWS)</option>
        <option value="test">Test</option>
    </select>

    <label for="date">Date*</label>
    <input type="date" name="date" id="date" required>
    <input type="hidden" name="order-number" id="order-number" value="<?php echo $order_number; ?>" />

    <input type="submit" value="email label request">
</form>