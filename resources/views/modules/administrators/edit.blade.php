@extends('layouts.admin')

@section('title', 'Administrators Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Update Administrator</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Update Administrator Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('administrators.update', $administrator->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="{{ !empty(old('username')) ? old('username') : $administrator->username }}" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter the username">
                                @error ('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" value="{{ !empty(old('name')) ? old('name') : $administrator->name }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter the full name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" value="{{ !empty(old('email')) ? old('email') : $administrator->email }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter the email address">
                                @error ('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" value="{{ !empty(old('phone')) ? old('phone') : $administrator->phone }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter the phone number">
                                @error ('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user()->hasRole('Super Administrator'))
                            <div class="form-group">
                                <label for="school">School</label>
                                <select class="form-control @error('school') is-invalid @enderror" id="school" name="school">
                                    <option value="">Select School</option>
                                    @foreach ($schools as $school)
                                        <option value="{{ $school->id }}" 
                                            {{ old('school', $administrator->school_id) == $school->id ? 'selected' : '' }}>
                                            {{ $school->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error ('school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('administrators.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection