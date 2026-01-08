@extends('layouts.master')
@section('title', 'Change Password - JoyClient')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Security</h2>
            <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Profile
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4">Update Password</h5>
                
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Current Password --}}
                        <div class="col-12">
                            <label for="current_password" class="form-label fw-bold small text-muted text-uppercase">Current Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" name="current_password" id="current_password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       placeholder="Enter current password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="col-12">
                            <label for="new_password" class="form-label fw-bold small text-muted text-uppercase">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                <input type="password" name="new_password" id="new_password" 
                                       class="form-control @error('new_password') is-invalid @enderror" 
                                       placeholder="Enter new password" required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm New Password --}}
                        <div class="col-12">
                            <label for="new_password_confirmation" class="form-label fw-bold small text-muted text-uppercase">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-check2-circle"></i></span>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" 
                                       class="form-control" placeholder="Repeat new password" required>
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="bi bi-shield-check me-2"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Security Tip --}}
        <div class="mt-4 p-3 bg-light rounded border">
            <div class="d-flex">
                <i class="bi bi-info-circle-fill text-primary me-3 fs-4"></i>
                <small class="text-muted">
                    <strong>Security Tip:</strong> Use a strong password with at least 8 characters, including letters, numbers, and symbols to keep your account safe.
                </small>
            </div>
        </div>
    </div>
</div>
@endsection