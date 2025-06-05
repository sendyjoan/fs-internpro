@extends('layouts.admin')

@section('title', 'Coordinators Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Coordinator</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Create Coordinator Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('coordinators.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter the username">
                                @error ('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter the full name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter the email address">
                                @error ('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter the phone number">
                                @error ('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user()->hasRole('Super Administrator'))
                            <div class="form-group">
                                <label for="school">School</label>
                                <select class="form-control select2 @error('school') is-invalid @enderror" id="school" name="school">
                                    <option value="">Select School</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}" {{ old('school') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                                @error ('school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="major">Major</label>
                                <select class="form-control select2-major @error('major') is-invalid @enderror" id="major" name="major">
                                    <option value="">Select Major</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" {{ old('major') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                    @endforeach
                                </select>
                                @error ('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('coordinators.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select School",
                allowClear: true
            });
            $('.select2-major').select2({
                placeholder: "Select Major",
                allowClear: true
            });
        });

        $(document).ready(function() {
            $('#school').on('change', function() {
                var schoolId = $(this).val();
                if (schoolId) {
                    $.ajax({
                        url: 'select-major/' + schoolId,
                        type: 'GET',
                        success: function(data) {
                            $('#major').empty();
                            $('#major').append('<option value="">Select Major</option>');
                            $.each(data, function(index, major) {
                                $('#major').append('<option value="' + major.id + '">' + major.name + '</option>');
                            });
                        },
                        error: function() {
                            $('#major').empty();
                            $('#major').append('<option value="">No Majors Available</option>');
                        }
                    });
                } else {
                    $('#major').empty();
                    $('#major').append('<option value="">Select Major</option>');
                }
            });
        });
    </script>
@endpush
@endsection