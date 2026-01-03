@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Item Details</h5>
            <a href="{{ route('ClothesItems.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Image:</div><div class="col-md-8"><img width="200px" src="{{ $clothesItem['image'] }}" alt="{{ $clothesItem['name'] }}"></div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold">SKU:</div>
                <div class="col-md-8">{{ $clothesItem['sku'] }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Name:</div>
                <div class="col-md-8">{{ $clothesItem['name'] }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Price:</div>
                <div class="col-md-8 text-success font-weight-bold">
                    {{ number_format($clothesItem['price'], 2) }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-bold">Description:</div>
                <div class="col-md-8">
                    {{ $clothesItem->description ?? 'No description provided.' }}
                </div>
            </div>
            
            <hr>
            
            <div class="d-flex">
                <a href="{{ route('ClothesItems.edit', $clothesItem['id']) }}" class="btn btn-primary me-2">Edit</a>
                
                <form action="{{ route('ClothesItems.destroy', $clothesItem['id']) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection