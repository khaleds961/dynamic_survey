@extends('layouts.master')
@section('title', 'Show')
@section('content')

    @php
        $fonts = [
            ['name' => 'Arial', 'value' => 'Arial, sans-serif'],
            ['name' => 'Times New Roman', 'value' => 'Times New Roman'],
            ['name' => 'Courier New', 'value' => 'Courier New, Courier, monospace, sans-serif'],
            ['name' => 'Georgia', 'value' => 'Georgia, serif'],
            ['name' => 'Trebuchet MS', 'value' => 'Trebuchet MS, Helvetica, sans-serif'],
            ['name' => 'Verdana', 'value' => 'Verdana, sans-serif'],
        ];

        $lang = isset($survey->property->language) ? $survey->property->language : '';
        $logo = isset($survey->property->logo)
            ? asset('storage/' . $survey->property->logo)
            : asset('storage/images/not-av.png');
        $backgroundImage = isset($survey->property->backgroundImage)
            ? asset('storage/' . $survey->property->backgroundImage)
            : asset('storage/images/not-av.png');

    @endphp

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
                <a href="{{ route('surveys.index') }}" class="text-info">Sections</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Show Section</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <div class="row">
                <div class="form-group col-6 mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                        placeholder="Enter Title" name="title" value="{{ $section->title }}" disabled>
                    <br />
                </div>

                {{-- //invisible --}}
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="form-group col-6 mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control resize-none" id="description" rows="3" name="description" disabled>{{ old('description', $section->description) }}</textarea>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between my-2">
                        <h4>Questions</h4>
                        <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                            href="/questions/create?section_id={{ $section->id }}">
                            <i class="ti ti-circle-plus"></i>
                            <span>Add New Question</span>
                        </a>
                    </div>
                    <div class="card">
                        <div class="table-responsive rounded-2 my-2">
                            <div class="table-responsive mx-4">
                                <table id="questions-list"
                                    class="table border table-striped table-bordered display text-nowrap">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Order</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">question type</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">question text</h6>
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
                                        </tr>
                                </table>
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
            var description = $('#description').val().trim();
            $('#description').val(description);

            var table = $('#questions-list').DataTable({
                processing: false,
                serverSide: false,
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                rowReorder: true,
                ajax: "/section_questions?section_id={{ $section->id }}",
                columns: [{
                        data: "order_num",
                        name: 'order_num'
                    },
                    {
                        data: "question_type",
                        name: 'question_type'
                    },
                    {
                        data: "question_text",
                        name: 'question_text'
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
                            table_name: 'questions'
                        }
                    }).done(function() {
                        table.ajax.reload()
                    });

                }

            });

        });
    </script>
@endpush
