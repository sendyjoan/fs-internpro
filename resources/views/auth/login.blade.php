@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                {{-- <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle"> --}}
                <img src="https://schooltech-file.s3.ap-southeast-2.amazonaws.com/logo-vertical-color.png" alt="logo" width="300" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Login</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="text">NIP/NISN/NIS/NIK</label>
                            <input id="text" type="text" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" name="username" tabindex="0" required autofocus>
                            @error('text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                                <div class="float-right">
                                    <a href="/forgot-password" class="text-small">
                                        Forgot Password?
                                    </a>
                                </div>
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="0"
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                Login
                            </button>
                        </div>
                    </form>



                </div>
            </div>
            <div class="mt-5 text-muted text-center">
                Don't have an account? <a href="/register">Create One</a>
            </div>
            <div class="simple-footer">
                Copyright &copy; Stisla {{ date('Y') }}
            </div>
        </div>
    </div>
@endsection