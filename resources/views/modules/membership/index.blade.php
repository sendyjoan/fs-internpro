@extends('layouts.admin')

@section('title', 'Memberships Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Memberships Management</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>List of Membership</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        @if (auth()->user()->can('membership-create'))
                            <a href="{{route('memberships.create')}}" type="button" class="btn btn-sm btn-primary text-white">Create</a>
                        @endif
                    </div>
                </div>
            </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Duration</th>
                                <th>Count used</th>
                                @if (auth()->user()->can('membership-edit') || auth()->user()->can('membership-delete'))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($memberships as $membership)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $membership->name }}</td>
                                    <td>{{ 'Rp. ' . number_format($membership->price, 2, ',', '.') }}</td>
                                    <td>{{ $membership->duration }}</td>
                                    <td>{{ $membership->schoolMembershipSummary->count() }}</td>
                                    @if (auth()->user()->can('membership-edit') || auth()->user()->can('membership-delete'))
                                    <td>
                                        @if (auth()->user()->can('membership-list'))
                                        <a href="{{ route('memberships.show', $membership->id) }}" class="btn btn-sm btn-primary detail text-info"><i class="fas fa-info-circle"></i></a>
                                        @endif
                                        @if (auth()->user()->can('membership-edit'))
                                        <a href="{{ route('memberships.edit', $membership->id) }}" class="btn btn-sm btn-primary update text-warning"><i class="fas fa-edit"></i></a>
                                        @endif
                                        @if (auth()->user()->can('membership-delete'))
                                        <form action="{{ route('memberships.destroy', $membership->id) }}" method="POST" class="d-inline">
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