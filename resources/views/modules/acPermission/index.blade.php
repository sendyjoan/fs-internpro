@extends('layouts.admin')

@section('title', 'Permission Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Permission Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Permissions</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                            <form method="GET" action="{{ route('access-control.permission-index') }}">
                                <div class="input-group">
                                    <input id="search-value" type="text" name="search" class="form-control" placeholder="Search">
                                </div>
                            </form>
                    </div>
                    <div class="col-md-4 text-right">
                        {{-- <a type="button" class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#createModal">Create</a> --}}
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-primary delete text-danger"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-body">
                        <form method="GET" action="{{ route('access-control.permission-index') }}" class="form-inline">
                            <label for="per_page" class="mr-2">Items per page:</label>
                            <select name="per_page" id="per_page" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                            </select>
                        </form>
                        <br>
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection