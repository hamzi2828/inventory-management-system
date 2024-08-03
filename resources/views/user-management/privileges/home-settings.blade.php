<tr>
    <td colspan="2">
        <h5 class="mb-0">Home Page Settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="home-settings-privilege" @checked(!empty($permission) && in_array ('home-settings-privilege', $permission -> permission))>
            <label class="form-check-label">Home Page Settings</label>
        </div>
    </td>
</tr>


<tr>
    <td colspan="2">
        <h5 class="mb-0">Reviews</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="review-edit-privilege" @checked(!empty($permission) && in_array ('review-edit-privilege', $permission -> permission))>
            <label class="form-check-label">Edit review</label>
        </div>
    </td>
</tr>
