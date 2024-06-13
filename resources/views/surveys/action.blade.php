@if(Helper::check_permission(config('permissions.surveys'), 'read'))
<a class="text-dark" data-id="{{ $id }}" data-table_name="{{ $table_name }}" style="cursor: pointer"
    href="{{ $show }}">
    <i class="ti ti-eye fs-6"></i>
</a>
@endif

@if(Helper::check_permission(config('permissions.surveys'), 'update'))
<a class="text-dark" data-id="{{ $id }}" data-table_name="{{ $table_name }}" style="cursor: pointer"
    href="{{ $route }}">
    <i class="ti ti-pencil fs-6"></i>
</a>
@endif

@if(Helper::check_permission(config('permissions.surveys'), 'delete'))
<a class="show_confirm text-info" data-id="{{ $id }}" data-table_name="{{ $table_name }}"
    data-model="{{ $model }}" style="cursor: pointer">
    <i class="ti ti-trash me-1 fs-6"></i>
</a>
@endif
