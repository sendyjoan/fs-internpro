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
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-role-list',
            'user-role-edit',
            'school-list',
            'school-create',
            'school-edit',
            'school-delete',
            'school-adjustment',
            'membership-list',
            'membership-create',
            'membership-edit',
            'membership-delete',
            'school-adjustment-create',
            'dashboard-system',
            'major-list',
            'major-create',
            'major-edit',
            'major-delete',
            'major-import',
            'major-export',
            'class-list',
            'class-create',
            'class-edit',
            'class-delete',
            'class-import',
            'class-export',
            'partner-list',
            'partner-create',
            'partner-edit',
            'partner-delete',
            'partner-import',
            'partner-export',
            'administrator-list',
            'administrator-create',
            'administrator-edit',
            'administrator-delete',
            'administrator-import',
            'administrator-export',
            'coordinator-list',
            'coordinator-create',
            'coordinator-edit',
            'coordinator-delete',
            'coordinator-import',
            'coordinator-export',
            'teacher-list',
            'teacher-create',
            'teacher-edit',
            'teacher-delete',
            'teacher-import',
            'teacher-export',
            'student-list',
            'student-create',
            'student-edit',
            'student-delete',
            'student-import',
            'student-export',
            'mentor-list',
            'mentor-create',
            'mentor-edit',
            'mentor-delete',
            'mentor-import',
            'mentor-export',
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
        // get permission like major
        $permissions = Permission::where('name', 'like', 'major%')->get();
        foreach ($permissions as $permission) {
            $schoolAdministrator->givePermissionTo($permission);
        }

        $permissions = Permission::where('name', 'like', 'class%')->get();
        foreach ($permissions as $permission) {
            $schoolAdministrator->givePermissionTo($permission);
        }

        $permissions = Permission::where('name', 'like', 'partner%')->get();
        foreach ($permissions as $permission) {
            $schoolAdministrator->givePermissionTo($permission);
        }

        $student = Role::create(['name' => 'student']);
        $teacher = Role::create(['name' => 'teacher']);
        $mentor = Role::create(['name' => 'mentor']);
    }
}
