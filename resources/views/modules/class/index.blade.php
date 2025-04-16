@extends('layouts.admin')

@section('title', 'Classes Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Class Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Class</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form"></div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('class-create'))
                            <a href="{{ route('classes.create') }}" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                        {{-- @if (auth()->user()->can('class-import'))
                            <button type="button" class="btn btn-warning import" data-toggle="modal" data-target="#importModal">Import</button>
                        @endif
                        @if (auth()->user()->can('class-export'))
                            <a href="{{ route('export-class') }}" class="btn btn-sm btn-info text-white">Export</a>
                        @endif --}}
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Class Name</th>
                            <th>Major Name</th>
                            @if (Auth::user()->hasRole('Super Administrator'))
                                <th>School Name</th>
                            @endif
                            @if (auth()->user()->can('class-edit') || auth()->user()->can('class-delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $class->code }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->major->name ?? 'Major Deleted' }}</td>
                                @if (Auth::user()->hasRole('Super Administrator'))
                                    <td>{{ $class->school->name ?? 'School Deleted' }}</td>
                                @endif
                                @if (auth()->user()->can('class-edit') || auth()->user()->can('class-delete'))
                                    <td>
                                        @if (auth()->user()->can('class-list'))
                                            <a href="{{ route('classes.show', $class->id) }}" class="btn btn-sm btn-primary detail text-info">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('class-edit'))
                                            <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-primary update text-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('class-delete'))
                                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
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
            @if (auth()->user()->can('class-import'))
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Class</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <form action="{{ route('import-class') }}" method="POST" enctype="multipart/form-data"> --}}
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
                                    {{-- <p>Unknow the template? <a href='{{ route('template-class') }}'>Click here to download!</a></p> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-whitesmoke br">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection