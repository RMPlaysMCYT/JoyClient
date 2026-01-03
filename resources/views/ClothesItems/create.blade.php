@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Add New Clothes Item</h5>
            <a href="{{ route('ClothesItems.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">

            {{-- Validation Errors Display --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('ClothesItems.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku" value="{{ old('sku') }}" placeholder="Ex: SHIRT-001" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image Link (URL)</label>
                    <input type="url" name="image" class="form-control" id="image" value="{{ old('image') }}" placeholder="https://example.com/my-shirt.jpg" required>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Ex: Cotton T-Shirt" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ old('price') }}" placeholder="0.00" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="4">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Save Item</button>
            </form>
        </div>
    </div>
</div>
@endsection