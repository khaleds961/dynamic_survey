@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    @php
        $lang = isset($survey->property->language) ? $survey->property->language : '';
        $logo = isset($survey->property->logo)
            ? asset('storage/app/public/' . $survey->property->logo)
            : asset('storage/app/public/images/not-av.png');
        $backgroundImage = isset($survey->property->backgroundImage)
            ? asset('storage/app/public/' . $survey->property->backgroundImage)
            : asset('storage/app/public/images/not-av.png');
        $logoFooter = isset($survey->property->logoFooter)
            ? asset('storage/app/public/' . $survey->property->logoFooter)
            : asset('storage/app/public/images/not-av.png');
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
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="title_ar">Title Ar<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title_ar" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title_ar" value="{{ old('title_ar', $survey->title_ar) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your survey.</small>
                        <br />
                        @error('title_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="title_en">Title En<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title_en" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title_en" value="{{ old('title_en', $survey->title_en) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your survey.</small>
                        <br />
                        @error('title_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- <div class="form-group col-sm-12 col-md-6 mb-3">
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
                    </div> --}}

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="logo">Logo <span class="text-danger">(should be without background -
                                PNG,JPG,JPEG)</span></label>
                        <input type="hidden" name="keepLogoImage" value="1">
                        <div id="logo">
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="backgroundImage">Background Image <span class="text-danger">(Dimessions-1920px*1080px -
                                PNG,JPG,JPEG)</span></label>
                        <div id="backgroundImage">
                        </div>
                        <input type="hidden" name="keepBackgroundImage" value="1">
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="backgroundColor">Background Color</label>
                        <input type="color" class="form-control" id="backgroundColor" aria-describedby="backgroundColor"
                            value="{{ isset($survey->property->backgroundColor) && $survey->property->backgroundColor ? $survey->property->backgroundColor : '' }}"
                            name="backgroundColor">
                        <small id="backgroundColor" class="form-text text-muted">Choose a background Color for your
                            survey.</small>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="mainColor">Main Color</label>
                        <input type="color" class="form-control" id="mainColor" aria-describedby="mainColor"
                            value="{{ isset($survey->property->mainColor) && $survey->property->mainColor ? $survey->property->mainColor : '' }}"
                            name="mainColor">
                        <small class="form-text text-muted">Choose a main Color for your survey.</small>
                    </div>

                    {{-- //invisible --}}
                    <input type="hidden" name="id" value="{{ $survey->id }}">

                    <div class="row">
                        <div class="form-group col-sm-12 col-md-6 mb-3">
                            <label for="font-family-select">Choose a font family:</label>
                            <select id="font-family-select" class="form-control" name="fontFamily">
                                @foreach ($fonts as $font)
                                    <option value="{{ $font['id'] }}"
                                        {{ isset($survey->property->fontFamily) && $survey->property->fontFamily == $font['id'] ? 'selected' : '' }}>
                                        {{ $font['title'] }}
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
                                    <input class="form-check-input primary" type="radio" name="wizard"
                                        id="success2-radio" value="1"
                                        {{ isset($survey->property->wizard) && $survey->property->wizard == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="success2-radio">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="wizard"
                                        id="success3-radio" value="0"
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
                                        id="success2-radio" value="1"
                                        {{ isset($survey->property->show_personal) && $survey->property->show_personal == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="success2-radio">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input primary" type="radio" name="show_personal"
                                        id="success3-radio" value="0"
                                        {{ isset($survey->property->show_personal) && $survey->property->show_personal == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="success3-radio">No</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="description_ar">Description Ar</label>
                        <textarea class="form-control resize-none" id="description_ar" rows="3" name="description_ar">
                            {{ old('description_ar', $survey->description_ar) }}
                        </textarea>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="description_en">Description En</label>
                        <textarea class="form-control resize-none" id="description_en" rows="3" name="description_en">
                            {{ old('description_en', $survey->description_en) }}
                        </textarea>
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="footer_ar">Footer Ar</label>
                        <textarea name="footer_ar" id="editor_ar">{{ isset($survey->property->footer_ar) ? old('footer_ar', $survey->property->footer_ar) : '' }}</textarea>
                        <br>
                        @error('footer_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="footer_en">Footer En</label>
                        <textarea name="footer_en" id="editor_en">{{ isset($survey->property->footer_en) ? old('footer_en', $survey->property->footer_en) : '' }}</textarea>
                        <br>
                        @error('footer_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 mb-3">
                        <label for="logoFooter">Footer Logo <span class="text-danger">(should be without background -
                                PNG,JPG,JPEG)</span></label>
                        <input type="hidden" name="keepFooterImage" value="1">
                        <div id="logoFooter">
                        </div>
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
                    .create(document.querySelector('#editor_en'), {
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

            async function initializeEditorAr(language) {

                ClassicEditor
                    .create(document.querySelector('#editor_ar'), {
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
                var logoFooterPath = '{{ $logoFooter }}';

                $('#logo').append(`<input type="file" name="editLogo" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', logoPath);
                $('.dropify').dropify();

                $('#backgroundImage').append(`<input type="file" name="editBackgroundImage" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', backgroundPath);
                $('.dropify').dropify();

                $('#logoFooter').append(`<input type="file" name="editLogoFooter" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', logoFooterPath);
                $('.dropify').dropify();

            }

            // document.getElementById('text-direction').addEventListener('change', function() {
            //     const direction = this.value;
            //     document.querySelector('.ck-editor__editable').ckeditorInstance.destroy()
            //     initializeEditor(direction);
            // });

            // Initialize the editor with the default direction
            initializeEditor('en');
            initializeEditorAr('ar');
            getImages();

            //remove white spaces from description
            var description_en = $('#description_en').val().trim();
            $('#description_en').val(description_en);
            //remove white spaces from description
            var description_ar = $('#description_ar').val().trim();
            $('#description_ar').val(description_ar);

            $('.dropify-clear').on('click', function(e) {
                e.preventDefault();
                const inputElement = $(this).closest('.dropify-wrapper').find('input[type="file"]');
                const inputName = inputElement.attr('name');
                // Set the corresponding hidden input field to indicate removal
                if (inputName === 'editBackgroundImage') {
                    $('input[name="keepBackgroundImage"]').val('0');
                } else if (inputName === 'editLogo') {
                    $('input[name="keepLogoImage"]').val('0');
                } else if (inputName === 'editLogoFooter') {
                    $('input[name="keepFooterImage"]').val('0');
                }
            })

        });
    </script>
@endpush
