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
                        <h4>Detail of Roles</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- <a type="button" class="btn btn-sm btn-primary text-white">Create</a> --}}
                    </div>
                </div>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>
                                        Role Name
                                    </th>
                                    <td>
                                        {{ $role->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>List of Permission</th>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="table-responsive">
                                @php $numb = 1; @endphp
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Permission Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rolePermissions1 as $permission)
                                            <tr>
                                                <td>{{ $numb++ }}</td>
                                                <td>{{ $permission->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Permission Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rolePermissions2 as $permission)
                                            <tr>
                                                <td>{{ $numb++ }}</td>
                                                <td>{{ $permission->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection