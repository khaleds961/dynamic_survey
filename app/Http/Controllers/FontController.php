<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Font;
use App\Traits\GeneralFunctions;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FontController extends Controller
{
    use GeneralFunctions;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ((Helper::check_permission(config('permissions.fonts'), 'read'))) {
            if ($request->ajax()) {

                $query = Font::query();

                $table = DataTables::eloquent($query)->editColumn('id', function ($row) {
                    return $row->id;
                })->editColumn('title', function ($row) {
                    return $row->title ? $row->title : '';
                })->editColumn('normal', function ($row) {
                    return $row->normal ? '<i class="ti ti-check p-2 text-success fs-6"></i>' : '<i class="ti ti-x p-2 text-danger fs-6"></i>';
                })->editColumn('bold', function ($row) {
                    return $row->bold ? '<i class="ti ti-check p-2 text-success fs-6"></i>' : '<i class="ti ti-x p-2 text-danger fs-6"></i>';
                })->editColumn('light', function ($row) {
                    return $row->light ? '<i class="ti ti-check p-2 text-success fs-6"></i>' : '<i class="ti ti-x p-2 text-danger fs-6"></i>';
                })->editColumn('action', function ($row) {
                    $table_name = 'fonts';
                    $id = $row->id;
                    $model = 'Font';
                    return view('fonts.action', compact('id', 'table_name', 'row', 'model'));
                })->rawColumns(['normal', 'bold', 'light'])
                    ->make(true);
                return $table;
            }
            return view('fonts.index');
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
        if ((Helper::check_permission(config('permissions.fonts'), 'write'))) {
            return view('fonts.create');
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('normal')->getMimeType());
        if ((Helper::check_permission(config('permissions.fonts'), 'write'))) {
            try {
                $validate = Validator::make($request->all(), [
                    'title' => 'required|max:255',
                    'normal' => 'required|mimetypes:application/font-woff,application/font-woff2,application/font-ttf,application/font-otf,application/vnd.ms-fontobject,font/sfnt|max:2048',
                    'bold' => 'nullable|mimetypes:application/font-woff,application/font-woff2,application/font-ttf,application/font-otf,application/vnd.ms-fontobject,font/sfnt|max:2048',
                    'light' => 'nullable|mimetypes:application/font-woff,application/font-woff2,application/font-ttf,application/font-otf,application/vnd.ms-fontobject,font/sfnt|max:2048',
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                // Check if the file exists in the request
                if ($request->hasFile('normal')) {
                    // Handle the uploaded file
                    $normal = $request->file('normal');
                    // Generate a unique file name
                    $normalName = 'normalFont' . time() . '.' . $normal->getClientOriginalExtension();
                    // Define the path to store the file
                    $path = 'fonts/normal/';
                    // Save the font to the public storage
                    Storage::disk('public')->put($path . $normalName, file_get_contents($normal));
                    // Get the full path of the stored file
                    $normalPath = $path . $normalName;
                } else {
                    $normalPath = null;
                }

                // Check if the file exists in the request
                if ($request->hasFile('light')) {
                    // Handle the uploaded file
                    $light = $request->file('light');
                    // Generate a unique file name
                    $lightName = 'lightFont' . time() . '.' . $light->getClientOriginalExtension();
                    // Define the path to store the file
                    $path = 'fonts/light/';
                    // Save the font to the public storage
                    Storage::disk('public')->put($path . $lightName, file_get_contents($light));
                    // Get the full path of the stored file
                    $lightPath = $path . $lightName;
                } else {
                    $lightPath = null;
                }

                // Check if the file exists in the request
                if ($request->hasFile('bold')) {
                    // Handle the uploaded file
                    $bold = $request->file('bold');
                    // Generate a unique file name
                    $boldName = 'boldFont' . time() . '.' . $bold->getClientOriginalExtension();
                    // Define the path to store the file
                    $path = 'fonts/bold/';
                    // Save the font to the public storage
                    Storage::disk('public')->put($path . $boldName, file_get_contents($bold));
                    // Get the full path of the stored file
                    $boldPath = $path . $boldName;
                } else {
                    $boldPath = null;
                }

                $font = Font::create([
                    'title' => $request->title,
                    'normal' => $normalPath,
                    'bold' => $boldPath,
                    'light' => $lightPath
                ]);

                if ($font) {
                    session()->flash('success', 'Font successfully created');
                    return redirect()->to("/font");
                }
            } catch (Exception $e) {
                $message = 'Something Goes Wrong.';
                $route = route('options.index');
                return view('layouts.errors.error500', compact('message', 'route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Font $fonts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Font $fonts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Font $fonts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Font $fonts)
    {
        //
    }
}
