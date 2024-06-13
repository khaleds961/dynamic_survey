<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Survey;
use App\Traits\GeneralFunctions;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SurveyController extends Controller
{
    use GeneralFunctions;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Survey::with('property');

            $table = DataTables::eloquent($query)->editColumn('id', function ($row) {
                return $row->id;
            })->editColumn('date', function ($row) {
                return $row->date ? $row->date : '';
            })->editColumn('title_ar', function ($row) {
                return $row->title_ar ? $row->title_ar : '';
            })->editColumn('title_en', function ($row) {
                return $row->title_en ? $row->title_en : '';
            })->addColumn('logo', function ($row) {
                if ($row->property && $row->property->logo) {
                    // /app/public
                    return "<img class='rounded' src='" . asset('storage/' . $row->property->logo) . "' alt='logo' width='60' height='60' />";
                } else {
                    return "<img class='rounded' src='" . asset('storage/images/not-av.png') . "' alt='logo' width='60' height='60' />";
                }
            })->editColumn('language', function ($row) {
                if ($row->property && $row->property->language) {
                    return $row->property->language == 'ar' ? 'Arabic' : 'English';
                } else {
                    return '';
                }
            })->addColumn('mainColor', function ($row) {
                if ($row->property && $row->property->mainColor) {
                    return "<input disabled type='color' value='" . $row->property->mainColor . "' />";
                } else {
                    return '';
                }
            })->addColumn('is_active', function ($row) {
                $action = "is_active";
                $checked_flag = $row->is_active;
                $id = $row->id;
                $title = $row->title;
                $table_name = 'surveys';
                return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
            })->addColumn('action', function ($row) {
                $table_name = 'surveys';
                $id = $row->id;
                $model = 'Survey';
                $route = '/surveys/edit?id=' . $row->id . '';
                $show = '/surveys/show?id=' . $row->id . '';
                return view('surveys.action', compact('id', 'table_name', 'row', 'model', 'route', 'show'));
            })->rawColumns(['logo', 'mainColor'])
                ->make(true);
            return $table;
        }

        return view('surveys.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'min:3',
                'title_en' => 'min:3',
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $survey = Survey::create([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en,
                'user_id' => Auth::user()->id,
                'date' => Carbon::now()
            ]);

            if ($request->hasFile('logo')) {
                // Handle the uploaded file
                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $path = 'images/logos/logo';

                $logoPath = $this->uploadImage($logo, $logoName, $path);
            } else {
                $logoPath = null;
            }

            if ($request->hasFile('backgroundImage')) {
                // Handle the uploaded file
                $backgroundImage = $request->file('backgroundImage');
                $backgroundImageName = time() . '.' . $backgroundImage->getClientOriginalExtension();
                $path = 'images/backgroundImages/background';

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $backgroundImagePath =  $this->uploadImage($backgroundImage, $backgroundImageName, $path);
            } else {
                $backgroundImagePath = null;
            }

            if ($survey) {
                $property = Property::create([
                    'logo' => $logoPath,
                    'survey_id' => $survey->id,
                    'backgroundColor' => $request->backgroundColor,
                    'backgroundImage' => $backgroundImagePath,
                    'mainColor' => $request->mainColor,
                    'fontFamily' => $request->fontFamily,
                    'wizard' => $request->wizard,
                    'footer_ar' => $request->footer_ar,
                    'footer_en' => $request->footer_en,
                    'show_personal' => $request->show_personal
                ]);
            }

            if ($property) {
                session()->flash('success', 'Survey successfully created.');
                return redirect()->route('surveys.index');
            }
        } catch (Exception $e) {
            return $e;
            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            // Attempt to find the survey and load its property relationship
            $survey = Survey::with('property')->findOrFail($request->id);
            return view('surveys.show', compact('survey'));
        } catch (Exception $e) {
            $message = 'Cannot find the model';
            $route = route('surveys.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            // Attempt to find the survey and load its property relationship
            $survey = Survey::with('property')->findOrFail($request->id);
            return view('surveys.edit', compact('survey'));
        } catch (Exception $e) {
            $message = 'Cannot find the model';
            $route = route('surveys.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title_ar' => 'min:3',
                'title_en' => 'min:3',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Find the survey by ID
            $survey = Survey::findOrFail($request->id);
            $survey->update([
                'title_ar' => $request->title_ar,
                'title_en' => $request->title_en,
                'description_ar' => $request->description_ar,
                'description_en' => $request->description_en
            ]);

            // Find the property by survey ID
            $property = Property::where('survey_id', $request->id)->firstOrFail();


            if ($request->hasFile('editLogo')) {
                // Handle the uploaded file
                $logo = $request->file('editLogo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $path = 'images/logos/logo';

                $logoPath =   $this->uploadImage($logo, $logoName, $path);
            } else {
                $logoPath = null;
            }


            if ($request->hasFile('editBackgroundImage')) {
                // Handle the uploaded file
                $backgroundImage = $request->file('editBackgroundImage');
                $backgroundImageName = time() . '.' . $backgroundImage->getClientOriginalExtension();
                $path = 'images/backgroundImages/background';

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
                $backgroundImagePath =   $this->uploadImage($backgroundImage, $backgroundImageName, $path);
            } else {
                $backgroundImagePath = null;
            }

            // Update the property attributes using mass assignment
            $propertyData = [
                'backgroundColor' => $request->backgroundColor,
                'mainColor' => $request->mainColor,
                'fontFamily' => $request->fontFamily,
                'footer_ar' => $request->footer_ar,
                'footer_en' => $request->footer_en,
                'wizard' => $request->wizard,
                'show_personal' => $request->show_personal
            ];

            if ($logoPath) {
                $propertyData['logo'] = $logoPath;
            }

            if ($backgroundImagePath) {
                $propertyData['backgroundImage'] = $backgroundImagePath;
            }

            $property->update($propertyData);

            // Return a success response
            session()->flash('success', 'Survey successfully updated.');
            return redirect()->route('surveys.index');
        } catch (ModelNotFoundException $e) {
            $message = 'Cannot find the model';
            $route = route('surveys.index');
            return view('layouts.errors.error404', compact('message', 'route'));
        } catch (Exception $e) {
            return $e;

            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }
}
