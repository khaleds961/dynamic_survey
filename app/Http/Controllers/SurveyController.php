<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Survey;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = Survey::with('property');

            $table = DataTables::eloquent($query)->addColumn('date', function ($row) {
                return $row->date ? $row->date : '';
            })->addColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            })->addColumn('logo', function ($row) {
                if ($row->property && $row->property->logo) {
                    return "<img class='rounded' src='" . asset('storage/' . $row->property->logo) . "' alt='logo' width='60' height='60' />";
                } else {
                    return "<img class='rounded' src='" . asset('storage/images/not-av.png') . "' alt='logo' width='60' height='60' />";
                }
            })->addColumn('language', function ($row) {
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
            })->editColumn('action', function ($row) {
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
                'title' => 'min:3',
                'footer' => 'min:15'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $survey = Survey::create([
                'title' => $request->title,
                'description' => $request->description,
                'user_id' => Auth::user()->id,
                'date' => Carbon::now()
            ]);

            if ($request->hasFile('logo')) {
                // Handle the uploaded file
                $logo = $request->file('logo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $path = 'images/logos/logo';

                //check if folder not exist and create new one
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }

                // Resize and compress the image using Intervention Image
                $imageResized = Image::make($logo->getRealPath());
                $imageResized->resize(null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                // Save the image to the public storage
                Storage::disk('public')->put($path . $logoName, (string) $imageResized->encode());
                $logoPath = $path . $logoName;
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

                // Resize and compress the image using Intervention Image
                $imageResized = Image::make($backgroundImage->getRealPath());
                $imageResized->resize(null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                // Save the image to the public storage
                Storage::disk('public')->put($path . $backgroundImageName, (string) $imageResized->encode());
                $backgroundImagePath = $path . $backgroundImageName;
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
                    'language' => $request->language,
                    'footer' => $request->footer,
                ]);
            }

            if ($property) {
                session()->flash('success', 'Survey successfully created.');
                return redirect()->route('surveys.index');
            }
        } catch (Exception $e) {
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
                'title' => 'min:3',
                'footer' => 'min:15'
            ]);


            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Find the survey by ID
            $survey = Survey::findOrFail($request->id);
            $survey->update([
                'title' => $request->title,
                'description' => $request->description
            ]);

            // Find the property by survey ID
            $property = Property::where('survey_id', $request->id)->firstOrFail();

            if ($request->hasFile('editLogo')) {
                // Handle the uploaded file
                $logo = $request->file('editLogo');
                $logoName = time() . '.' . $logo->getClientOriginalExtension();
                $path = 'images/logos/logo';
                // Resize and compress the image using Intervention Image
                $imageResized = Image::make($logo->getRealPath());
                $imageResized->resize(null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                // Save the image to the public storage
                Storage::disk('public')->put($path . $logoName, (string) $imageResized->encode());
                $logoPath = $path . $logoName;
            } else {
                $logoPath = null;
            }

            if ($request->hasFile('editBackgroundImage')) {
                // Handle the uploaded file
                $backgroundImage = $request->file('editBackgroundImage');
                $backgroundImageName = time() . '.' . $backgroundImage->getClientOriginalExtension();
                $path = 'images/backgroundImages/background';
                // Resize and compress the image using Intervention Image
                $imageResized = Image::make($backgroundImage->getRealPath());
                $imageResized->resize(null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                // Save the image to the public storage
                Storage::disk('public')->put($path . $backgroundImageName, (string) $imageResized->encode());
                $backgroundImagePath = $path . $backgroundImageName;
            } else {
                $backgroundImagePath = null;
            }

            // Update the property attributes using mass assignment
            $propertyData = [
                'backgroundColor' => $request->backgroundColor,
                'mainColor' => $request->mainColor,
                'fontFamily' => $request->fontFamily,
                'language' => $request->language,
                'footer' => $request->footer,
                'wizard' => $request->wizard,
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
            $route = route('surveys.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }

}
