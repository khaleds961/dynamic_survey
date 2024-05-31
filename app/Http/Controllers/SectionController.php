<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $excludedSurveyId = null;
            if (isset($request->survey_id)) {
                $excludedSurveyId = $request->survey_id;
                $query = Section::includeSurvey($excludedSurveyId);
            } else {
                $query = Section::query();
            }
            $table = DataTables::eloquent($query)
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
                ->addColumn('is_active', function ($row) {
                    $action = "is_active";
                    $checked_flag = $row->is_active;
                    $id = $row->id;
                    $title = $row->title;
                    $table_name = 'sections';
                    return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                })
                ->addColumn('action', function ($row) use ($excludedSurveyId) {
                    $table_name = 'sections';
                    $id = $row->id;
                    $model = 'Section';
                    $surveyFlag = isset($excludedSurveyId) && $excludedSurveyId !== null;
                    $route = "/sections/show?id=$id";
                    return view('sections.action', compact('id', 'table_name', 'row', 'model', 'surveyFlag', 'route'));
                })
                ->make(true);

            return $table;
        }

        return view('sections.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sections.store');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'description' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $section = Section::create([
                'title' => $request->title,
                'description' => $request->description
            ]);

            if ($section) {
                session()->flash('success', 'Section successfully created.');
                return redirect()->route('sections.index');
            }
        } catch (Exception $e) {
            $message = 'Cannot find the model';
            $route = route('sections.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $section_id = $request->id;
        $section = Section::findOrFail($section_id);
        if ($section) {
            return view('sections.show', compact('section'));
        } else {
            $message = 'Cannot find the model';
            $route = route('sections.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        try {
            $validate = Validator::make($request->all(), [
                'edit_title' => 'required|max:255',
                'edit_description' => 'required'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            $section = Section::findOrFail($request->id);
            $section->update([
                'title' => $request->edit_title,
                'description' => $request->edit_description
            ]);
            session()->flash('success', 'Section updated successfully.');
            return redirect()->route('sections.index');
        } catch (Exception $e) {
            $message = 'Cannot find the model';
            $route = route('sections.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
