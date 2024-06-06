@extends('layouts.master')
@section('title', 'Create')
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
                <a href="#" class="text-info">Add New Survey</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('surveys.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title" value="{{ old('title') }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your survey.</small>
                        <br />
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="text-direction">Language</label>
                        <select class="form-control" id="text-direction" name="language">
                            <option value="en">English</option>
                            <option value="ar">Arabic</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" class="dropify" data-max-file-size="2M"
                            data-allowed-file-extensions="png jpg jpeg">
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="backgroundImage">Background Image</label>
                        <input type="file" name="backgroundImage" class="dropify" data-max-file-size="2M"
                            data-allowed-file-extensions="png jpg jpeg">
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="backgroundColor">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColor" aria-describedby="backgroundColor"
                            name="backgroundColor">
                        <small id="backgroundColor" class="form-text text-muted">Choose a background Color for your
                            survey.</small>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="mainColor">Main Color</label>
                        <input type="color" class="form-control" id="mainColor" aria-describedby="mainColor"
                            name="mainColor">
                        <small class="form-text text-muted">Choose a main Color for your survey.</small>
                    </div>


                    {{-- col4 --}}
                    <div class="d-md-flex align-items-center">
                        <div class="w-100 mb-3">
                            <label for="font-family-select">Choose a font family:</label>
                            <select id="font-family-select" class="form-control" name="fontFamily">
                                @foreach ($fonts as $font)
                                    <option value="{{ $font['value'] }}">
                                        {{ $font['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-100 mb-3 mx-4">
                            <div class="col-md-4">
                                <label>Make it Wizard Survey.</label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="wizard"
                                        id="success2-radio" value="1">
                                    <label class="form-check-label" for="success2-radio">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="wizard"
                                        id="success3-radio" value="0" checked>
                                    <label class="form-check-label" for="success3-radio">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 mb-3">
                            <div class="col-md-4">
                                <label>Participant Info Required </label>
                            </div>
                            <div class="col-md-8">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="show_participant"
                                        id="success2-radio" value="1">
                                    <label class="form-check-label" for="success2-radio">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="wizard"
                                        id="success3-radio" value="0" checked>
                                    <label class="form-check-label" for="success3-radio">No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- col4 --}}

                    <div class="form-group col-12 mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control resize-none" id="description" rows="3" name="description"></textarea>
                    </div>

                    <div class="form-group col-12 mb-3">
                        <label for="footer">Footer</label><span class="text-danger">*</span>
                        <textarea name="footer" id="editor">{{ old('footer') }}</textarea>
                        <br>
                        @error('footer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });

            // ClassicEditor
            // .create(document.querySelector('#editor'))
            // .catch(error => {
            //     console.error(error);
            // });


            async function initializeEditor(language) {

                ClassicEditor
                    .create(document.querySelector('#editor'), {
                        toolbar: [
                            'heading', '|',
                            'bold', 'italic', '|',
                            'link', 'bulletedList', 'numberedList', '|',
                            'blockQuote', 'insertTable', 'undo', 'redo', '|',
                            'alignment:left', 'alignment:center', 'alignment:right',
                            'alignment:justify',
                            'language'
                        ],
                        language: language, // UI language
                        contentsLangDirection: language == 'en' ? 'ltr' :
                            'rtl' // Text direction for the content
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            document.getElementById('text-direction').addEventListener('change', function() {
                const direction = this.value;
                document.querySelector('.ck-editor__editable').ckeditorInstance.destroy()
                initializeEditor(direction);
            });

            // Initialize the editor with the default direction (LTR)
            initializeEditor('en');
        });
    </script>
@endpush
