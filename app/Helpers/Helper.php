<?php

namespace App\Helpers;

use App;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Auth;

class Helper
{
    public static function check_permission($permission_id, $permission_type)
    {
        $role_id = Auth::user()->role_id;
        if ($role_id) {
            $permission = PermissionRole::where('role_id', '=', $role_id)->where('permission_id', '=', $permission_id)
            ->first();
            return $permission->$permission_type;
        } else {
            return false;
        }
    }
}
?>