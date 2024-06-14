<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if (Helper::check_permission(config('permissions.users'), 'read')) {
                if ($request->ajax()) {
                    $query = User::where('id', '!=', Auth::user()->id)->where('id','!=',1);
                    $table = DataTables::eloquent($query)->addColumn('name', function ($row) {
                        return $row->name ? $row->name : '';
                    })->addColumn('email', function ($row) {
                        return $row->email ? $row->email : '';
                    })->addColumn('is_active', function ($row) {
                        $action = "is_active";
                        $checked_flag = $row->is_active;
                        $id = $row->id;
                        $title = $row->title;
                        $table_name = 'users';
                        return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                    })->editColumn('action', function ($row) {
                        $table_name = 'users';
                        $id = $row->id;
                        $model = 'User';
                        $href = '/users/edit?id=' . $row->id . '';
                        return view('users.action', compact('id', 'table_name', 'row', 'model', 'href'));
                    })->make(true);
                    return $table;
                }
                return view('users.index');
            } else {
                $message = 'You are not allow to enter this page.';
                $route = null;
                return view('layouts.errors.error403', compact('message', 'route'));
            }
        } catch (Exception $e) {
            $route = null;
            return view('layouts.errors.error500', compact('route'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Helper::check_permission(config('permissions.users'), 'write')) {
            $roles = Role::where('id','!=',1)->get();
            return view('users.create', compact('roles'));
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
        if (Helper::check_permission(config('permissions.users'), 'write')) {
            try {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|min:3|max:40',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:5',
                    'role_id' => 'required|integer'
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id' => $request->role_id
                ]);

                if ($user) {
                    session()->flash('success', 'User successfully created.');
                    return redirect()->route('index');
                }
            } catch (Exception $e) {
                $route = null;
                return view('layouts.errors.error500', compact('route'));
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
    public function edit(Request $request)
    {
        if (Helper::check_permission(config('permissions.users'), 'update')) {
            try {
                // Attempt to find the survey and load its property relationship
                $user = User::findOrFail($request->id);
                $roles = Role::where('id','!=',1)->get();
                return view('users.edit', compact('user','roles'));
            } catch (Exception $e) {
                // Handle the case where the survey is not found
                return response()->json(['message' => 'User not found'], 404);
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
        if (Helper::check_permission(config('permissions.users'), 'update')) {
            try {
                $validator = Validator::make($request->all(), [
                    'id' => 'required|integer',
                    'name' => 'required|min:3|max:40',
                    'email' => 'required|email',
                    'password' => 'required|min:5'
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Find the survey by ID
                $user = User::findOrFail($request->id);
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

                session()->flash('success', 'User successfully updated.');
                return redirect()->route('index');
            } catch (ModelNotFoundException $e) {
                // Handle the case where the survey or property is not found
                return response()->json(['message' => 'User not found'], 404);
            } catch (Exception $e) {
                // Handle other exceptions
                return response()->json(['message' => 'Something went wrong'], 500);
            }
        } else {
            $message = 'You are not allow to do this action.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }
}
