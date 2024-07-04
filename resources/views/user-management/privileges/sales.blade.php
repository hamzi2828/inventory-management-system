<tr>
    <td colspan="2">
        <h5 class="mb-0">sales</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="sales-privilege" @checked(!empty($permission) && in_array ('sales-privilege', $permission -> permission))>
            <label class="form-check-label">sales</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All sales</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-sales-privilege" @checked(!empty($permission) && in_array ('all-sales-privilege', $permission -> permission))>
            <label class="form-check-label">All sales</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-sales-privilege" @checked(!empty($permission) && in_array ('edit-sales-privilege', $permission -> permission))>
                <label class="form-check-label">Edit sales</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-sales-privilege" @checked(!empty($permission) && in_array ('delete-sales-privilege', $permission -> permission))>
                <label class="form-check-label">Delete sales</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="close-sales-privilege" @checked(!empty($permission) && in_array ('close-sales-privilege', $permission -> permission))>
                <label class="form-check-label">Close sales</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="sale-refund-privilege" @checked(!empty($permission) && in_array ('sale-refund-privilege', $permission -> permission))>
                <label class="form-check-label">Refund sales</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add sales</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-sales-privilege" @checked(!empty($permission) && in_array ('add-sales-privilege', $permission -> permission))>
            <label class="form-check-label">Add sales (simple)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">quick sale</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-quick-sales-privilege" @checked(!empty($permission) && in_array ('add-quick-sales-privilege', $permission -> permission))>
            <label class="form-check-label">quick sale</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add sales (attribute)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-sales-attribute-privilege" @checked(!empty($permission) && in_array ('add-sales-attribute-privilege', $permission -> permission))>
            <label class="form-check-label">Add sales (attribute)</label>
        </div>
    </td>
</tr>