<?php

namespace App\Http\Controllers;

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
        if ($request->ajax()) {

            $query = User::where('id', '!=', Auth::user()->id);

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
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|min:3|max:40',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:5'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            if ($user) {
                session()->flash('success', 'User successfully created.');
                return redirect()->route('users.index');
            }
        } catch (Exception $e) {
            return $e;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            // Attempt to find the survey and load its property relationship
            $user = User::findOrFail($request->id);
            return view('users.edit', compact('user'));
        } catch (Exception $e) {
            // Handle the case where the survey is not found
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
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
            return redirect()->route('users.index');
        } catch (ModelNotFoundException $e) {
            // Handle the case where the survey or property is not found
            return response()->json(['message' => 'User not found'], 404);
        } catch (Exception $e) {
            return $e;
            // Handle other exceptions
            return response()->json(['message' => 'Something went wrong'], 500);
        }
    }
}
