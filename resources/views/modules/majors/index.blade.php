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
                    <div class="col-md-4 d-flex justify-content-center card-header-form"></div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('major-create'))
                            <a href="{{ route('majors.create') }}" class="btn btn-sm btn-primary text-white">Create</a>
                            <button type="button" class="btn btn-primary import" data-toggle="modal" data-target="#importModal">Launch demo modal</button>
                            {{-- <a href="#" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#importModal">Import</a> --}}
                            <a href="#" class="btn btn-sm btn-info text-white">Export</a>
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
                                            <a href="{{ route('majors.show', $major->id) }}" class="btn btn-sm btn-primary detail text-info">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('major-edit'))
                                            <a href="{{ route('majors.edit', $major->id) }}" class="btn btn-sm btn-primary update text-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('major-delete'))
                                            <form action="{{ route('majors.destroy', $major->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-primary delete text-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Major</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('majors.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="file">Upload File</label>
                                            <input type="file" value="{{ old('file') }}" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                                            @error ('file')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    <p>Unknow the template? <a href='#'>Click here to download!</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Import</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection