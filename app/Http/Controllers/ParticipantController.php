<?php

namespace App\Http\Controllers;

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
        if ($request->ajax()) {
            $query = Response::leftJoin('participants', 'participants.id', 'participant_id')
                ->join('surveys', 'surveys.id', 'survey_id')
                ->select('responses.id', 'participants.name', 'participants.email', 'surveys.title as survey');
            $table = DataTables::eloquent($query)
                ->addColumn('id', function ($row) {
                    return $row->id ? $row->id : '';
                })
                ->addColumn('name', function ($row) {
                    return $row->name ? $row->name : '<span class="text-danger">SUBMITTED ANONYMOUSLY</span>';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ? $row->email : '--';
                })
                ->addColumn('survey', function ($row) {
                    return $row->survey ? $row->survey : '';
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
        try {
            $id = $request->id;
            $reponseModel = Response::findOrFail($id);
            $answers = Response::join('answers', 'answers.response_id', 'responses.id')
                ->join('surveys','surveys.id','responses.survey_id')
                ->join('questions', 'questions.id', 'answers.question_id')
                ->leftJoin('participants', 'participants.id', 'participant_id')
                ->select(
                    'questions.id as question_id',
                    'questions.question_text',
                    'participants.name',
                    'participants.email',
                    'answers.option_text',
                    'surveys.title as survey'
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
