@extends('layouts.master')
@section('title', 'Create')
@section('content')

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('sections.index') }}" class="text-info">Sections</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Add New Section</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form class="modal-body" action="{{ route('sections.store') }}" method="POST" enctype="multipart/form-data"
                id="store_form">
                @csrf
                <div class="row">

                    <div class="form-group col-12 mb-3">
                        <label for="survey_id">Survey</label><span class="text-danger">*</span>
                        <select class="form-control" id="survey_id" name="survey_id">
                            <option value='0' disabled selected>-- Choose An Option --</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}" {{ old('role_id') == $survey->id ? 'selected' : '' }}>
                                    {{ $survey->title_en . ' - ' . $survey->title_ar }}
                                </option>
                            @endforeach
                        </select>
                        <small id="survey_idHelp" class="form-text text-muted">Choosing a survey is optional.</small>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>Title Ar
                            </span>
                        </label>
                        <input id="title_ar" name="title_ar" type="text" class="form-control" placeholder="Enter Title"
                            value="{{ old('title_ar') }}" />
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your
                            section.</small>
                        <br />
                        @error('title_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>Title En
                            </span>
                        </label>
                        <input id="title_en" name="title_en" type="text" class="form-control" placeholder="Enter Title"
                            value="{{ old('title_en') }}" />
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your
                            section.</small>
                        <br />
                        @error('title_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-4 mb-md-0">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>Description Ar
                            </span>
                        </label>
                        <textarea class="form-control resize-none" id="description_ar" rows="3" name="description_ar"></textarea>
                        <small id="descHelp" class="form-text text-muted">Enter a clear Description for your
                            section.</small>
                        <br />
                        @error('description_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            <span>Description En
                            </span>
                        </label>
                        <textarea class="form-control resize-none" id="description_en" rows="3" name="description_en"></textarea>
                        <small id="descHelp" class="form-text text-muted">Enter a clear Description for your
                            section.</small>
                        <br />
                        @error('description_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="d-flex justify-content-end my-4">
                    <button class="btn btn-primary btn-add-event" id="save_section">
                        Submit
                    </button>
                </div>

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

            // document.getElementById('text-direction').addEventListener('change', function() {
            //     const direction = this.value;
            //     document.querySelector('.ck-editor__editable').ckeditorInstance.destroy()
            //     initializeEditor(direction);
            // });

            // Initialize the editor with the default direction (LTR)
            initializeEditor('en');
            initializeEditorAr('ar');
        });
    </script>
@endpush
