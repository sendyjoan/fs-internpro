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
                        <h4>List of Roles</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('role-create'))
                            <a href="{{route('access-control.role-create')}}" type="button" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role Name</th>
                                @if (auth()->user()->can('role-list') || auth()->user()->can('role-edit') || auth()->user()->can('role-delete'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    @if (auth()->user()->can('role-list') || auth()->user()->can('role-edit') || auth()->user()->can('role-delete'))
                                        <td>
                                            @if (auth()->user()->can('role-list'))
                                            <a href="{{ route('access-control.role-show', $role->id) }}" class="btn btn-sm btn-primary detail text-info"><i class="fas fa-info-circle"></i></a>
                                            @endif
                                            @if (auth()->user()->can('role-edit'))
                                            <a href="{{ route('access-control.role-update', $role->id) }}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a>
                                            @endif
                                            @if (auth()->user()->can('role-delete'))
                                            <form action="{{ route('access-control.role-destroy', $role->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-primary delete text-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection