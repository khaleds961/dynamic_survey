@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    @php
        $question_id_req = request()->has('question_id') ? request()->query('question_id') : null;
        $icon = isset($option->icon) ? asset('storage/' . $option->icon) : asset('storage/images/not-av.png');
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
                <a href="#" class="text-info">Update Option</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('options.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-12 mb-3">
                        <label for="question_id">Question</label><span class="text-danger">*</span>
                        <select class="form-control" id="question_id" name="question_id">
                            @foreach ($questions as $question)
                                <option value="{{ $question->id }}"
                                    {{ old('question_id', $option->question_id) == $question->id ? 'selected' : '' }}>
                                    {{ $question->question_text }}</option>
                            @endforeach
                        </select>
                        <small id="question_idHelp" class="form-text text-muted">Enter a proper Question.</small>
                        @error('question_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- //secrect --}}
                    <input type="hidden" value="{{ $option->id }}" name="id">
                    <input type="hidden" value="{{ $question_id_req }}" name="question_id_req">



                    <div class="form-group col-6 mb-3">
                        <label for="option_text">Option Text</label><span class="text-danger">*</span>
                        <textarea class="form-control resize-none" id="option_text" rows="3" name="option_text" dir="auto">{{ old('option_text', $option->option_text) }}</textarea>
                        @error('option_text')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="icon">Icon</label>
                        <div id="icon">
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

            function getImages() {
                var iconPath = '{{ $icon }}';
                $('#icon').append(`<input type="file" name="editIcon" class="dropify" data-max-file-size="2M"
                                    data-allowed-file-extensions="png jpg jpeg">`);
                $('.dropify').attr('data-default-file', iconPath);
                $('.dropify').dropify();
            }

            getImages()

            //remove white spaces from description
            var question_text = $('#question_text').val().trim();
            $('#question_text').val(question_text);
        });
    </script>
@endpush
