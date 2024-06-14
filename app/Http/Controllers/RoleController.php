<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Option;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ((Helper::check_permission(config('permissions.options'), 'read'))) {
            if ($request->ajax()) {
                $query = Role::where('id', '!=', 1);
                // $query = Role::query();
                $table = DataTables::eloquent($query)
                    ->editColumn('id', function ($row) {
                        return $row->id;
                    })
                    ->editColumn('title', function ($row) {
                        return $row->title ? $row->title : '';
                    })
                    ->addColumn('permissions', function ($row) {
                        return "<a class='btn btn-success' href='/roles/show/$row->id'><i class='ti ti-license mx-1'></i>Permissions</a>";
                    })
                    ->addColumn('users', function ($row) {
                        return "<a class='btn btn-primary' href='/roles/usersbyrole?id=$row->id'><i class='ti ti-users mx-1'></i>Users</a>";
                    })
                    ->addColumn('is_active', function ($row) {
                        $action = "is_active";
                        $checked_flag = $row->is_active;
                        $id = $row->id;
                        $title = $row->title;
                        $table_name = 'roles';
                        return view('layouts.actions.other_action', compact('action', 'checked_flag', 'id', 'title', 'table_name'));
                    })
                    ->addColumn('action', function ($row) {
                        $table_name = 'roles';
                        $id = $row->id;
                        $model = 'Role';
                        $href = "/roles/edit?id=$id";
                        return view('roles.action', compact('id', 'table_name', 'row', 'model', 'href'));
                    })->rawColumns(['permissions', 'users'])
                    ->make(true);
                return $table;
            }
            return view('roles.index');
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    public function create()
    {
        if ((Helper::check_permission(config('permissions.roles'), 'write'))) {
            return view('roles.create');
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    public function store(Request $request)
    {
        if ((Helper::check_permission(config('permissions.roles'), 'write'))) {
            try {
                $validate = Validator::make($request->all(), [
                    'title' => 'required|max:255',
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                $role = Role::create([
                    'title' => $request->title,
                ]);

                //here i'm checking whether this storing is coming from a section page or not
                if ($role) {
                    session()->flash('success', 'Role successfully created');
                    return redirect()->route('roles.index');
                }
            } catch (Exception $e) {
                $message = 'Something goes wrong.';
                $route = route('roles.index');
                return view('layouts.errors.error500', compact('message', 'route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    public function edit(Request $request)
    {
        if ($request->id == 1) {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
        if ((Helper::check_permission(config('permissions.roles'), 'update'))) {
            try {
                $role = Role::findOrFail($request->id);
                if ($role) {
                    return view('roles.edit', compact('role'));
                }
            } catch (ModelNotFoundException $e) {
                $message = 'Page Not Found.';
                $route = route('roles.index');
                return view('layouts.errors.error403', compact('message', 'route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = route('roles.index');
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }

    public function update(Request $request)
    {
        if ((Helper::check_permission(config('permissions.roles'), 'update'))) {
            try {
                $validate = Validator::make($request->all(), [
                    'id' => 'required|integer',
                    'title' => 'required|max:255',
                ]);

                if ($validate->fails()) {
                    return redirect()->back()->withErrors($validate)->withInput();
                }

                // Find the survey by ID
                $role = Role::findOrFail($request->id);

                $role->update([
                    'title' => $request->title
                ]);

                session()->flash('success', 'Option Updated Successfully.');

                if ($request->question_id_req) {
                    return redirect()->to("/questions/show?id=$request->question_id");
                } else {
                    return redirect()->route('roles.index');
                }
            } catch (ModelNotFoundException $e) {
                $message = 'Cannot find the model';
                $route = route('roles.index');
                return view('layouts.errors.error404', compact('message', 'route'));
            } catch (Exception $e) {
                $message = 'Something goes Wrong.';
                $route = route('roles.index');
                return view('layouts.errors.error500', compact('route'));
            }
        } else {
            $message = 'You are not allow to enter this page.';
            $route = null;
            return view('layouts.errors.error403', compact('message', 'route'));
        }
    }


    public function show($id)
    {
        try {
            if ($id == 1) {
                $message = 'You are not allow to enter this page.';
                $route = route('roles.index');
                return view('layouts.errors.error403', compact('message', 'route'));
            }
            if (Helper::check_permission(config('permissions.roles'), 'read')) {
                $role_title = Role::find($id)->title;
                $function_lists = Permission::select('id', 'title')->get();
                $permissions = [];
                foreach ($function_lists as $function_list) {
                    $role_permission = PermissionRole::where('role_id', $id)->where('permission_id', $function_list->id)->get();
                    if (count($role_permission) > 0) {
                        $permissions[] = PermissionRole::join('permissions', 'permissions.id', '=', 'permissions_roles.permission_id')
                            ->where('role_id', $id)->where('permission_id', $function_list->id)->select('permissions.*', 'permissions_roles.*')->first();
                    } else {
                        $permissions[] = $function_list;
                    }
                }
                // return $permissions;
                return view('permissions.index', compact('permissions', 'role_title', 'id'));
            } else {
                $message = 'You are not allow to enter this page.';
                $route = null;
                return view('layouts.errors.error403', compact('message', 'route'));
            }
        } catch (\Exception) {
            $message = 'Something goes wrong.';
            $route = route('roles.index');
            return view('layouts.errors.error500', compact('message', 'route'));
        }
    }

    public function update_store(Request $request)
    {
        try {
            if (Helper::check_permission(config('permissions.roles'), 'update')) {
                $role_id = $request->input('role_id');
                $ids = $request->input('id');
                $reads = $request->input('read');
                $writes = $request->input('write');
                $updates = $request->input('update');
                $deletes = $request->input('delete');

                foreach ($ids as $key => $id) {
                    $permission = PermissionRole::where('permission_id', $id)->where('role_id', $role_id)->first();
                    if ($permission) {
                        $permission->update([
                            'read' => isset($reads[$key]) ? 1 : 0,
                            'write' => isset($writes[$key]) ? 1 : 0,
                            'update' => isset($updates[$key]) ? 1 : 0,
                            'delete' => isset($deletes[$key]) ? 1 : 0,
                        ]);
                    } else {
                        PermissionRole::create([
                            'role_id' => $role_id,
                            'read' => isset($reads[$key]) ? 1 : 0,
                            'write' => isset($writes[$key]) ? 1 : 0,
                            'update' => isset($updates[$key]) ? 1 : 0,
                            'delete' => isset($deletes[$key]) ? 1 : 0,
                            'permission_id' => $id,
                        ]);
                    }
                }
                return redirect()->route('roles.index');
            } else {
                $message = 'You are not allow to enter this page.';
                $route = null;
                return view('layouts.errors.error403', compact('message', 'route'));
            }
        } catch (\Exception) {
            $message = 'Something goes wrong.';
            $route = route('roles.index');
            return view('layouts.errors.error500', compact('message', 'route'));
        }
    }

    public function usersbyrole(Request $request)
    {
        try {
            if (Helper::check_permission(config('permissions.users'), 'read')) {
                $id = $request->id;
                if ($id == 1) {
                    $message = 'You are not allow to enter this page.';
                    $route = route('roles.index');
                    return view('layouts.errors.error403', compact('message', 'route'));
                }
                if ($request->ajax()) {
                    $query = User::where('id', '!=', 1)->where('role_id', $id);
                    $table = DataTables::eloquent($query)->addColumn('name', function ($row) {
                        return $row->name ? $row->name : '';
                    })->addColumn('email', function ($row) {
                        return $row->email ? $row->email : '';
                    })->make(true);
                    return $table;
                }
                $role_title = Role::findOrFail($id)->title;
                return view('roles.usersbyrole',compact('role_title'));
            } else {
                $message = 'You are not allow to enter this page.';
                $route = route('roles.index');
                return view('layouts.errors.error403', compact('message', 'route'));
            }
        } catch (ModelNotFoundException $e) {
            return $e;
        } catch (Exception $e) {
            return $e;
            $route = route('roles.index');
            return view('layouts.errors.error500', compact('route'));
        }
    }
}
