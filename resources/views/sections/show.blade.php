@extends('layouts.master')
@section('title', 'Show')
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
                    <label for="title_ar">Title Ar</label>
                    <input type="text" class="form-control" id="title_ar" aria-describedby="titleHelp"
                        placeholder="Enter Title" name="title_ar" value="{{ $section->title_ar }}" disabled>
                    <br />
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="title_en">Title En</label>
                    <input type="text" class="form-control" id="title_en" aria-describedby="titleHelp"
                        placeholder="Enter Title" name="title_en" value="{{ $section->title_en }}" disabled>
                    <br />
                </div>

                {{-- //invisible --}}
                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="form-group col-6 mb-3">
                    <label for="description_ar">Description Ar</label>
                    <textarea class="form-control resize-none" id="description_ar" rows="3" name="description_ar" disabled>{{ old('description_ar', $section->description_ar) }}</textarea>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="description_en">Description En</label>
                    <textarea class="form-control resize-none" id="description_en" rows="3" name="description_en" disabled>{{ old('description_en', $section->description_en) }}</textarea>
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
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">question text ar</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">question text en</h6>
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
            var description_ar = $('#description_ar').val().trim();
            $('#description_ar').val(description_ar);
            //remove white spaces from description
            var description_en = $('#description_en').val().trim();
            $('#description_en').val(description_en);

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
                        data: "question_text_ar",
                        name: 'question_text_ar'
                    },
                    {
                        data: "question_text_en",
                        name: 'question_text_en'
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
