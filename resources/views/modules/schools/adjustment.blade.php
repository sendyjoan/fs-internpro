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
                    <div class="row">
                        <div class="col-md-4">
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
                                <tr>
                                    <th>Membership Date</th>
                                    <td>{{ \Carbon\Carbon::parse($school->membership->start_membership)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($school->membership->end_membership)->format('d-m-Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <tr>
                                    <th width="30%">Name Membership</th>
                                    <td>{{ $school->membership->membership->name }}</td>
                                </tr>
                                <tr>
                                    <th>Price/Duration</th>
                                    <td>{{ $school->membership->membership->price }} / {{ $school->membership->membership->duration }}</td>
                                </tr>
                                <tr>
                                    <th>Majors Limit</th>
                                    <td>{{ $school->membership->majors_used }} / {{$school->membership->membership->max_majors}}</td>
                                </tr>
                                <tr>
                                    <th>Classes Limit</th>
                                    <td>{{ $school->membership->classes_used }} / {{$school->membership->membership->max_classes}}</td>
                                </tr>
                                <tr>
                                    <th>Students Limit</th>
                                    <td>{{ $school->membership->students_used }} / {{$school->membership->membership->max_students}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <tr>
                                    <th width="30%">Partners Limit</th>
                                    <td>{{ $school->membership->partners_used }} / {{$school->membership->membership->max_partners}}</td>
                                </tr>
                                <tr>
                                    <th>Mentors Limit</th>
                                    <td>{{ $school->membership->mentors_used }} / {{$school->membership->membership->max_mentors}}</td>
                                </tr>
                                <tr>
                                    <th>Programs Limit</th>
                                    <td>{{ $school->membership->programs_used }} / {{$school->membership->membership->max_programs}}</td>
                                </tr>
                                <tr>
                                    <th>Activities Limit</th>
                                    <td>{{ $school->membership->activities_used }} / {{$school->membership->membership->max_activities}}</td>
                                </tr>
                                <tr>
                                    <th>Storages Limit</th>
                                    <td>{{ $school->membership->storages_used }} / {{$school->membership->membership->max_storages}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h5>Adjustment Option</h5>
                    <div class="row">
                        <div class="col-md-12 table-responsive">
                            <table class="table">
                                <tr class="text-center">
                                    <td>Membership</td>
                                    <td>Start Date</td>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <select class="form-control @error('membership_id') is-invalid @enderror" id="membership_id" name="membership_id">
                                                @foreach($memberships as $membership)
                                                    <option value="{{ $membership->id }}" {{ old('membership_id') == $membership->id || $school->membership->membership->id == $membership->id ? 'selected' : '' }}>{{ $membership->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('membership_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="date" value="{{ old('start_member') }}" class="form-control @error('start_member') is-invalid @enderror" id="start_member" name="start_member">
                                            @error ('start_member')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
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