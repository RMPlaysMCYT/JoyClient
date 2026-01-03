@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Clothes Items</h1>
        <a href="{{ route('ClothesItems.create') }}" class="btn btn-primary">Add New Item</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle"> {{-- Added align-middle for better spacing --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th> {{-- New Header --}}
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th width="280px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clothesItems as $item)
                    <tr>
                        {{-- Change ->id to ['id'] --}}
                        <td>{{ $item['id'] }}</td>

                        <td>
                            {{-- Change ->image to ['image'] --}}
                            @if(!empty($item['image']))
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            @else
                            <span class="text-muted">No Image</span>
                            @endif
                        </td>

                        {{-- Change ->sku to ['sku'] --}}
                        <td>{{ $item['sku'] }}</td>

                        {{-- Change ->name to ['name'] --}}
                        <td>{{ $item['name'] }}</td>

                        {{-- Change ->price to ['price'] --}}
                        <td>{{ number_format($item['price'], 2) }}</td>

                        <td>
                            {{-- NOTE: You must use brackets for the ID in the route parameters too --}}
                            <form action="{{ route('ClothesItems.destroy', $item['id']) }}" method="POST">

                                <a class="btn btn-info btn-sm" href="{{ route('ClothesItems.show', $item['id']) }}">Show</a>
                                <a class="btn btn-primary btn-sm" href="{{ route('ClothesItems.edit', $item['id']) }}">Edit</a>

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No clothes items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Links (if you are using paginate() in controller) --}}
            {{-- {{ $clothesItems->links() }} --}}
        </div>
    </div>
</div>
@endsection