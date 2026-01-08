<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClothesItemController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Display a listing of the resource.
     */
public function index()
{
    $clothesItems = [];
    try {
$response = $this->apiService->get('/ClothesItems');
        if ($response->successful()) {
            $data = $response->json();
            // Check if items are nested inside a 'data' key
            $clothesItems = $data['data'] ?? $data ?? [];
        } else {
            Log::error('Failed to fetch clothes items. Status: ' . $response->status());
        }
    } catch (\Exception $e) {
        Log::error('Exception fetching clothes items: ' . $e->getMessage());
    }

    return view('ClothesItems.index', compact('clothesItems'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ClothesItems.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    // 1. Basic validation to ensure data is clean before sending
    $validated = $request->validate([
        'sku' => 'required|string',
        'name' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|url',
        'description' => 'nullable|string',
    ]);

    $response = $this->apiService->post('/ClothesItems', $validated);

    if ($response->successful()) {
        return redirect()->route('ClothesItems.index')->with('success', 'Item created successfully!');
    }

    // 2. Capture the actual error from the API response
    $errorMessage = $response->json()['message'] ?? 'Failed to create item.';
    
    return back()
        ->withInput()
        ->with('error', 'API Error: ' . $errorMessage);
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clothesItem = null;
        try {
            $response = $this->apiService->get("/ClothesItems/{$id}");
            if ($response->successful()) {
                $clothesItem = $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching item ' . $id . ': ' . $e->getMessage());
        }

        if (!$clothesItem) {
            return redirect()->route('ClothesItems.index')->with('error', 'Item not found or could not be loaded.');
        }

        return view('ClothesItems.show', compact('clothesItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clothesItem = null;
        try {
            $response = $this->apiService->get("/ClothesItems/{$id}");
            if ($response->successful()) {
                $clothesItem = $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Exception fetching item for edit ' . $id . ': ' . $e->getMessage());
        }

        if (!$clothesItem) {
            return redirect()->route('ClothesItems.index')->with('error', 'Item not found or could not be loaded.');
        }

        return view('ClothesItems.edit', compact('clothesItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $response = $this->apiService->put("/ClothesItems/{$id}", [
            'sku' => $request->sku,
            'image' => $request->image,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        if ($response->successful()) {
             return redirect()->route('ClothesItems.index')->with('success', 'Item updated successfully!');
        }

        return back()->withInput()->with('error', 'Failed to update item.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->apiService->delete("/ClothesItems/{$id}");

        if ($response->successful()) {
            return redirect()->route('ClothesItems.index')->with('success', 'Item deleted successfully!');
        }

        return redirect()->route('ClothesItems.index')->with('error', 'Failed to delete item.');
    }
}
