@extends('layouts.master')
@section('title', 'Add Item - JoyClient')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Add New Item</h2>
            <a href="{{ route('ClothesItems.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('ClothesItems.store') }}" method="POST">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-bold small text-muted">ITEM NAME</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-tag"></i></span>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Ex: Cotton T-Shirt" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="sku" class="form-label fw-bold small text-muted">SKU CODE</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-barcode"></i></span>
                                <input type="text" name="sku" class="form-control" id="sku" value="{{ old('sku') }}" placeholder="Ex: SHIRT-001" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="price" class="form-label fw-bold small text-muted">PRICE ($)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-currency-dollar"></i></span>
                                <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price') }}" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label fw-bold small text-muted">IMAGE URL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="image" class="form-control" id="image" value="{{ old('image') }}" placeholder="https://example.com/image.jpg" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-bold small text-muted">DESCRIPTION</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="Enter item details...">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary px-4 fw-bold">
                                <i class="bi bi-check-lg me-2"></i> Save Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
