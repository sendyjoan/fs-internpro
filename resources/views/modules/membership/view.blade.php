@extends('layouts.admin')

@section('title', 'Memberships Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Memberships Detail</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Detail of Membership</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                        <a href="{{route('memberships.index')}}" type="button" class="btn btn-sm btn-primary text-white">Back</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Name Membership</th>
                        <td>{{ $membership->name }}</td>
                    </tr>
                    <tr>
                        <th width="30%">Price</th>
                        <td>{{ $membership->price }}</td>
                    </tr>
                    <tr>
                        <th>Duration</th>
                        <td>{{ $membership->duration }} Month</td>
                    </tr>
                    <tr>
                        <th>Max Majors</th>
                        <td>{{$membership->max_majors}}</td>
                    </tr>
                    <tr>
                        <th>Max Classes</th>
                        <td>{{$membership->max_classes}}</td>
                    </tr>
                    <tr>
                        <th>Max Students</th>
                        <td>{{$membership->max_students}}</td>
                    </tr>
                    <tr>
                        <th>Max Partners</th>
                        <td>{{$membership->max_partners}}</td>
                    </tr>
                    <tr>
                        <th>Max Mentors</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Max Programs</th>
                        <td>{{$membership->max_programs}}</td>
                    </tr>
                    <tr>
                        <th>Max Activities</th>
                        <td>{{$membership->max_activities}}</td>
                    </tr>
                    <tr>
                        <th>Max Storages</th>
                        <td>{{$membership->max_storages}}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{$membership->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Created By</th>
                        <td>{{$membership->createdBy->name}}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{$membership->updated_at}}</td>
                    </tr>
                    <tr>
                        <th>Updated By</th>
                        <td>{{$membership->updatedBy->name}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection