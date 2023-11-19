<?php

namespace App\Http\Controllers\Api;

use App\Models\Item;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'issue_date' => 'max:255|date',
            'due_date' => 'max:255|date',
            'invoice_item' => 'required|array',
        ]);

        $validated_data['invoice_number'] = 'inv_'. uniqid();

        try{
            DB::beginTransaction();
            
            $invoice = Invoice::create($validated_data);

            foreach($validated_data['invoice_item'] as $item){
                $invoice_item = new InvoiceItem($item);
                $invoice_item->invoice_id = $invoice->id;
                $invoice_item->save();

                $inventoryItem = Item::findOrFail($item['item_id']);
                $inventoryItem->quantity -= $item['quantity'];
                if($inventoryItem->quantity < 0){
                    throw new \Exception('Quantity not available');
                }
                $inventoryItem->save();
            }

            DB::commit();

            $invoice->refresh();

            return response()->json([
                'message' => 'Invoice created successfully',
                'data' => $invoice,
                'invoice_items' => $invoice->invoiceItems,
            ], 201);
        } catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'message' => 'Invoice creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'customer_id' => 'required',
            'company_name' => 'string|min:3|max:255',
            'customer_mobile' => 'string|min:3|max:255',
            'issue_date' => 'max:255|date',
            'due_date' => 'max:255|date',
            'invoice_item' => 'required|array',       
        ]);
    
        try {
            DB::beginTransaction();
    
            $invoice = Invoice::findOrFail($id);
            $invoice->update($validated_data);
    
            $originalQuantities = [];
            foreach ($invoice->invoiceItems as $item) {
                $originalQuantities[$item->item_id] = $item->quantity;
            }

            foreach ($validated_data['invoice_item'] as $item) {
                $invoiceItem = InvoiceItem::where('invoice_id', $id)->where('item_id', $item['item_id'])->first();
                if ($invoiceItem) {
                    $diff = $item['quantity'] - $originalQuantities[$item['item_id']];
                    $invoiceItem->update(['quantity' => $item['quantity']]);
    
                    $inventoryItem = Item::findOrFail($item['item_id']);
                    $inventoryItem->quantity -= $diff;
                    if ($inventoryItem->quantity < 0) {
                        throw new \Exception('Quantity not available');
                    }
                    $inventoryItem->save();
                }
            }
    
            DB::commit();
    
            $invoice->refresh();
    
            return response()->json([
                'message' => 'Invoice updated successfully',
                'data' => $invoice,
                'invoice_items' => $invoice->invoiceItems,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Invoice update failed',
                'error' => $e->getMessage()
            ], 500);
        }
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
