@extends('layouts.master')
@section('title', 'Update')
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
            {{-- <li class="breadcrumb-item">
                <a href="/surveys/show?id={{request()->query('survey_id')}}" class="text-info">Previous Survey</a>
            </li> --}}
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Update Section Survey Relation</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <form action="{{ route('surveysections.update') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="form-group col-6 mb-3">
                        <label for="text-direction">Sections</label>
                        <select class="form-control" id="text-direction" name="section_id">
                            @foreach ($sections as $section)
                            <option value="{{$section->id}}" {{ request()->query('section_id') == $section->id ? 'selected' : '' }}>
                                {{$section->title_ar ? $section->title_ar.' - '.$section->title_en : $section->title_en}}
                            </option>
                            @endforeach
                        </select>
                        <small>update Section.</small>
                    </div>
                    
                    {{-- hidden --}}
                    <input type="hidden" name="survey_section_id" value="{{request()->query('id')}}">

                </div>

                <button type="submit" class="btn btn-primary">Update</button>

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
