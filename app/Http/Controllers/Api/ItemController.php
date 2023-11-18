<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return response()->json([
            'data' => $items
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'item_name' => 'required|string|min:3|max:60',
            'description' => 'required|string|min:3|max:255',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $item = Item::create($validated_data);

        return response()->json([
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::findOrFail($id);

        return response()->json([
            'data' => $item
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated_data = $request->validate([
            'item_name' => 'string|min:3|max:60',
            'description' => 'string|min:3|max:255',
            'unit_price' => 'numeric',
            'quantity' => 'numeric',
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated_data);

        return response()->json([
            'message' => 'Item updated successfully',
            'data' => $item
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json([
            'message' => 'Item deleted successfully'
        ], 200);
    }
}
