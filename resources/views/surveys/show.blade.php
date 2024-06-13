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
                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="title_ar">Title Ar</label>
                    <input type="text" class="form-control" id="title_ar" aria-describedby="titleHelp" name="title_ar"
                        value="{{ old('title_ar', $survey->title_ar) }}" disabled>
                </div>

                <div class="form-group col-sm-12 col-md-6 mb-3">
                    <label for="title_en">Title En</label>
                    <input type="text" class="form-control" id="title_en" aria-describedby="titleHelp" name="title_en"
                        value="{{ old('title_en', $survey->title_en) }}" disabled>
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

                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
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

                    <div class="form-group col-sm-12 col-md-3 mb-3">
                        <div class="col-12">
                            <label>Make it Wizard Survey.</label>
                        </div>
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="wizard" id="success2-radio"
                                    value="1" disabled
                                    {{ isset($survey->property->wizard) && $survey->property->wizard == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success2-radio">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="wizard" id="success3-radio"
                                    value="0" disabled
                                    {{ isset($survey->property->wizard) && $survey->property->wizard == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success3-radio">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 mb-3">
                        <div class="col-md-12">
                            <label>Participant Info Required </label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="show_personal"
                                    id="success2-radio" value="1" disabled
                                    {{ isset($survey->property->show_personal) && $survey->property->show_personal == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success2-radio">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="show_personal"
                                    id="success3-radio" value="0" disabled
                                    {{ isset($survey->property->show_personal) && $survey->property->show_personal == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success3-radio">No</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="description_ar">Description Ar</label>
                    <textarea class="form-control resize-none" id="description_ar" rows="3" name="description_ar" disabled>{{ old('description_ar', $survey->description_ar) }}</textarea>
                </div>

                <div class="form-group col-6 mb-3">
                    <label for="description_en">Description En</label>
                    <textarea class="form-control resize-none" id="description_en" rows="3" name="description_en" disabled>{{ old('description_en', $survey->description_en) }}</textarea>
                </div>

                <div class="form-group col-12 col-md-6 mb-3">
                    <label for="footer_ar">Footer Ar</label><br>
                    <div class="border p-4 mt-2">
                        {!! isset($survey->property->footer_ar) ? old('footer_ar', $survey->property->footer_ar) : '' !!}
                    </div>
                </div>

                <div class="form-group col-12 col-md-6  mb-3">
                    <label for="footer_en">Footer En</label><br>
                    <div class="border p-4 mt-2">
                        {!! isset($survey->property->footer_en) ? old('footer_en', $survey->property->footer_en) : '' !!}
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between my-2">
                        <h4>Sections</h4>
                        @if(Helper::check_permission(config('permissions.surveys'), 'write'))
                        <a type="button" class="btn mb-1 waves-effect waves-light btn-light text-dark fs-4 mx-0 mx-md-2"
                            href="/surveysections/create?survey_id={{ $survey->id }}">
                            <i class="ti ti-circle-plus"></i>
                            <span>Add New Survey Section Relation</span>
                        </a>
                        @endif
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
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title Ar</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">title en</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">description ar</h6>
                                            </th>
                                            <th>
                                                <h6 class="fs-4 fw-semibold mb-0 text-uppercase">description en</h6>
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
            var description_en = $('#description_en').val().trim();
            $('#description_en').val(description_en);

            //remove white spaces from description
            var description_ar = $('#description_ar').val().trim();
            $('#description_ar').val(description_ar);

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
                        data: "title_ar",
                        name: 'title_ar'
                    },
                    {
                        data: "title_en",
                        name: 'title_en'
                    },
                    {
                        data: "description_ar",
                        name: 'description_ar'
                    },
                    {
                        data: "description_en",
                        name: 'description_en'
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
