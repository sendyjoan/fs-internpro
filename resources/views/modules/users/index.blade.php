@extends('layouts.admin')

@section('title', 'User Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>User Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Users</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                        <form method="GET" action="{{ route('users.index') }}">
                            <div class="input-group">
                                <input id="search-value" type="text" name="name" class="form-control" placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-right">
                        <a type="button" class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#createModal">Create</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-primary">{{ $role->name }}</span><br><br>
                                    @endforeach
                                </td>
                                <td>
                                    {{-- <a href="{{route('users.edit', $user->id)}}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a> --}}
                                    {{-- <a href="{{route('users.destroy', $user->id)}}" class="btn btn-sm btn-primary delete text-danger"><i class="fas fa-trash"></i></a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection