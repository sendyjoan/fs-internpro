@extends('layouts.admin')

@section('title', 'Role Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Role Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Update of Roles</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- <a type="button" class="btn btn-sm btn-primary text-white">Create</a> --}}
                    </div>
                </div>
            </div>
                <div class="card-body">
                    <form action="{{ route('access-control.role-store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="role_name">Role Name</label>
                            <input type="text" value="{{ old('role_name') }}" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name">
                            @error ('role_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="permissions">Permissions</label>
                            <div id="permissions">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Permission</th>
                                            <th>Assigned</th>
                                            <th>Permission</th>
                                            <th>Assigned</th>
                                            <th>Permission</th>
                                            <th>Assigned</th>
                                            <th>Permission</th>
                                            <th>Assigned</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions->chunk(4) as $chunk)
                                            <tr>
                                                @foreach($chunk as $permission)
                                                    <td>{{ $permission->name }}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="permission_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}">
                                                            <label class="form-check-label" for="permission_{{ $permission->id }}"></label>
                                                        </div>
                                                    </td>
                                                @endforeach
                                                @for($i = $chunk->count(); $i < 4; $i++)
                                                    <td></td>
                                                    <td></td>
                                                @endfor
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection