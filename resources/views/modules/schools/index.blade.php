@extends('layouts.admin')

@section('title', 'School Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>School Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of School</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('school-create'))
                        <a href="{{route('schools.create')}}" type="button" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Logo</th>
                                <th>School Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Membership</th>
                                @if (auth()->user()->can('school-list') || auth()->user()->can('school-edit') || auth()->user()->can('school-delete'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $school->logo }}</td>
                                    <td>{{ $school->name }}</td>
                                    <td>{{ $school->contact }}</td>
                                    <td>{{ $school->email }}</td>
                                    <td>{{ $school->phone }}</td>
                                    <td>{{ $school->membership->membership->name }}</td>
                                    @if (auth()->user()->can('school-list') || auth()->user()->can('school-edit') || auth()->user()->can('school-delete'))
                                    <td>
                                        @if (auth()->user()->can('school-list'))
                                        <a href="{{ route('schools.show', $school->id) }}" class="btn btn-sm btn-primary detail text-info"><i class="fas fa-info-circle"></i></a>
                                        @endif
                                        @if (auth()->user()->can('school-edit'))
                                        <a href="{{ route('schools.edit', $school->id) }}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if (auth()->user()->can('school-delete'))
                                        <form action="{{ route('schools.destroy', $school->id) }}" method="POST" class="d-inline">
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