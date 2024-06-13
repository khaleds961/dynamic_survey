<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Option;
use App\Models\Question;
use App\Traits\GeneralFunctions;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class OptionController extends Controller
{

    use GeneralFunctions;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ((Helper::check_permission(config('permissions.options'), 'read'))) {
            if ($request->ajax()) {
                $query = Option::with('question');
                $table = DataTables::eloquent($query)
                    ->editColumn('id', function ($row) {
                        return $row->id;
                    })
                    ->editColumn('question_id', function ($row) {
                        return $row->question_id ? $row->question_id : '';
                    })
                    ->editColumn('icon', function ($row) {
                        if ($row->icon) {
                            return "<img class='rounded' src='" . asset('storage/' . $row->icon) . "' alt='logo' width='60' height='60' />";
                        } else {
                            return "<img class='rounded' src='" . asset('storage/images/not-av.png') . "' alt='logo' width='60' height='60' />";
                        }
                    })
                    ->addColumn('question_ar', function ($row) {
                        if ($row->question && $row->question->question_text_ar && strlen($row->question->question_text_ar) > 60) {
                            return Str::limit($row->question->question_text_ar, 60);
                        } else {
                            return $row->question && $row->question->question_text_ar ? $row->question->question_text_ar : '';
                        }
                    })
                    ->addColumn('question_en', function ($row) {
                        if ($row->question && $row->question->question_text_en && strlen($row->question->question_text_en) > 60) {
                            return Str::limit($row->question->question_text_en, 60);
                        } else {
                            return $row->question && $row->question->question_text_en ? $row->question->question_text_en : '';
                        }
                    })
                    ->editColumn('option_text_ar', function ($row) {
                        if (strlen($row->option_text_ar) > 60) {
                            return Str::limit($row->option_text_ar, 60);
                        } else {
                            return $row->option_text_ar ? $row->option_text_ar : '';
                        }
                    })
                    ->editColumn('option_text_en', function ($row) {
                        if (strlen($row->option_text_en) > 60) {
                            return Str::limit($row->option_text_en, 60);
                        } else {
                            return $row->option_text_en ? $row->option_text_en : '';
                        }
                    })
                    ->addColumn('is_active', function ($row) {
                        $action = "is_active";
                        $checked_flag = $row->is_active;
                        $id = $row->id;
                        $title = $row->title;
                        $table_name = 'options';
                        return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                    })
                    ->addColumn('action', function ($row) {
                        $table_name = 'options';
                        $id = $row->id;
                        $model = 'Option';
                        $href = "/options/edit?id=$id";
                        return view('options.action', compact('id', 'table_name', 'row', 'model', 'href'));
                    })->rawColumns(['icon'])
                    ->make(true);

                return $table;
            }
            return view('options.index');
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    public function questionOptions(Request $request)
    {
        if ($request->ajax()) {
            $question_id = $request->question_id;
            $query = Option::where('question_id', $request->question_id);
            $table = DataTables::eloquent($query)
                ->addColumn('id', function ($row) {
                    return $row->id ? $row->id : '';
                })
                ->addColumn('icon', function ($row) {
                    if ($row->icon) {
                        return "<img class='rounded' src='" . asset('storage/' . $row->icon) . "' alt='logo' width='60' height='60' />";
                    } else {
                        return "<img class='rounded' src='" . asset('storage/images/not-av.png') . "' alt='logo' width='60' height='60' />";
                    }
                })
                ->addColumn('option_text_en', function ($row) {
                    if (strlen($row->option_text_en) > 60) {
                        return Str::limit($row->option_text_en, 60);
                    } else {
                        return $row->option_text_en ? $row->option_text_en : '';
                    }
                })
                ->addColumn('option_text_ar', function ($row) {
                    if (strlen($row->option_text_ar) > 60) {
                        return Str::limit($row->option_text_ar, 60);
                    } else {
                        return $row->option_text_ar ? $row->option_text_ar : '';
                    }
                })
                ->addColumn('is_active', function ($row) {
                    $action = "is_active";
                    $checked_flag = $row->is_active;
                    $id = $row->id;
                    $title = $row->title;
                    $table_name = 'options';
                    return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                })
                ->addColumn('action', function ($row) use ($question_id) {
                    $table_name = 'options';
                    $id = $row->id;
                    $model = 'Option';
                    $href = "/options/edit?id=$id&question_id=$question_id";
                    return view('options.action', compact('id', 'table_name', 'row', 'model', 'href'));
                })->rawColumns(['icon'])
                ->make(true);

            return $table;
        }

        return view('questions.show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ((Helper::check_permission(config('permissions.options'), 'write'))) {
            $questions = Question::all();
            return view('options.create', compact('questions'));
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
        if ((Helper::check_permission(config('permissions.options'), 'write'))) {
            try {
                $validate = Validator::make($request->all(), [
                    'question_id' => 'required|integer',
                    'option_text_ar' => 'required|max:255',
                    'option_text_en' => 'required|max:255',
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                if ($request->hasFile('icon')) {
                    // Handle the uploaded file
                    $image = $request->file('icon');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $path = 'images/icons/icon';

                    $imagePath = $this->uploadImage($image, $imageName, $path);
                } else {
                    $imagePath = null;
                }

                $newOrderNum = $this->arrangeOrderNumber('options', 'question_id', $request->question_id);

                $option = Option::create([
                    'question_id' => $request->question_id,
                    'option_text_ar' => $request->option_text_ar,
                    'option_text_en' => $request->option_text_en,
                    'icon' => $imagePath,
                    'order_num' => $newOrderNum
                ]);

                //here i'm checking whether this storing is coming from a section page or not
                if ($option && $request->question_id_req != null) {
                    session()->flash('success', 'Question successfully created');
                    return redirect()->to("/questions/show?id=$request->question_id");
                } else {
                    session()->flash('success', 'Option Successfully Added.');
                    return redirect()->route('options.index');
                }
            } catch (Exception $e) {
                return $e;
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
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        if ((Helper::check_permission(config('permissions.options'), 'update'))) {
            $option_id = $request->id;
            $questions = Question::all();
            try {
                if (isset($request->question_id)) {
                    $option = Option::where('id', $option_id)->where('question_id', $request->question_id)->first();
                    if (!$option) {
                        $message = 'Cannot find the model';
                        $route = route('questions.index');
                        return view('layouts.errors.error404', compact('message', 'route'));
                    }
                }
                $option = Option::findOrFail($option_id);
                return view('options.edit', compact('questions', 'option'));
            } catch (ModelNotFoundException $e) {
                $message = 'Cannot find the model';
                $route = route('options.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ((Helper::check_permission(config('permissions.options'), 'update'))) {
            try {
                $validate = Validator::make($request->all(), [
                    'id' => 'required|integer',
                    'question_id' => 'required|integer',
                    'option_text_ar' => 'required|max:255',
                    'option_text_en' => 'required|max:255',
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                $newOrderNum = $this->arrangeOrderNumber('options', 'question_id', $request->question_id);

                if (isset($request->question_id_req)) {
                    $option = Option::where('id', $request->id)->where('question_id', $request->question_id_req)->first();
                    if (!$option) {
                        $message = 'Cannot find the model';
                        $route = route('options.index');
                        return view('layouts.errors.error404', compact('message', 'route'));
                    }
                } else {
                    // Find the survey by ID
                    $option = Option::findOrFail($request->id);
                }

                if ($request->hasFile('editIcon')) {
                    // Handle the uploaded file
                    $image = $request->file('editIcon');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $path = 'images/icons/icon';

                    $imagePath =   $this->uploadImage($image, $imageName, $path);
                } else {
                    $imagePath = null;
                }

                // Update the property attributes using mass assignment
                $OptionData = [
                    'question_id' => $request->question_id,
                    'option_text_ar' => $request->option_text_ar,
                    'option_text_en' => $request->option_text_en,
                    'order_num' => $newOrderNum
                ];

                if ($imagePath) {
                    $OptionData['icon'] = $imagePath;
                }

                $option->update($OptionData);

                session()->flash('success', 'Option Updated Successfully.');

                if ($request->question_id_req) {
                    return redirect()->to("/questions/show?id=$request->question_id");
                } else {
                    return redirect()->route('options.index');
                }
            } catch (ModelNotFoundException $e) {
                $message = 'Cannot find the model';
                $route = route('options.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            } catch (Exception $e) {
                $route = route('options.index');
                return view('layouts.errors.error500', compact('route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        //
    }
}
