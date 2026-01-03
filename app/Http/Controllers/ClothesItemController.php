<?php

namespace App\Http\Controllers;

use App\Models\ClothesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClothesItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $apiUrl = 'http://127.0.0.1:8000/api/ClothesItems';
    public function index()
    {
        $response = Http::get($this->apiUrl);
        $clothesItems = $response->json();
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
        Http::post($this->apiUrl, [
            'sku' => $request->sku,
            'name' => $request->name,
            'image' => $request->image,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return redirect()->route('ClothesItems.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $response = Http::get("{$this->apiUrl}/{$id}");
        $clothesItem = $response->json();
        return view('ClothesItems.show', compact('clothesItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $response = Http::get("{$this->apiUrl}/{$id}");
        $clothesItem = $response->json();
        return view('ClothesItems.edit', compact('clothesItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Http::put("{$this->apiUrl}/{$id}", [
            'sku' => $request->sku,
            'image' => $request->image,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
        return redirect()->route('ClothesItems.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Http::delete("{$this->apiUrl}/{$id}");
        return redirect()->route('ClothesItems.index');
    }
}
