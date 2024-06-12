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
                ->editColumn('title_en', function ($row) {
                    return $row->title_en ? $row->title_en : '';
                })
                ->editColumn('title_ar', function ($row) {
                    return $row->title_ar ? $row->title_ar : '';
                })
                ->editColumn('description_en', function ($row) {
                    if (strlen($row->description_en) > 60) {
                        return Str::limit($row->description_en, 60);
                    } else {
                        return $row->description_en ? $row->description_en : '';
                    }
                })->editColumn('description_ar', function ($row) {
                    if (strlen($row->description_ar) > 60) {
                        return Str::limit($row->description_ar, 60);
                    } else {
                        return $row->description_ar ? $row->description_ar : '';
                    }
                })->addColumn('is_active', function ($row) {
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
                    $editRoute = "/sections/edit?id=$id";
                    return view('sections.action', compact('id', 'table_name', 'row', 'model', 'surveyFlag', 'route','editRoute'));
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
        return view('sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
                'description_en' => 'required',
                'description_ar' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $section = Section::create([
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar
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
    public function edit(Request $request)
    {
        try {
            $section = Section::findOrFail($request->id);
            return view('sections.edit', compact('section'));
        } catch (Exception $e) {
            return $e;
            $message = 'Cannot find the model';
            $route = route('sections.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        try {
            $validate = Validator::make($request->all(), [
                'title_en' => 'required|max:255',
                'title_ar' => 'required|max:255',
                'description_en' => 'required',
                'description_ar' => 'required'
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            $section = Section::findOrFail($request->id);
            $section->update([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->description_ar,
                'description_en'=> $request->description_en
            ]);
            session()->flash('success', 'Section updated successfully.');
            return redirect()->route('sections.index');
        } catch (Exception $e) {
            return $e;
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
