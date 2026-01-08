@extends('layouts.master')
@section('title', $clothesItem['name'] . ' - JoyClient')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Item Details</h2>
            <a href="{{ route('ClothesItems.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card shadow border-0 overflow-hidden">
            <div class="row g-0">
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                    @if(!empty($clothesItem['image']))
                        <img src="{{ $clothesItem['image'] }}" class="img-fluid rounded shadow-sm" alt="{{ $clothesItem['name'] }}" style="max-height: 400px; width: auto;">
                    @else
                        <div class="text-center text-muted">
                            <i class="bi bi-image display-1"></i>
                            <p>No Image Available</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4 p-lg-5 d-flex flex-column h-100">
                        <div class="mb-2">
                             <span class="badge bg-primary rounded-pill">{{ $clothesItem['sku'] }}</span>
                        </div>
                        <h1 class="card-title fw-bold mb-2">{{ $clothesItem['name'] }}</h1>
                        <h2 class="text-success fw-bold mb-4">${{ number_format($clothesItem['price'], 2) }}</h2>

                        <h5 class="text-muted small fw-bold text-uppercase">Description</h5>
                        <p class="card-text text-secondary mb-5 flex-grow-1">
                            {{ $clothesItem['description'] ?? 'No description provided for this item.' }}
                        </p>

                        <div class="d-flex gap-2 mt-auto pt-3 border-top">
                            <a href="{{ route('ClothesItems.edit', $clothesItem['id']) }}" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-pencil me-1"></i> Edit Item
                            </a>
                            <form action="{{ route('ClothesItems.destroy', $clothesItem['id']) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
