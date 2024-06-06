<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SurveySection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class SurveySectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $survey_id = $request->survey_id;
            if (isset($request->survey_id)) {
                $sections = Section::join('survey_sections', 'sections.id', '=', 'survey_sections.section_id')
                    ->join('surveys', 'survey_sections.survey_id', '=', 'surveys.id')
                    ->where('survey_sections.survey_id', $survey_id)
                    ->where('surveys.is_active', 1)
                    ->select(
                        'sections.id',
                        'sections.title',
                        'sections.description',
                        'survey_sections.order_num',
                        'survey_sections.id as survey_section_id',
                        'survey_sections.survey_id',
                        'survey_sections.is_active as survey_section_active'
                    );
            } else {
                $sections = Section::query()->with('surveys');
            }

            $table = DataTables::eloquent($sections)
                ->addColumn('id', function ($row) {
                    return $row->survey_section_id ? $row->survey_section_id : '';
                })
                ->addColumn('title', function ($row) {
                    return $row->title ? $row->title : '';
                })
                ->addColumn('description', function ($row) {
                    if (strlen($row->description) > 60) {
                        return Str::limit($row->description, 60);
                    } else {
                        return $row->description ? $row->description : '';
                    }
                })
                ->addColumn('order_num', function ($row) {
                    return $row->order_num;
                })
                ->addColumn('is_active', function ($row) {
                    $action = "is_active";
                    $checked_flag = $row->survey_section_active;
                    $id = $row->survey_section_id;
                    $table_name = 'survey_sections';
                    return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'table_name'));
                })
                ->addColumn('action', function ($row) use ($request) {
                    $table_name = 'survey_sections';
                    $id = $row->survey_section_id;
                    $section_id = $row->id;
                    $survey_id = $row->survey_id;
                    $model = 'SurveySection';
                    return view('surveysections.action', compact('id', 'table_name', 'row', 'model', 'section_id', 'survey_id'));
                })
                ->make(true);

            return $table;
        }

        return view('surveys.show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $excludedSurveyId = $request->survey_id; // The survey ID you want to exclude
        $sections = Section::excludeSurvey($excludedSurveyId)->get();
        return view('surveysections.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $survey_id = $request->survey_id;
        $section_id = $request->section_id;

        try {
            $validate = Validator::make($request->all(), [
                'survey_id' => 'required|integer',
                'section_id' => 'required|integer',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            // Find the max order_num for the given survey_id
            $maxOrderNum = SurveySection::where('survey_id', $survey_id)->max('order_num');
            // Calculate the new order_num
            $newOrderNum = $maxOrderNum !== null ? $maxOrderNum + 1 : 0;

            $surveySection = SurveySection::create([
                'survey_id' => $survey_id,
                'section_id' => $section_id,
                'order_num' => $newOrderNum
            ]);

            if ($surveySection) {
                return redirect()->to("/surveys/show?id=$survey_id");
            }
        } catch (Exception $e) {
            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SurveySection $surveySection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id = $request->id;
        $survey_id = $request->survey_id;
        $section_id = $request->section_id;

        $surveySection = SurveySection::where('id', $id)
            ->where('survey_id', $survey_id)
            ->where('section_id', $section_id)->first();
        if ($surveySection) {
            $excludeIds = SurveySection::where('survey_id', $request->survey_id)
                ->whereNotIn('section_id', [$request->section_id])
                ->pluck('section_id');
            $sections = Section::whereNotIn('id', $excludeIds)->get();
            return view('surveysections.edit', compact('sections'));
        } else {
            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'section_id' => 'required|integer'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            $surveySection = SurveySection::find($request->survey_section_id);
            if ($surveySection) {
                $surveySection->update([
                    'section_id' => $request->section_id
                ]);
                return redirect()->to("/surveys/show?id=$surveySection->survey_id");
            } else {
                $message = 'Cannot find the model';
                $route = route('options.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            }
        } catch (Exception $e) {
            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurveySection $surveySection)
    {
        //
    }
}
