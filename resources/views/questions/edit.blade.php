@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    @php
        $section_id_req = request()->has('section_id') ? request()->query('section_id') : null;
    @endphp

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
                <a href="#" class="text-info">Update Question</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('questions.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="section_id">Section</label><span class="text-danger">*</span>
                        <select class="form-control" id="section_id" name="section_id">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id', $question->section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->title_ar ? $section->title_ar .' - '.$section->title_en : $section->title_en }}</option>
                            @endforeach
                        </select>
                        <small id="section_idHelp" class="form-text text-muted">Enter a proper Section.</small>
                        @error('section_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- //secrect --}}
                    <input type="hidden" value="{{ $question->id }}" name="id">
                    <input type="hidden" value="{{ $section_id_req }}" name="section_id_req">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="question_type">Question Type</label><span class="text-danger">*</span>
                        <select class="form-control" id="question_type" name="question_type">
                            <option value="text"
                                {{ old('question_type', $question->question_type) == 'text' ? 'selected' : '' }}>Text
                            </option>
                            <option value="multiple_choices"
                                {{ old('question_type', $question->question_type) == 'multiple_choices' ? 'selected' : '' }}>
                                Multiple Choice</option>
                            <option value="option"
                                {{ old('question_type', $question->question_type) == 'option' ? 'selected' : '' }}>Option
                            </option>
                            <option value="select"
                                {{ old('question_type', $question->question_type) == 'select' ? 'selected' : '' }}>Select
                            </option>
                        </select>
                        @error('question_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="question_text_ar">Question Text Ar</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="question_text_ar" rows="3" name="question_text_ar">{{ old('question_text_ar', $question->question_text_ar) }}</textarea>
                        @error('question_text_ar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="question_text_en">Question Text En</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="question_text_en" rows="3" name="question_text_en">{{ old('question_text_en', $question->question_text_en) }}</textarea>
                        @error('question_text_en')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 mb-3">
                        <div class="col-md-12">
                            <label>Question Required</label>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="required" id="success2-radio" value="1" {{ old('required',$question->required) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success2-radio">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input primary" type="radio" name="required" id="success3-radio" value="0" {{ old('required',$question->required) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="success3-radio">No</label>
                            </div>
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

            //remove white spaces from description
            var question_text_ar = $('#question_text_ar').val().trim();
            $('#question_text_ar').val(question_text_ar);

            //remove white spaces from description
            var question_text_en = $('#question_text_en').val().trim();
            $('#question_text_en').val(question_text_en);
        });
    </script>
@endpush
