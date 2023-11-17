<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'data' => $customers
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|min:3|max:60',
            'email' => 'required|email|unique:customers,email'
        ]);

        $customer = Customer::create($validated_data);

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $customer
        ], 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated_data = $request->validate([
            'name' => 'string|min:3|max:60',
            'email' => 'email|unique:customers,email,' . $id
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated_data);

        return response()->json([
            'message' => 'Customer updated successfully',
            'data' => $customer
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json([
            'message' => 'Customer deleted successfully'
        ], 200);
    }
}
