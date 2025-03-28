@extends('layouts.admin')

@section('title', 'Classes Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Class</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Create Class Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Class Name</label>
                                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="major">Major</label>
                                <select class="form-control @error('major') is-invalid @enderror" id="major" name="major">
                                    <option value="">Select Major</option>
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->id }}" {{ old('major') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                    @endforeach
                                </select>
                                @error ('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::user()->hasRole('Super Administrator'))
                            <div class="form-group">
                                <label for="school">School</label>
                                <select class="form-control @error('school') is-invalid @enderror" id="school" name="school">
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
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('classes.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection