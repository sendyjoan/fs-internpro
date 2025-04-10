@extends('layouts.admin')

@section('title', 'Partner Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Partner Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of Partner</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('partners.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Code Partner</th>
                        <td>{{ $partner->code }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Name Partner</th>
                        <td>{{ $partner->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Email Partner</th>
                        <td>{{ $partner->email }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Phone Partner</th>
                        <td>{{ $partner->phone }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Address Partner</th>
                        <td>{{ $partner->address }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Contact Partner</th>
                        <td>{{ $partner->contact }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Website Partner</th>
                        <td>{{ $partner->website }}</td>
                    </tr>
                    @if (Auth::user()->hasRole('Super Administrator'))
                    <tr>
                        <th width="30%">Partner Name</th>
                        <td>{{ $partner->school->name }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
@endsection