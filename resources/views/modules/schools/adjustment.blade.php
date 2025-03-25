@extends('layouts.admin')

@section('title', 'Schools Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Adjustment Membership School</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Adjustment Membership Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('schools.save-adjustment', $school->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
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
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th width="30%">Name Membership</th>
                                    <td>{{ $school->membership->membership->name }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('schools.show', $school->id) }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection