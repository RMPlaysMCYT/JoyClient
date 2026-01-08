@extends('layouts.master')
@section('title', 'Dashboard - JoyClient')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white shadow-lg overflow-hidden">
                <div class="card-body p-5 position-relative">
                    <div class="position-absolute top-0 end-0 opacity-25 translate-middle-y me-5 mt-5">
                        <i class="bi bi-controller display-1"></i>
                    </div>
                    <h1 class="display-4 fw-bold">Welcome back, {{ Session::get('user')['name'] ?? 'User' }}!</h1>
                    <p class="lead">Manage your inventory and settings from here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Stats Card 1 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm transition-hover">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-light-primary text-primary rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        <i class="bi bi-collection-fill"></i>
                    </div>
                    <h4 class="card-title">Inventory</h4>
                    <p class="card-text text-muted">Manage your clothes items efficiently.</p>
                    <a href="{{ route('ClothesItems.index') }}" class="btn btn-outline-primary stretched-link">View Items</a>
                </div>
            </div>
        </div>

        <!-- Stats Card 2 -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm transition-hover">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-light-success text-success rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                         <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="card-title">Store Map</h4>
                    <p class="card-text text-muted">Find our store locations nearby.</p>
                    <a href="{{ route('map.index') }}" class="btn btn-outline-success stretched-link">Open Map</a>
                </div>
            </div>
        </div>

        <!-- Stats Card 3 -->
        <div class="col-md-4 mb-4">
             <div class="card h-100 border-0 shadow-sm transition-hover">
                <div class="card-body text-center p-4">
                    <div class="avatar-lg bg-light-info text-info rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                         <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <h4 class="card-title">Profile</h4>
                    <p class="card-text text-muted">Update your personal information.</p>
                    <a href="{{ route('profile') }}" class="btn btn-outline-info stretched-link">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-light-primary { background-color: rgba(13, 110, 253, 0.1); }
.bg-light-success { background-color: rgba(25, 135, 84, 0.1); }
.bg-light-info { background-color: rgba(13, 202, 240, 0.1); }
.transition-hover { transition: transform 0.2s; }
.transition-hover:hover { transform: translateY(-5px); }
</style>
@endsection
