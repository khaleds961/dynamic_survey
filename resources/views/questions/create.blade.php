@extends('layouts.master')
@section('title', 'Create')
@section('content')

    @php
        $section_id = request()->has('section_id') ? request()->query('section_id') : null;
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
                <a href="#" class="text-info">Add New Question</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="section_id">Section</label><span class="text-danger">*</span>
                        <select class="form-control" id="section_id" name="section_id">
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}"
                                    {{ old('section_id', $section_id) == $section->id ? 'selected' : '' }}>
                                    {{ $section->title }}
                                </option>
                            @endforeach
                        </select>
                        <small id="section_idHelp" class="form-text text-muted">Enter a proper Section.</small>
                        @error('section_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <input type="hidden" name="check_request" value="{{ $section_id }}">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="question_type">Question Type</label><span class="text-danger">*</span>
                        <select class="form-control" id="question_type" name="question_type">
                            <option value="text" {{ old('question_type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="multiple_choices"
                                {{ old('question_type') == 'multiple_choices' ? 'selected' : '' }}>Multiple Choice</option>
                            <option value="option" {{ old('question_type') == 'option' ? 'selected' : '' }}>Option</option>
                        </select>
                        @error('question_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="question_text">Question Text</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="question_text" rows="3" name="question_text"></textarea>
                        @error('question_text')
                            <span class="text-danger">{{ $message }}</span>
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

        });
    </script>
@endpush
