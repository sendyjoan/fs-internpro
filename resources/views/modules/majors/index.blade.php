@extends('layouts.admin')

@section('title', 'Majors Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Majors Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Major</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('major-create'))
                            <a href="{{route('majors.create')}}" type="button" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Major Name</th>
                                @if (Auth::user()->hasRole('Super Administrator'))
                                <th>School Name</th>
                                @endif
                                @if (auth()->user()->can('major-edit') || auth()->user()->can('major-delete'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($majors as $major)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $major->code }}</td>
                                    <td>{{ $major->name }}</td>
                                    @if (Auth::user()->hasRole('Super Administrator'))
                                        <td>{{ $major->school->name }}</td>
                                    @endif
                                    @if (auth()->user()->can('major-edit') || auth()->user()->can('major-delete'))
                                    <td>
                                        @if (auth()->user()->can('major-list'))
                                        <a href="{{ route('majors.show', $major->id) }}" class="btn btn-sm btn-primary detail text-info"><i class="fas fa-info-circle"></i></a>
                                        @endif
                                        @if (auth()->user()->can('major-edit'))
                                        <a href="{{ route('majors.edit', $major->id) }}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if (auth()->user()->can('major-delete'))
                                        <form action="{{ route('majors.destroy', $major->id) }}" method="POST" class="d-inline">
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