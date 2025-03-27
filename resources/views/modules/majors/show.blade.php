@extends('layouts.admin')

@section('title', 'Majors Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Majors Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of Major</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('majors.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Code Major</th>
                        <td>{{ $major->code }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Name Major</th>
                        <td>{{ $major->name }}</td>
                    </tr>
                    @if (Auth::user()->hasRole('Super Administrator'))
                    <tr>
                        <th width="30%">School Name</th>
                        <td>{{ $major->school->name }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
@endsection