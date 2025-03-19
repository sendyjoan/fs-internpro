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
                        <h4>List of Users</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                            <form method="GET" action="{{ route('access-control.user-to-role-index') }}">
                                <div class="input-group">
                                    <input id="search-value" type="text" name="name" class="form-control" placeholder="Search">
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
                                <th>Name</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                            <span class="badge badge-primary">{{ $role->name }}</span><br><br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{route('access-control.user-to-role-update', $user->id)}}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="card-body">
                        <form method="GET" action="{{ route('access-control.user-to-role-index') }}" class="form-inline">
                            <label for="per_page" class="mr-2">Items per page:</label>
                            <select name="per_page" id="per_page" class="form-control mr-2" onchange="this.form.submit()">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                            </select>
                        </form>
                        <br>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection