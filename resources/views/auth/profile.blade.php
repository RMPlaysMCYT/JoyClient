@extends('layouts.master')
@section('title', 'User Profile - JoyClient')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">User Profile</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Home
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row g-3">
                    {{-- Full Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">FULL NAME</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            {{-- Changed from $user->name to $user['name'] --}}
                            <input type="text" class="form-control" value="{{ $user['name'] ?? 'Not Set' }}" readonly>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">EMAIL</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" value="{{ $user['email'] ?? 'Not Set' }}" readonly>
                        </div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">PHONE NUMBER</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-telephone"></i></span>
                            <input type="tel" class="form-control" value="{{ $user['phone'] ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    {{-- Address --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small text-muted">ADDRESS</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                            <input type="text" class="form-control" value="{{ $user['address'] ?? 'N/A' }}" readonly>
                        </div>
                    </div>

                    {{-- Bio --}}
                    <div class="col-12">
                        <label class="form-label fw-bold small text-muted">BIOGRAPHY</label>
                        <textarea class="form-control" rows="4" readonly>{{ $user['bio'] ?? 'No biography provided.' }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection