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
                <a href="#" class="text-info">Update Survey</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('surveys.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-6 mb-3">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title" value="{{ old('title', $survey->title) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your survey.</small>
                        <br />
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="text-direction">Language</label>
                        <select class="form-control" id="text-direction" name="language">
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
                            name="backgroundColor">
                        <small id="backgroundColor" class="form-text text-muted">Choose a background Color for your
                            survey.</small>
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="mainColor">Main Color</label>
                        <input type="color" class="form-control" id="mainColor" aria-describedby="mainColor"
                            value="{{ isset($survey->property->mainColor) && $survey->property->mainColor ? $survey->property->mainColor : '' }}"
                            name="mainColor">
                        <small class="form-text text-muted">Choose a main Color for your survey.</small>
                    </div>

                    {{-- //invisible --}}
                    <input type="hidden" name="id" value="{{ $survey->id }}">

                    <div class="form-group col-6 mb-3">
                        <label for="font-family-select">Choose a font family:</label>
                        <select id="font-family-select" class="form-control" name="fontFamily">
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
                        <textarea class="form-control resize-none" id="description" rows="3" name="description">{{ old('description', $survey->description) }}</textarea>
                    </div>

                    <div class="form-group col-12 mb-3">
                        <label for="footer">Footer</label><span class="text-danger">*</span>
                        <textarea name="footer" id="editor">{{ isset($survey->property->footer) ? old('footer', $survey->property->footer) : '' }}</textarea>
                        <br>
                        @error('footer')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                </div>

                <button type="submit" class="btn btn-primary">Update</button>

            </form>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script>
        $(document).ready(function() {

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


            document.getElementById('text-direction').addEventListener('change', function() {
                const direction = this.value;
                document.querySelector('.ck-editor__editable').ckeditorInstance.destroy()
                initializeEditor(direction);
            });

            // Initialize the editor with the default direction
            initializeEditor('{{ $lang }}');
            getImages();

            //remove white spaces from description
            var description = $('#description').val().trim();
            $('#description').val(description);



        });
    </script>
@endpush
