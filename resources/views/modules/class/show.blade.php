@extends('layouts.admin')

@section('title', 'Classes Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Class Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of Class</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('classes.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Code Class</th>
                        <td>{{ $class->code }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Name Class</th>
                        <td>{{ $class->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Name Major</th>
                        <td>{{ $class->major->name ?? 'Major Deleted' }}</td>
                    </tr>
                    @if (Auth::user()->hasRole('Super Administrator'))
                    <tr>
                        <th width="30%">School Name</th>
                        <td>{{ $class->school->name ?? 'School Deleted'  }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</section>
@endsection