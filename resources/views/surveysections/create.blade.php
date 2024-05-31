@extends('layouts.master')
@section('title', 'Store')
@section('content')
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
                <a href="/surveys/show?id={{request()->query('survey_id')}}" class="text-info">Previous Survey</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Add New Survey Section Relation</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('surveysections.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="form-group col-6 mb-3">
                        <label for="text-direction">Sections</label>
                        <select class="form-control" id="text-direction" name="section_id">
                            @foreach ($sections as $section)
                            <option value="{{$section->id}}">{{$section->title}}</option>
                            @endforeach
                        </select>
                        <small>Choose a proper Section.</small>
                    </div>
                    
                    {{-- hidden --}}
                    <input type="hidden" name="survey_id" value="{{request()->query('survey_id')}}">

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
