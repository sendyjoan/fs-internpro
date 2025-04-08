@extends('layouts.admin')

@section('title', 'Partners Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Partners Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Partner</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form"></div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('partner-create'))
                            <a href="{{ route('partners.create') }}" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                        @if (auth()->user()->can('partner-import'))
                            {{-- <button type="button" class="btn btn-warning import" data-toggle="modal" data-target="#importModal">Import</button> --}}
                        @endif
                        @if (auth()->user()->can('partner-export'))
                            {{-- <a href="{{ route('export-partner') }}" class="btn btn-sm btn-info text-white">Export</a> --}}
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Contact</th>
                            @if (Auth::user()->hasRole('Super Administrator'))
                                <th>School Name</th>
                            @endif
                            @if (auth()->user()->can('partner-edit') || auth()->user()->can('partner-delete'))
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $partner)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $partner->logo }}</td>
                                <td>{{ $partner->code }}</td>
                                <td>{{ $partner->name }}</td>
                                <td>{{ $partner->email }}</td>
                                <td>{{ $partner->phone }}</td>
                                <td>{{ $partner->contact }}</td>
                                @if (Auth::user()->hasRole('Super Administrator'))
                                    <td>{{ $partner->school->name }}</td>
                                @endif
                                @if (auth()->user()->can('partner-edit') || auth()->user()->can('partner-delete'))
                                    <td>
                                        @if (auth()->user()->can('partner-list'))
                                            <a href="{{ route('partners.show', $partner->id) }}" class="btn btn-sm btn-primary detail text-info">
                                                <i class="fas fa-info-circle"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('partner-edit'))
                                            <a href="{{ route('partners.edit', $partner->id) }}" class="btn btn-sm btn-primary update text-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('partner-delete'))
                                            <form action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="d-inline">
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
            @if (auth()->user()->can('partner-import'))
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import partner</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{-- <form action="{{ route('import-partner') }}" method="POST" enctype="multipart/form-data"> --}}
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
                                    {{-- <p>Unknow the template? <a href='{{ route('template-partner') }}'>Click here to download!</a></p> --}}
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