<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;
    protected $table = 'permissions_roles';
    protected $fillable = [
        'permission_id',
        'role_id',
        'read',
        'write',
        'update',
        'delete'
    ];
}
