@extends('layouts.master')
@section('title', 'Create')
@section('content')

    @php
        $question_id_req = request()->has('question_id') ? request()->query('question_id') : null;
    @endphp

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('options.index') }}" class="text-info">Options</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Add New Option</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('options.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="survey_id">Surveys</label><span class="text-danger">*</span>
                        <select class="form-control" id="survey_id" name="survey_id"
                            onchange="getSections(event.target.value)">
                            <option value="0" disabled selected>-- Select a Survey --</option>
                            @foreach ($surveys as $survey)
                                <option value="{{ $survey->id }}" {{ old('survey_id') == $survey->id ? 'selected' : '' }}>
                                    {{ $survey->title_ar . ' - ' . $survey->title_en }}
                                </option>
                            @endforeach
                        </select>
                        <small id="survey_idHelp" class="form-text text-muted">Enter a proper Survey.</small>
                        @error('survey_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="section_id">Sections</label><span class="text-danger">*</span>
                        <select class="form-control" id="section_id" name="section_id"
                            onchange="getQuestions(event.target.value)" disabled>
                            <option value="0" disabled selected>-- Select a Section --</option>
                        </select>
                        <small id="section_idHelp">Enter a proper Section.</small>
                        @error('section_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-12 mb-3">
                        <label for="question_id">Questions</label><span class="text-danger">*</span>
                        <select class="form-control" id="question_id" name="question_id" disabled>
                            <option value="0" disabled selected>-- Select a Question --</option>
                        </select>
                        <small id="question_idHelp" class="form-text text-muted">Enter a proper Question.</small>
                        @error('question_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="question_id_req" value="{{ $question_id_req }}">

                    <div class="form-group col-6 mb-3">
                        <label for="option_text_ar">Option Text Ar</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="option_text_ar" rows="3" name="option_text_ar" dir=auto></textarea>
                        @error('option_text_ar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="option_text_en">Option Text En</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="option_text_en" rows="3" name="option_text_en" dir=auto></textarea>
                        @error('option_text_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="icon">Icon</label>
                        <input type="file" name="icon" class="dropify" data-max-file-size="2M"
                            data-allowed-file-extensions="png jpg jpeg">
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
            var survey_id = $('#survey_id').val()
            var section_id = $('#section_id').val()
            var question_id = $('#question_id').val()

            if(survey_id && survey_id != 0){
                getSections(survey_id)
            }
        });

        function getSections(survey_id) {
            if (survey_id) {
                $.ajax({
                    url: "{{ route('options.getSections') }}",
                    data: {
                        survey_id: survey_id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success && data.sections.length > 0) {
                            var sections = data.sections;
                            $('#section_id').prop('disabled', false);
                            $('#section_idHelp').removeClass('text-danger').text('Enter a proper Section.');
                            var sectionsSelect = document.getElementById('section_id');
                            sectionsSelect.innerHTML =
                                '<option value="0" disabled selected>-- Select a question --</option>';
                            sections.forEach(function(section) {
                                var option = document.createElement('option');
                                option.value = section.id;
                                option.textContent = section.title_ar + " - " + section
                                .title_en; // Assuming 'text' is the field name for question text
                                sectionsSelect.appendChild(option);
                            });
                        } else {
                            $('#section_id').val(0);
                            $('#section_id').prop('disabled', true);
                            $('#section_idHelp').addClass('text-danger').text(
                                'No sections related to this survey');
                            $('#question_id').val(0);
                            $('#question_id').prop('disabled', true);
                        }
                    }
                })
            }
        }

        function getQuestions(section_id) {
            if (section_id) {
                $.ajax({
                    url: "{{ route('options.getQuestions') }}",
                    data: {
                        section_id: section_id
                    },
                    type: 'POST',
                    success: function(data) {
                        if (data.success && data.questions.length > 0) {
                            var questions = data.questions;
                            $('#question_id').prop('disabled', false);
                            $('#question_idHelp').removeClass('text-danger').text('Enter a proper Question.');
                            var questionsSelect = document.getElementById('question_id');
                            questionsSelect.innerHTML =
                                '<option value="0" disabled selected>-- Select a question --</option>';
                            questions.forEach(function(question) {
                                var option = document.createElement('option');
                                option.value = question.id;
                                option.textContent = question.question_text_ar + "  " + question.question_text_en + " - " + '"' + question.question_type + '"';
                                questionsSelect.appendChild(option);
                            });
                        } else {
                            $('#question_id').prop('disabled', true);
                            $('#question_idHelp').addClass('text-danger').text('No Question related to this section');
                        }
                    }
                })
            }
        }
    </script>
@endpush
