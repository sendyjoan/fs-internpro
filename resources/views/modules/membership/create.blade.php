@extends('layouts.admin')

@section('title', 'Memberships Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Membership</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Create Membership Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('memberships.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Membership Name</label>
                                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price">Membership Price</label>
                                <input type="number" value="{{ old('price') }}" class="form-control @error('price') is-invalid @enderror" id="price" name="price">
                                @error ('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_majors">Major Max</label>
                                <input type="number" value="{{ old('max_majors') }}" class="form-control @error('max_majors') is-invalid @enderror" id="max_majors" name="max_majors">
                                @error ('max_majors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_partners">Partners Max</label>
                                <input type="number" value="{{ old('max_partners') }}" class="form-control @error('max_partners') is-invalid @enderror" id="max_partners" name="max_partners">
                                @error ('max_partners')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_programs">Programs Max</label>
                                <input type="number" value="{{ old('max_programs') }}" class="form-control @error('max_programs') is-invalid @enderror" id="max_programs" name="max_programs">
                                @error ('max_programs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_students">Students Max</label>
                                <input type="number" value="{{ old('max_students') }}" class="form-control @error('max_students') is-invalid @enderror" id="max_students" name="max_students">
                                @error ('max_students')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">Duration</label>
                                <input type="number" value="{{ old('duration') }}" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration">
                                @error ('duration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_classes">Class Max</label>
                                <input type="number" value="{{ old('max_classes') }}" class="form-control @error('max_classes') is-invalid @enderror" id="max_classes" name="max_classes">
                                @error ('max_classes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_mentors">Mentors Max</label>
                                <input type="number" value="{{ old('max_mentors') }}" class="form-control @error('max_mentors') is-invalid @enderror" id="max_mentors" name="max_mentors">
                                @error ('max_mentors')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_activities">Activities Max</label>
                                <input type="number" value="{{ old('max_activities') }}" class="form-control @error('max_activities') is-invalid @enderror" id="max_activities" name="max_activities">
                                @error ('max_activities')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="max_storages">Storages Max</label>
                                <input type="number" value="{{ old('max_storages') }}" class="form-control @error('max_storages') is-invalid @enderror" id="max_storages" name="max_storages">
                                @error ('max_storages')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('memberships.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection