@extends('layouts.admin')

@section('title', 'Schools Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>School Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of School</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('schools.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Name School</th>
                        <td>{{ $school->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Email</th>
                        <td>{{ $school->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $school->phone }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $school->address }}</td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td>{{ $school->contact }}</td>
                    </tr>
                    <tr>
                        <th>Logo</th>
                        {{-- <td><img src="{{ asset('storage/' . $school->logo) }}" alt="Logo" width="100"></td> --}}
                    </tr>
                    <tr>
                        <th>Membership</th>
                        <td>{{ $school->membership->membership->name }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $school->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $school->updated_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection