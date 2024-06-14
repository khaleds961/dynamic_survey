@extends('layouts.master')
@section('title', 'Edit')
@section('content')

    @php
        $id = request()->has('id') ? request()->query('id') : null;
    @endphp

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('roles.index') }}" class="text-info">Roles</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Update Role</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('roles.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-12 col-md-6 mb-3">
                        <label for="title">Role<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" aria-describedby="titleHelp"
                            placeholder="Enter Title" name="title" value="{{ old('title',$role->title) }}">
                        <small id="titleHelp" class="form-text text-muted">Enter a clear Role.</small>
                        <br />
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <input type="hidden" name="id" value="{{$id}}">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
@endsection

