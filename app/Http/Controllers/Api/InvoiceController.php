<?php

namespace App\Http\Controllers\Api;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('invoiceItems')->get();


        return response()->json([
            'data' => $invoices,
        ], 200);

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'customer_id' => 'required',
            'company_name' => 'string|min:3|max:255',
            'customer_mobile' => 'string|min:3|max:255',
            'issue_date' => 'max:255',
            'due_date' => 'max:255',
            'invoice_item' => 'required|array',
        ]);

        $validated_data['invoice_number'] = 'inv_'. uniqid();

        $invoice = Invoice::create($validated_data);

        foreach($validated_data['invoice_item'] as $item){
            $invoice_item = new InvoiceItem($item);
            $invoice_item->invoice_id = $invoice->id;
            $invoice_item->save();
        }

        return response()->json([
            'message' => 'Invoice created successfully',
            'data' => $invoice->invoiceItems
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoice = Invoice::with('invoiceItems')->findOrFail($id);

        return response()->json([
            'data' => $invoice
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated_data = $request->validate([
            'customer_id' => 'exists:customers,id',
            'company_name' => 'string|min:3|max:255',
            'customer_mobile' => 'string|min:3|max:255',
            'issue_date' => 'max:255',
            'due_date' => 'max:255',
        ]);

        $invoice = Invoice::with('invoiceItems')->findOrFail($id);

        $invoice->update($validated_data);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'data' => $invoice
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully'
        ], 200);
    }
}
