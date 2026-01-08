@extends('layouts.master')
@section('title', 'Register - JoyClient')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <div class="mb-3">
                        <i class="bi bi-person-plus-fill display-1 text-primary"></i>
                    </div>
                    <h3 class="card-title fw-bold">Create Account</h3>
                    <p class="text-muted">Join JoyClient today</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label text-muted small fw-bold">FULL NAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person-vcard"></i></span>
                                <input type="text" class="form-control border-start-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label text-muted small fw-bold">USERNAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required placeholder="johndoe">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="john@example.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label text-muted small fw-bold">PHONE NUMBER</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control border-start-0 @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="+1234567890">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="password" class="form-label text-muted small fw-bold">PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label text-muted small fw-bold">CONFIRM PASSWORD</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control border-start-0" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">
                            <i class="bi bi-person-plus me-2"></i>Register
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-muted">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
