<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //seeder permissions, roles,users...

        DB::table('permissions')->insert([
            ['title' => 'users'],
            ['title' => 'surveys'],
            ['title' => 'sections'],
            ['title' => 'questions'],
            ['title' => 'options'],
            ['title' => 'participants'],
            ['title' => 'roles'],
            ['title' => 'survey_sections'],
            ['title' => 'fonts'],
        ]);

        DB::table('roles')->insert(
            ['title' => 'SuperAdmin']
        );

        DB::table('users')->insert(
            ['name' => 'Super Admin', 'email' => 'superadmin@me.com', 'password' => Hash::make(123), 'role_id' => 1]
        );

        DB::table('permissions_roles')->insert([
            ['permission_id' => 1, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 2, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 3, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 4, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 5, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 6, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 7, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 8, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
            ['permission_id' => 9, 'role_id' => 1, 'read' => 1, 'write' => 1, 'update' => 1, 'delete' => 1],
        ]);
    }
}
