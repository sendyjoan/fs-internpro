@extends('layouts.admin')

@section('title', 'Administrators Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Administrator</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Create Administrator Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            {{-- <div class="card-body">
                <form action="{{ route('partners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Partner Name</label>
                                <input type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter the partner's name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Partner Email</label>
                                <input type="text" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter the partner's email">
                                @error ('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Partner Phone</label>
                                <input type="number" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter the partner's phone number">
                                @error ('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Partner Address</label>
                                <input type="text" value="{{ old('address') }}" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Enter the full address of the partner, including street, city, and postal code">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" value="{{ old('contact') }}" class="form-control @error('contact') is-invalid @enderror" id="contact" name="contact" placeholder="Enter the contact details">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="file">Partner Logo</label>
                                <input type="file" value="{{ old('file') }}" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                                @error ('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="url" value="{{ old('website') }}" class="form-control @error('website') is-invalid @enderror" id="website" name="website" placeholder="Enter the partner's website URL (e.g., https://example.com)">
                                @error('website')
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
                            <a href="{{ route('partners.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </div>
                </form>
            </div> --}}
        </div>
    </div>
</section>
@endsection