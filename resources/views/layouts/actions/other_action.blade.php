<?php
if ($checked_flag == 1) {
    $checked = 'checked';
} else {
    $checked = '';
}
?>

@if ($action == 'is_active')
    <div class="form-check form-switch form-switch-lg">
        <input data-size="Size" class="form-check-input change_status" type="checkbox"
        data-id="{{ $id }}" {{(Helper::check_permission(config("permissions.$table_name"), 'update')) ? '' : 'disabled'}}
        data-action="{{ $action }}" data-table_name="{{ $table_name }}"
        id="customSwitch_{{ $id }}" {{ $checked }}
        />
        <label class="form-check-label" for="customSwitch_{{ $id }}">Active</label>
    </div>
@endif

@if ($action == 'is_featured')
    <div class="form-group">
        <div class="custom-control custom-switch custom-checkbox-secondary">
            <input type="checkbox" class="custom-control-input change_status" data-id="{{ $id }}"
                data-action="{{ $action }}" data-table_name="{{ $table_name }}"
                id="customSwitch1_{{ $id }}" {{ $checked }}>
            <label class="custom-control-label" for="customSwitch1_{{ $id }}">Featured</label>
        </div>
    </div>
@endif

@if ($action == 'is_approved')
    <div class="form-group">
        <div class="custom-control custom-switch custom-checkbox-success">
            <input type="checkbox" class="custom-control-input change_status_approval_active"
                data-id="{{ $id }}" data-action="{{ $action }}" data-table_name="{{ $table_name }}"
                id="customSwitch2_{{ $id }}" {{ $checked }}>
            <label class="custom-control-label" for="customSwitch2_{{ $id }}">Approved</label>
        </div>
    </div>
@endif

@if ($action == 'is_refundable')
    <div class="form-group">
        <div class="custom-control custom-switch custom-checkbox-success">
            <input type="checkbox" class="custom-control-input change_status" data-id="{{ $id }}"
                data-action="{{ $action }}" data-table_name="{{ $table_name }}"
                id="customSwitch2_{{ $id }}" {{ $checked }}>
            <label class="custom-control-label" for="customSwitch2_{{ $id }}">Refundable</label>
        </div>
    </div>
@endif


