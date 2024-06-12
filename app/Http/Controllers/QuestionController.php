<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Section;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\GeneralFunctions;
use Illuminate\Support\Str;



class QuestionController extends Controller
{

    use GeneralFunctions;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Question::with('section');
            $table = DataTables::eloquent($query)
                ->editColumn('id', function ($row) {
                    return $row->id ? $row->id : '';
                })
                ->addColumn('section_id', function ($row) {
                    return $row->section_id ? $row->section_id : '';
                })
                ->addColumn('section_en', function ($row) {
                    if ($row->section && $row->section->title_en) {
                        return $row->section->title_en;
                    } else {
                        return '';
                    }
                })
                ->addColumn('section_ar', function ($row) {
                    if ($row->section && $row->section->title_ar) {
                        return $row->section->title_ar;
                    } else {
                        return '';
                    }
                })
                ->editColumn('question_type', function ($row) {
                    switch ($row->question_type) {
                        case 'text':
                            return 'Text';
                        case 'multiple_choices':
                            return 'Multiple Choices';
                        case 'select':
                            return 'Select';
                        default:
                            return 'Option';
                    }
                })
                ->editColumn('question_text_ar', function ($row) {
                    if ($row->question_text_ar && strlen($row->question_text_ar) > 60) {
                        return Str::limit($row->question_text_ar, 60);
                    } else {
                        return $row->question_text_ar;
                    }
                })
                ->editColumn('question_text_en', function ($row) {
                    if ($row->question_text_en && strlen($row->question_text_en) > 60) {
                        return Str::limit($row->question_text_en, 60);
                    } else {
                        return $row->question_text_en;
                    }
                })
                ->addColumn('is_active', function ($row) {
                    $action = "is_active";
                    $checked_flag = $row->is_active;
                    $id = $row->id;
                    $title = $row->title;
                    $table_name = 'questions';
                    return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                })
                ->addColumn('action', function ($row) {
                    $table_name = 'questions';
                    $id = $row->id;
                    $model = 'Question';
                    $href = "/questions/edit?id=$id";
                    $route = "/questions/show?id=$id";
                    return view('questions.action', compact('id', 'table_name', 'row', 'model', 'href', 'route'));
                })
                ->make(true);

            return $table;
        }

        return view('questions.index');
    }

    public function section_questions(Request $request)
    {
        if ($request->ajax()) {
            $query = Question::where('section_id', $request->section_id);
            $table = DataTables::eloquent($query)
                ->addColumn('id', function ($row) {
                    return $row->id ? $row->id : '';
                })
                ->addColumn('section_id', function ($row) {
                    return $row->section_id ? $row->section_id : '';
                })
                ->addColumn('section', function ($row) {
                    if ($row->section && $row->section->title) {
                        return $row->section->title;
                    } else {
                        return '';
                    }
                })
                ->addColumn('question_text_ar', function ($row) {
                    if ($row->question_text_ar && strlen($row->question_text_ar) > 60) {
                        return Str::limit($row->question_text_ar, 60);
                    } else {
                        return $row->question_text_ar;
                    }
                })
                ->addColumn('question_text_en', function ($row) {
                    if ($row->question_text_en && strlen($row->question_text_en) > 60) {
                        return Str::limit($row->question_text_en, 60);
                    } else {
                        return $row->question_text_en;
                    }
                })
                ->addColumn('order_num', function ($row) {
                    return $row->order_num ? $row->order_num : 0;
                })
                ->addColumn('question_type', function ($row) {
                    switch ($row->question_type) {
                        case 'text':
                            return 'Text';
                        case 'multiple_choices':
                            return 'Multiple Choices';
                        case 'select':
                            return 'Select';
                        default:
                            return 'Option';
                    }
                })
                ->addColumn('is_active', function ($row) {
                    $action = "is_active";
                    $checked_flag = $row->is_active;
                    $id = $row->id;
                    $title = $row->title;
                    $table_name = 'questions';
                    return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                })
                ->addColumn('action', function ($row) {
                    $table_name = 'questions';
                    $id = $row->id;
                    $model = 'Question';
                    $href = "/questions/edit?id=$id&section_id=$row->section_id";
                    return view('questions.action', compact('id', 'table_name', 'row', 'model', 'href'));
                })
                ->make(true);

            return $table;
        }

        return view('sections.show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('questions.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'section_id' => 'required|integer',
                'question_type' => 'required',
                'question_text_ar' => 'required|max:255',
                'question_text_en' => 'required|max:255'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $newOrderNum = $this->arrangeOrderNumber('questions', 'section_id', $request->section_id);

            $question = Question::create([
                'section_id' => $request->section_id,
                'question_type' => $request->question_type,
                'question_text_ar' => $request->question_text_ar,
                'question_text_en' => $request->question_text_en,
                'order_num' => $newOrderNum,
                'required' => $request->required
            ]);

            //here i'm checking whether this storing is coming from a section page or not
            if ($question && $request->check_request != null) {
                session()->flash('success', 'Question successfully created');
                return redirect()->to("/sections/show?id=$request->check_request");
            } else {
                session()->flash('success', 'Question successfully created');
                return redirect()->route('questions.index');
            }
        } catch (Exception $e) {
            $route = route('questions.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $question_id = $request->id;
        try {
            $question = Question::findOrFail($question_id);
            $sections = Section::all();
            return view('questions.show', compact('question', 'sections'));
        } catch (ModelNotFoundException $e) {
            $message = 'Cannot find the model';
            $route = route('questions.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $question_id = $request->id;
        $sections = Section::all();
        try {
            $question = Question::findOrFail($question_id);
            return view('questions.edit', compact('question', 'sections'));
        } catch (ModelNotFoundException $e) {
            $message = 'Cannot find the model';
            $route = route('questions.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $question_id = $request->id;
        $section_id_req = $request->section_id_req;
        try {
            $validate = Validator::make($request->all(), [
                'section_id' => 'required|integer',
                'question_type' => 'required',
                'question_text_ar' => 'required|max:255',
                'question_text_en' => 'required|max:255',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            if ($section_id_req) {
                $question = Question::where('id', $question_id)->where('section_id', $section_id_req)->first();
            } else {
                $question = Question::findOrFail($question_id);
            }
            $newOrderNum = $this->arrangeOrderNumber('questions', 'section_id', $request->section_id);
            if ($question) {
                $question->update([
                    'section_id' => $request->section_id,
                    'question_type' => $request->question_type,
                    'question_text_ar' => $request->question_text_ar,
                    'question_text_en' => $request->question_text_en,
                    'order_num' => $newOrderNum,
                    'required' => $request->required
                ]);
                // Set a flash message
                session()->flash('success', 'Question successfully updated');
                if ($section_id_req) {
                    return redirect()->to("/sections/show?id=$request->section_id");
                } else {
                    return redirect()->route('questions.index');
                }
            } else {
                $message = 'Cannot find the model';
                $route = route('questions.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            }
        } catch (ModelNotFoundException $e) {
            $message = 'Cannot find the model';
            $route = route('questions.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
