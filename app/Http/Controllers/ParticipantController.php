<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Participant;
use App\Models\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ((Helper::check_permission(config('permissions.participants'), 'read'))) {
            if ($request->ajax()) {
                $query = Response::leftJoin('participants', 'participants.id', 'participant_id')
                    ->join('surveys', 'surveys.id', 'survey_id')
                    ->select('responses.id', 'participants.name', 'participants.email', 'surveys.title_en as survey_en', 'surveys.title_ar as survey_ar');
                $table = DataTables::eloquent($query)
                    ->editColumn('id', function ($row) {
                        return $row->id ? $row->id : '';
                    })
                    ->editColumn('name', function ($row) {
                        return $row->name ? $row->name : '<span class="text-danger">SUBMITTED ANONYMOUSLY</span>';
                    })
                    ->editColumn('email', function ($row) {
                        return $row->email ? $row->email : '--';
                    })
                    ->editColumn('survey_ar', function ($row) {
                        return $row->survey_ar ? $row->survey_ar : '';
                    })
                    ->editColumn('survey_en', function ($row) {
                        return $row->survey_en ? $row->survey_en : '';
                    })
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $route = "/participants/show?id=$id";
                        return view('participants.action', compact('id', 'row', 'route'));
                    })->rawColumns(['name'])
                    ->make(true);

                return $table;
            }
            return view('participants.index');
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        if ((Helper::check_permission(config('permissions.participants'), 'read'))) {
            try {
                $id = $request->id;
                $reponseModel = Response::findOrFail($id);
                $answers = Response::join('answers', 'answers.response_id', 'responses.id')
                    ->join('surveys', 'surveys.id', 'responses.survey_id')
                    ->join('questions', 'questions.id', 'answers.question_id')
                    ->leftJoin('participants', 'participants.id', 'participant_id')
                    ->select(
                        'questions.id as question_id',
                        'questions.question_text_en',
                        'questions.question_text_ar',
                        'participants.name',
                        'participants.email',
                        'answers.option_text',
                        'surveys.title_en as survey_en',
                        'surveys.title_ar as survey_ar'
                    )
                    ->where('responses.id', $id)
                    ->get()
                    ->groupBy('question_id');
                return view('participants.show', compact('answers'));
            } catch (ModelNotFoundException $e) {
                $message = 'Cannot find the model';
                $route = route('participants.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Participant $participant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Participant $participant)
    {
        //
    }
}
