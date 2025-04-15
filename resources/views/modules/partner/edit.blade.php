@extends('layouts.admin')

@section('title', 'Partner Management')

@section('sidebar')
    @parent
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Update Partner</h1>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-4">
                        <h4>Update Partner Form</h4>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center card-header-form">
                    </div>
                    <div class="col-md-4 text-right">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Partner Name</label>
                                <input type="text" value="{{ !empty(old('name')) ? old('name') : $partner->name }}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                                @error ('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Partner Email</label>
                                <input type="email" value="{{ !empty(old('email')) ? old('email') : $partner->email }}" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                                @error ('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">Partner Phone</label>
                                <input type="number" value="{{ !empty(old('phone')) ? old('phone') : $partner->phone }}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                                @error ('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="address">Partner Address</label>
                                <textarea class="form-control summernote @error('address') is-invalid @enderror" id="address" name="address">{{ !empty(old('address')) ? old('address') : $partner->address }}</textarea>
                                @error ('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <a href="{{ route('partners.index') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $('.summernote').summernote({
      height: 250
    });
  });
</script>
@endpush