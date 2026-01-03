@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            {{-- FIX: Use ['name'] instead of ->name --}}
            <h5 class="mb-0">Edit Item: {{ $clothesItem['name'] }}</h5>
            <a href="{{ route('ClothesItems.index') }}" class="btn btn-secondary btn-sm">Back</a>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FIX: Use ['id'] for the route --}}
            <form action="{{ route('ClothesItems.update', $clothesItem['id']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    {{-- FIX: Use ['sku'] --}}
                    <input type="text" name="sku" class="form-control" id="sku" value="{{ $clothesItem['sku'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image URL</label>
                    {{-- FIX: Use ['image'] --}}
                    <input type="url" name="image" class="form-control" id="image" value="{{ $clothesItem['image'] ?? '' }}" required>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    {{-- FIX: Use ['name'] --}}
                    <input type="text" name="name" class="form-control" id="name" value="{{ $clothesItem['name'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    {{-- FIX: Use ['price'] --}}
                    <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ $clothesItem['price'] }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    {{-- FIX: Use ['description'] --}}
                    <textarea name="description" class="form-control" id="description" rows="4">{{ $clothesItem['description'] }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Item</button>
            </form>
        </div>
    </div>
</div>
@endsection