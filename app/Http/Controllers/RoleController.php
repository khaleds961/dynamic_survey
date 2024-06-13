<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Option;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ((Helper::check_permission(config('permissions.options'), 'read'))) {
            if ($request->ajax()) {
                $query = Role::query();
                $table = DataTables::eloquent($query)
                    ->editColumn('id', function ($row) {
                        return $row->id;
                    })
                    ->editColumn('title', function ($row) {
                        return $row->title ? $row->title : '';
                    })
                    ->addColumn('permissions', function ($row) {
                        return '<a class="btn btn-success" href="/roles/show"><i class="ti ti-license mx-1"></i>Permissions</a>';
                    })
                    ->addColumn('users', function ($row) {
                        return '<button class="btn btn-primary"><i class="ti ti-users mx-1"></i>Users</button>';
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

    public function show()
    {
        try {
            $id = 1;
            // if ($id == 1) {
            //     return view('layouts.errors.error403');
            // }
            if (Helper::check_permission(config('permissions.roles'), 'read')) {
                $type_name = Role::find($id)->name;
                $function_lists = Permission::select('id as function_id', 'title')->get();
                $permissions = [];
                foreach ($function_lists as $function_list) {
                    $club_permission = PermissionRole::where('role_id', $id)->where('permission_id', $function_list->function_id)->get();
                    if (count($club_permission) > 0) {
                        $permissions[] = PermissionRole::join('permissions', 'permissions.id', '=', 'permissions_roles.permission_id')
                            ->where('role_id', $id)->where('permission_id', $function_list->function_id)->select('permissions.*', 'permissions_roles.*')->first();
                    } else {
                        $permissions[] = $function_list;
                    }
                }
                return view('permissions.index', compact('permissions', 'type_name', 'id'));
            } else {
                return view('layouts.errors.error403');
            }
        } catch (\Exception) {
            return view('layouts.errors.error500');
        }
    }
}
