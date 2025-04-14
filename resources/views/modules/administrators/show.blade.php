@extends('layouts.admin')

@section('title', 'Administrator Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Administrator Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of Administrator</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('administrators.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Phone</th>
                        <td>{{ $user->phone }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Create Date</th>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Last Update</th>
                        <td>{{ !empty($user->updated_at) ? $user->updated_at : '-' }}</td>
                    </tr>
                    @if (Auth::user()->hasRole('Super Administrator'))
                    <tr>
                        <th width="30%">Partner Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
@endsection