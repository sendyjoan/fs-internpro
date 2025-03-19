@extends('layouts.admin')

@section('title', 'Assign User to Role')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Assign User to Role</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Update Role of User</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
                <div class="card-body">
                    <form action="{{ route('access-control.user-to-role-save', $user->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="Username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Roles">Role</label>
                            <div id="Roles">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Assign</th>
                                            <th>Role Name</th>
                                            <th>Permissions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                                </td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    <p>
                                                    @foreach ($role->permissions as $index => $permission)
                                                        {{ $permission->name }},
                                                    @endforeach
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection