<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccessControlController extends Controller
{
    public function indexPermission(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $permissions = Permission::where('name', 'like', '%' . $search . '%')->paginate($perPage);
        // dd($permissions);
        return view('modules.acPermission.index', compact('permissions', 'perPage'));
    }

    public function indexRole()
    {
        $roles = Role::all();
        return view('modules.acRole.index', compact('roles'));
    }

    public function showRole(Role $role)
    {
        $role = Role::find($role->id);
        $rolePermissions = $role->permissions;
        // separate permissions to two array dengan panjang array yang sama
        $length = count($rolePermissions);
        $halfLength = ceil($length / 2);
        $rolePermissions1 = $rolePermissions->slice(0, $halfLength);
        $rolePermissions2 = $rolePermissions->slice($halfLength);

        // dd($rolePermissions1);
        // dd($rolePermissions2);
        return view('modules.acRole.show', compact('role', 'rolePermissions1', 'rolePermissions2'));
    }

    public function updateRole(Request $request, Role $role)
    {
        $role = Role::find($role->id);
        $permissions = Permission::all();
        $rolePermissions = Role::findByName($role->name)->permissions->pluck('id')->toArray();
        // dd($rolePermissions);
        return view('modules.acRole.update', compact('role', 'permissions', 'rolePermissions'));
    }

    public function saveRole(Request $request, Role $role)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name,' . $role->id,
            // 'permissions' => 'required'
        ]);

        $role = Role::find($role->id);
        $role->name = $request->input('role_name');
        $role->save();
        foreach ($role->permissions as $permission) {
            $role->revokePermissionTo($permission);
        }
        if (!$request->input('permissions')) {
            return redirect()->route('access-control.role-show', $role->id);
        }
        foreach ($request->input('permissions') as $permission) {
            $permission = Permission::findById($permission);
            $role->givePermissionTo($permission);
        }
        // $role->syncPermissions($request->input('permissions'));
        return redirect()->route('access-control.role-show', $role->id);
    }

    public function createRole()
    {
        // dd('create role');
        $permissions = Permission::all();
        return view('modules.acRole.create', compact('permissions'));
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:roles,name',
        ]);
        $role = Role::create(['name' => $request->input('role_name')]);
        if ($request->input('permissions')) {
            foreach ($request->input('permissions') as $permission) {
                $permission = Permission::findById($permission);
                $role->givePermissionTo($permission);
            }
        }
        // $role->syncPermissions($request->input('permissions'));
        return redirect()->route('access-control.role-index');
    }

    public function destroyRole(Role $role)
    {
        $role = Role::find($role->id);
        $role->revokePermissionTo($role->permissions);
        $role->delete();
        return redirect()->route('access-control.role-index');
    }

    public function indexUserToRole(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $users = User::with('roles')
        ->where('name', 'like', '%' . $request->input('name', '') . '%')
        // ->where('roles.name', 'like', '%' . $request->input('role', '') . '%')
        ->paginate($perPage);

        return view('modules.acUserToRole.index', compact('users', 'perPage'));
    }

    public function updateUserToRole(User $user)
    {
        $user = User::find($user->id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        // dd($user, $roles, $userRoles);
        return view('modules.acUserToRole.update', compact('user', 'roles', 'userRoles'));
    }

    public function saveUserToRole(Request $request, User $user)
    {
        // dd($request->all());
        $user = User::find($user->id);
        // get roles from request -> find in database by the id to get name -> and sync
        $roles = Role::find($request->input('roles'));
        // dd($roles);
        $user->syncRoles($roles);
        return redirect()->route('access-control.user-to-role-index');
    }
}
