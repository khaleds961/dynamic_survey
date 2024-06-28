{{-- <a class="text-dark" data-id="{{ $id }}" data-table_name="{{ $table_name }}"
    style="cursor: pointer" data-title="{{ $row->title }}" data-description="{{ $row->description }}"
    href="/surveysections/edit?id={{$id}}&section_id={{$section_id}}&survey_id={{$survey_id}}">
    <i class="ti ti-pencil fs-6"></i>
</a> --}}

<a class="show_confirm text-info" data-id="{{ $id }}" data-table_name="{{ $table_name }}"
    data-model="{{ $model }}" style="cursor: pointer">
    <i class="ti ti-trash me-1 fs-6"></i>
</a>
