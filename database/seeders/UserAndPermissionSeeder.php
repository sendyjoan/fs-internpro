<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'dashboard-access',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-role-list',
            'user-role-create',
            'user-role-edit',
            'user-role-delete',
            'school-list',
            'school-create',
            'school-edit',
            'school-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        $role = Role::create(['name' => 'admin']);
        
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user = User::where('email', 'admin@mail.com')->first();
        $user->assignRole('admin');

        $student = Role::create(['name' => 'student']);
        $teacher = Role::create(['name' => 'teacher']);
        $mentor = Role::create(['name' => 'mentor']);
    }
}
