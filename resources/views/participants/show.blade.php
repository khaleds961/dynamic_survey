@extends('layouts.master')
@section('title', 'Show')
@section('content')

    @php
        $answer = $answers->first();
        $name = isset($answer[0]['name']) ? $answer[0]['name'] : 'SUBMITTED ANONYMOUSLY';
        $email = $answer[0]['email'] ? $answer[0]['email'] : 'SUBMITTED ANONYMOUSLY';
        $survey_ar = $answer[0]['survey_ar'];
        $survey_en = $answer[0]['survey_en'];
    @endphp

    {{-- BreadCrumbs --}}
    <nav aria-label="breadcrumb" class="mb-1">
        <ol class="breadcrumb border border-warning px-3 py-2 rounded">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" class="text-info d-flex align-items-center"><i
                        class="ti ti-home fs-4 mt-1"></i></a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('participants.index') }}" class="text-info">Participants</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#" class="text-info">Participant Answers</a>
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="my-4">
            <div class="row">

                <div class="row">
                    <div class="col-12">

                        <div class="text-white mx-1 p-2 my-3 row rounded personal-info">
                            <div class="text-white col-12 col-md-4 border p-2">Name: {{ $name }}</div>
                            <div class="text-white col-12 col-md-4 border p-2">Email: {{ $email }}</div>
                            <div class="text-white col-12 col-md-4 border p-2">Survey Title:
                                {{ $survey_ar ? $survey_ar . ' - ' . $survey_en : $survey_en }}</div>
                        </div>

                        @foreach ($answers as $questionId => $groupedAnswers)
                            <div class="card p-4" style="background-color: #E6E6FA">
                                <h4 class="text-dark">
                                    {{ $groupedAnswers->first()->question_text_ar ? $groupedAnswers->first()->question_text_ar .' - '. $groupedAnswers->first()->question_text_en : $groupedAnswers->first()->question_text_en}}</h4>
                                @foreach ($groupedAnswers as $answer)
                                    <h5 class="text-dark">- {{ $answer->option_text }}</h5>
                                @endforeach
                            </div>
                        @endforeach

                    </div>

                </div>

            </div>
        </div>
    </div>

    <hr>


@endsection
