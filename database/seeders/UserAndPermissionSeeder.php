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
            'membership-list',
            'membership-create',
            'membership-edit',
            'membership-delete',
            'school-adjustment-create',
            'dashboard-system'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
        $role = Role::create(['name' => 'Super Administrator']);
        
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $user = User::where('email', 'admin@mail.com')->first();
        $user->assignRole('Super Administrator');

        $schoolAdministrator = Role::create(['name' => 'School Administrator']);
        $permissions = Permission::where('name', 'dashboard-access')->get();
        foreach ($permissions as $permission) {
            $schoolAdministrator->givePermissionTo($permission);
        }

        $student = Role::create(['name' => 'student']);
        $teacher = Role::create(['name' => 'teacher']);
        $mentor = Role::create(['name' => 'mentor']);
    }
}
