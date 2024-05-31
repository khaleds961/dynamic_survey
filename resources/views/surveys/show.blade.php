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


    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('surveys.index') }}" class="text-info">Surveys</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Show Survey</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <div class="row">
                <div class="form-group col-6 mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                        placeholder="Enter Title" name="title" value="{{ $survey->title }}" disabled>
                    <br />
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="text-direction">Language</label>
                    <select class="form-control" id="text-direction" name="language" disabled>
                        <option value="en"
                            {{ isset($survey->property->language) && $survey->property->language == 'en' ? 'selected' : '' }}>
                            English</option>
                        <option value="ar"
                            {{ isset($survey->property->language) && $survey->property->language == 'ar' ? 'selected' : '' }}>
                            Arabic
                        </option>
                    </select>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="logo">Logo</label>
                    <div id="logo">
                    </div>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="backgroundImage">Background Image</label>
                    <div id="backgroundImage">
                    </div>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="backgroundColor">Background Color</label>
                    <input type="color" class="form-control" id="backgroundColor" aria-describedby="backgroundColor"
                        value="{{ isset($survey->property->backgroundColor) && $survey->property->backgroundColor ? $survey->property->backgroundColor : '' }}"
                        name="backgroundColor" disabled>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="mainColor">Main Color</label>
                    <input type="color" class="form-control" id="mainColor" aria-describedby="mainColor"
                        value="{{ isset($survey->property->mainColor) && $survey->property->mainColor ? $survey->property->mainColor : '' }}"
                        name="mainColor" disabled>
                </div>

                {{-- //invisible --}}
                <input type="hidden" name="id" value="{{ $survey->id }}">

                <div class="form-group col-6 mb-3">
                    <label for="font-family-select">Choose a font family:</label>
                    <select id="font-family-select" class="form-control" name="fontFamily" disabled>
                        @foreach ($fonts as $font)
                            <option value="{{ $font['value'] }}"
                                {{ isset($survey->property->fontFamily) && $survey->property->fontFamily == $font['value'] ? 'selected' : '' }}>
                                {{ $font['name'] }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="description">Description</label>
                    <textarea class="form-control resize-none" id="description" rows="3" name="description" disabled>{{ old('description', $survey->description) }}</textarea>
                </div>

                <div class="form-group col-12 mb-3">
                    <label for="footer">Footer</label><br>
                    <div class="border p-4 mt-2">
                        {!! isset($survey->property->footer) ? old('footer', $survey->property->footer) : '' !!}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between my-2">
                        <h4>Sections</h4>
                        <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                            href="/surveysections/create?survey_id={{ $survey->id }}">
                            <i class="ti ti-circle-plus"></i>
                            <span>Add New Survey Section Relation</span>
                        </a>
                    </div>
                    <div class="card">
                        <div class="table-responsive rounded-2 my-2">
                            <div class="table-responsive mx-4">
                                <table id="sections-list"
                                    class="table border table-striped table-bordered display text-nowrap">
                                    <thead>
                                        <!-- start row -->
                                        <tr>
                                            {{-- <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">#</h6>
                                            </th> --}}
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">Order</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">description</h6>
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
                                            {{-- <td></td> --}}
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

                    <!-- BEGIN EDIT MODAL -->
                    <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateEventModalLabel">
                                        Update Section
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form class="modal-body" action="{{ route('sections.update') }}" method="POST"
                                    id="update_form">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-6">
                                            <label class="form-label d-flex justify-content-between align-items-center">
                                                <span>Title
                                                </span>
                                            </label>
                                            <input id="edit_title" name="edit_title" type="text"
                                                class="form-control" />
                                            <span id="edit_title_error" class="text-danger"></span>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label d-flex justify-content-between align-items-center">
                                                <span>Description
                                                </span>
                                            </label>
                                            <textarea class="form-control resize-none" id="edit_description" rows="3" name="edit_description"></textarea>
                                            <span id="edit_description_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                    {{-- //secret --}}
                                    <input type="hidden" name="id" id="section_id">
                                    <div class="d-flex justify-content-end my-4">
                                        <button class="btn btn-primary btn-add-event" id="update_section">
                                            Update
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END MODAL -->
                </div>

            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {

            function getImages() {
                var logoPath = '{{ $logo }}';
                var backgroundPath = '{{ $backgroundImage }}';

                $('#logo').append(`<input type="file" name="editLogo" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', logoPath);
                $('.dropify').dropify();

                $('#backgroundImage').append(`<input type="file" name="editBackgroundImage" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', backgroundPath);
                $('.dropify').dropify();
            }

            getImages();

            //remove white spaces from description
            var description = $('#description').val().trim();
            $('#description').val(description);

            var table = $('#sections-list').DataTable({
                processing: false, // Disable server-side processing temporarily
                serverSide: false, // Disable server-side processing temporarily
                scrollY: '100%',
                scrollCollapse: true,
                paging: true,
                responsive: true,
                rowReorder: true,
                ajax: "/surveysections?survey_id={{ $survey->id }}",
                columns: [{
                        data: "order_num",
                        name: 'order_num'
                    },
                    {
                        data: "title",
                        name: 'title'
                    },
                    {
                        data: "description",
                        name: 'description'
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
                            table_name: 'survey_sections'
                        }
                    }).done(function() {
                        table.ajax.reload()
                    });

                }

            });

        });
    </script>
@endpush
