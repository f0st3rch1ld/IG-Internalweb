<!-- Front of Kanban Card -->

<label for="label-area">Area Options*</label>
<select class="dynamic-form kanban-card" name="area" id="label-area" form="" required>
    <!-- Location Options -->
    <option value=""></option>
    <option value="accounting">Accounting</option>
    <option value="compressor-room">Compressor Room</option>
    <option value="design-center">Design Center</option>
    <option value="engineering">Engineering</option>
    <option value="hardware">Hardware</option>
    <option value="janitorial-room">Janitorial Room</option>
    <option value="laser">Laser</option>
    <option value="loading-dock-1">Loading Dock 1</option>
    <option value="loading-dock-2">Loading Dock 2</option>
    <option value="machine-shop">Machine Shop</option>
    <option value="marketing">Marketing</option>
    <option value="office-work-area">Office Work Area</option>
    <option value="powder-coating">Powder Coating</option>
    <option value="pressbrake">Pressbrake</option>
    <option value="pump-up-gym">Pump Up Gym</option>
    <option value="r-and-d">R&amp;D</option>
    <option value="sales">Sales</option>
    <option value="shipping">Shipping</option>
    <option value="studio">Studio</option>
    <option value="training-room">Training Room</option>
    <option value="tube-fab">Tube Fab</option>
    <option value="welding">Welding</option>
    <option value="iws-office">IWS Office</option>
    <option value="iws-parts">IWS Parts</option>
    <option value="iws-shop">IWS Shop</option>
    <!-- /Location Options -->
</select>

<label for="part-number">Part Number*</label>
<input class="dynamic-form kanban-card" type="text" name="part-number" id="part-number" form="" required>

<label for="quantity">Qty*</label>
<input class="dynamic-form kanban-card" type="text" name="quantity" id="quantity" form="" required>

<label for="description">Description*</label>
<input class="dynamic-form kanban-card" type="text" name="description" id="description" form="" required>

<label for="front-notes">Notes*</label>
<input class="dynamic-form kanban-card" type="text" name="front-notes" id="front-notes" form="">

<!-- Flow Card -->

<p>Part Flow:</p>

<label for="flow-through-laser">Laser</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-laser" id="flow-through-laser" form="" />

<label for="flow-through-bend">Bend</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-bend" id="flow-through-bend" form="" />

<label for="flow-through-machine">Machine</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-machine" id="flow-through-machine" form="" />

<label for="flow-through-tube-fab">Tube Fab</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-tube-fab" id="flow-through-tube-fab" form="" />

<label for="flow-through-weld">Weld</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-weld" id="flow-through-weld" form="" />

<label for="flow-through-coatings">Coatings</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-coatings" id="flow-through-coatings" form="" />

<label for="flow-through-hardware">Hardware</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-through-hardware" id="flow-through-hardware" form="" />

<label for="flow-through-final-assembly">Final Assembly</label>
<input type="checkbox" class="dynamic-form kanban-card" name="flow-throughfinal-assemblye" id="flow-through-final-assembly" form="" />

<!-- Blue Kanban Labels -->

<label for="blue-labels">Do you need Blue labels?*</label>
<input class="dynamic-form kanban-card" type="checkbox" name="blue-labels" id="blue-labels" form="">

<label for="blue-label-qty">Amount of Blue Kanban Labels</label>
<input class="dynamic-form kanban-card" type="number" name="blue-label-qty" id="blue-label-qty" form="">

<label for="blue-part-qty">Qty</label>
<input class="dynamic-form kanban-card" type="number" name="blue-part-qty" id="blue-part-qty" form="">

<label for="blue-label-deep">Deep</label>
<input class="dynamic-form kanban-card" type="number" name="blue-label-deep" id="blue-label-deep" form="">

<label for="blue-label-high">High</label>
<input class="dynamic-form kanban-card" type="number" name="blue-label-high" id="blue-label-high" form="">

<!-- Red Kanban Labels -->

<label for="red-labels">Do you need Red labels?*</label>
<input class="dynamic-form kanban-card" type="checkbox" name="red-labels" id="red-labels" form="">

<label for="red-label-qty">Amount of Red Kanban Labels</label>
<input class="dynamic-form kanban-card" type="number" name="red-label-qty" id="red-label-qty" form="">

<label for="red-part-qty">Qty</label>
<input class="dynamic-form kanban-card" type="number" name="red-part-qty" id="red-part-qty" form="">

<label for="red-label-deep">Deep</label>
<input class="dynamic-form kanban-card" type="number" name="red-label-deep" id="red-label-deep" form="">

<label for="red-label-high">High</label>
<input class="dynamic-form kanban-card" type="number" name="red-label-high" id="red-label-high" form="">