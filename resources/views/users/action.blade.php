@if (Helper::check_permission(config('permissions.users'), 'update'))
<a class="text-dark"  data-id="{{ $id }}" data-table_name="{{ $table_name }}" style="cursor: pointer"
    data-title="{{ $row->title }}" data-description="{{ $row->description }}"
    href="{{$href}}">
    <i class="ti ti-pencil fs-6"></i>
</a>
@endif

@if (Helper::check_permission(config('permissions.users'), 'delete'))
<a class="show_confirm text-info" data-id="{{ $id }}" data-table_name="{{ $table_name }}"
    data-model="{{ $model }}" style="cursor: pointer">
    <i class="ti ti-trash me-1 fs-6"></i>
</a>
@endif

