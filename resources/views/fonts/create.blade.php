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
                <a href="{{ route('fonts.index') }}" class="text-info">Fonts</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Add New Font</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('fonts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="title">Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title" value="{{ old('title') }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear title for your font.</small>
                        <br />
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="normal">Normal Font<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="normal" aria-describedby="normalHelp"
                            name="normal">
                        <small id="normalHelp" class="form-text text-muted">Supported files: .ttf, .otf, .woff, .woff2,
                            .eot.</small>
                        <br />
                        @error('normal')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="light">Light Font</label>
                        <input type="file" class="form-control" id="light" aria-describedby="lightHelp"
                            name="light">
                        <small id="lightHelp" class="form-text text-muted">Supported files: .ttf, .otf, .woff, .woff2,
                            .eot.</small>
                        <br />
                        @error('light')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="bold">Bold Font</label>
                        <input type="file" class="form-control" id="bold" aria-describedby="boldHelp"
                            name="bold">
                        <small id="boldHelp" class="form-text text-muted">Supported files: .ttf, .otf, .woff, .woff2,
                            .eot.</small>
                        <br />
                        @error('bold')
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

        });
    </script>
@endpush
