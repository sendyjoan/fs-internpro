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
            {{-- <div class="card-body"> --}}
                {{-- <form action="{{ route('schools.update', $school->id) }}" method="POST" enctype="multipart/form-data"> --}}
                    {{-- @csrf --}}
                    {{-- @method('PUT') --}}
                    {{-- <div class="row"> --}}
                        {{-- <div class="col-md-6"> --}}
                            {{-- <div class="form-group">
                                <label for="school_name">School Name</label>
                                <input type="text" value="{{ !empty(old('email')) ? old('email') : $school->name }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="school_phone">School Phone</label>
                                <input type="text" value="{{ !empty(old('phone')) ? old('phone') : $school->phone }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                                @error ('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            {{-- <div class="form-group">
                                <label for="school_contact">School Contact</label>
                                <input type="text" value="{{ !empty(old('contact')) ? old('contact') : $school->contact }}" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact">
                                @error ('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="membership">Membership</label> --}}
                                {{-- <input type="text" value="{{ !empty(old('membership')) ? old('membership') : $school->membership->membership->name }}" class="form-control @error('membership') is-invalid @enderror" id="membership" name="membership"> --}}
                                {{-- <select class="form-control @error('membership') is-invalid @enderror" id="membership" name="membership">
                                    <option value="">Select Membership</option>
                                    @foreach ($memberships as $membership)
                                        <option value="{{ $membership->id }}" {{ old('membership') == $school->membership->membership->id || $membership->id == $school->membership->membership->id ? 'selected' : '' }}>{{ $membership->name }}</option>
                                    @endforeach
                                </select>
                                @error ('membership')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                        {{-- </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_email">School Email</label>
                                <input type="email" value="{{ !empty(old('email')) ? old('email') : $school->email }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                                @error ('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="school_address">School Address</label>
                                <input type="text" value="{{ !empty(old('address')) ? old('address') : $school->email }}" class="form-control @error('address') is-invalid @enderror" id="address" name="address">
                                @error ('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="school_logo">School Logo</label>
                                <input type="file" value="{{ old('logo') }}" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo">
                                @error ('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="start_member">Start Membership</label>
                                <input type="date" value="{{ !empty(old('start_member')) ? old('start_member') : $school->membership->start_membership }}" class="form-control @error('start_member') is-invalid @enderror" id="start_member" name="start_member">
                                @error ('start_member')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="col-md-12 text-right">
                            <a href="{{ route('schools.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                    {{-- </div> --}}
                {{-- </form> --}}
            {{-- </div> --}}
        </div>
    </div>
</section>
@endsection