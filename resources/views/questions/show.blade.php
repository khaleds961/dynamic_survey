@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    <!-- Flash message -->
    @if (session('success'))
        <div id="flash-message" class="btn alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('questions.index') }}" class="text-info">Questions</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Show Question</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <div class="row">
                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="section_id">Section</label><span class="text-danger">*</span>
                    <select class="form-control" id="section_id" name="section_id" disabled>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}"
                                {{ $question->section_id == $section->id ? 'selected' : '' }}>
                                {{ $section->title_ar ? $section->title_ar : $section->title_en }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- //secrect --}}
                <input type="hidden" value="{{ $question->id }}" name="id">

                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="question_type">Question Type</label><span class="text-danger">*</span>
                    <select class="form-control" id="question_type" name="question_type" disabled>
                        <option value="text" {{ $question->question_type == 'text' ? 'selected' : '' }}>Text
                        </option>
                        <option value="multiple_choices"
                            {{ $question->question_type == 'multiple_choices' ? 'selected' : '' }}>
                            Multiple Choice</option>
                        <option value="option" {{ $question->question_type == 'option' ? 'selected' : '' }}>Option
                        </option>
                        <option value="select" {{ $question->question_type == 'select' ? 'selected' : '' }}>Select
                        </option>
                    </select>
                </div>

                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="question_text_ar">Question Text Ar</label><span class="text-danger">*</span>
                    <textarea class="form-control resize-none" id="question_text_ar" rows="3" name="question_text_ar" readonly disabled>{{ $question->question_text_ar }}</textarea>
                </div>

                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="question_text_en">Question Text En</label><span class="text-danger">*</span>
                    <textarea class="form-control resize-none" id="question_text_en" rows="3" name="question_text_en" readonly disabled>{{ $question->question_text_en }}</textarea>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between my-2">
                            <h4>Options</h4>
                            @if(Helper::check_permission(config('permissions.options'), 'write'))
                            <a type="button"
                                class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                                href="/options/create?question_id={{ request()->query('id') }}">
                                <i class="ti ti-circle-plus"></i>
                                <span>Add New Option</span>
                            </a>
                            @endif
                        </div>
                        <div class="card">
                            <div class="table-responsive rounded-2 my-2">
                                <div class="table-responsive mx-4">
                                    <div class="table-responsive mx-4">
                                        <table id="options-list"
                                            class="table border table-striped table-bordered display text-nowrap">
                                            <thead>
                                                <!-- start row -->
                                                <tr>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">order</h6>
                                                    </th>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">icon</h6>
                                                    </th>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Option text Ar</h6>
                                                    </th>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Option text En</h6>
                                                    </th>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">status</h6>
                                                    </th>
                                                    <th>
                                                        <h6 class="fs-4 fw-semibold mb-0 text-uppercase">action</h6>
                                                    </th>
                                                </tr>
                                                <!-- end row -->
                                            </thead>
                                            <tbody>
                                                <!-- start row -->
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {
            //remove white spaces from description
            var question_text_ar = $('#question_text_ar').val().trim();
            $('#question_text_ar').val(question_text_ar);

            var table = $('#options-list').DataTable({
                processing: false,
                serverSide: false,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                rowReorder: true,
                ajax: "/questionOptions?question_id={{ $question->id }}",
                columns: [{
                        data: "order_num",
                        name: 'order_num'
                    },
                    {
                        data: "icon",
                        name: 'icon'
                    },
                    {
                        data: "option_text_ar",
                        name: 'option_text_ar'
                    },
                    {
                        data: "option_text_en",
                        name: 'option_text_en'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                        orderable: false
                    },
                ],
                rowReorder: {
                    dataSrc: 'order_num'
                },
            });

            table.on('row-reorder', function(e, details) {
                if (details.length) {
                    let rows = [];
                    details.forEach(element => {
                        rows.push({
                            id: table.row(element.node).data().id,
                            position: element.newPosition
                        });
                    });
                    $.ajax({
                        method: 'POST',
                        url: "{{ route('row_reorder') }}",
                        data: {
                            rows: rows,
                            table_name: 'options'
                        }
                    }).done(function() {
                        table.ajax.reload()
                    });

                }

            });
        });
    </script>
@endpush
