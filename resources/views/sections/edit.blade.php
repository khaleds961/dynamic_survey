@extends('layouts.master')
@section('title', 'Show')
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
                <a href="#" class="text-info">Update Section</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('sections.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-6 mb-3">
                        <label for="title_ar">Title Ar</label>
                        <input type="text" class="form-control" id="title_ar" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title_ar" value="{{ old('title_ar', $section->title_ar) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your section.</small>
                        <br />
                        @error('title_ar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="title_en">Title En</label>
                        <input type="text" class="form-control" id="title_en" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title_en" value="{{ old('title_en', $section->title_en) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your section.</small>
                        <br />
                        @error('title_en')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- //invisible --}}
                    <input type="hidden" name="id" value="{{ $section->id }}">


                    <div class="form-group col-6 mb-3">
                        <label for="description_ar">Description Ar</label>
                        <textarea class="form-control resize-none" id="description_ar" rows="3" name="description_ar">{{ old('description_ar', $section->description_ar) }}</textarea>
                    </div>

                    <div class="form-group col-6 mb-3">
                        <label for="description_en">Description En</label>
                        <textarea class="form-control resize-none" id="description_en" rows="3" name="description_en">{{ old('description_en', $section->description_en) }}</textarea>
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
            var description_en = $('#description_en').val().trim();
            $('#description_en').val(description_en);
            //remove white spaces from description
            var description_ar = $('#description_ar').val().trim();
            $('#description_ar').val(description_ar);

        });
    </script>
@endpush
