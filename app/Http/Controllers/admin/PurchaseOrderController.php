<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    /**
     * Display all purchase orders.
     */
    public function index()
    {
        $purchaseOrders = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $requests = Request::all();
        $suppliers = \App\Models\Supplier::where('status', 'active')->get();
        
        return view('admin.procuments.po.po', compact('purchaseOrders', 'requests', 'suppliers'));
    }

    /**
     * Store a newly created purchase order.
     */
    public function store(HttpRequest $httpRequest)
    {
        $validator = Validator::make($httpRequest->all(), [
            'request_id' => 'required|exists:requests,id',
            'supplier' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'expected_delivery_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            PurchaseOrder::create([
                'request_id' => $httpRequest->request_id,
                'supplier' => $httpRequest->supplier,
                'price' => $httpRequest->price,
                'expected_delivery_date' => $httpRequest->expected_delivery_date,
                'notes' => $httpRequest->notes,
                'status' => 'ordered',
            ]);

            return redirect()->route('admin.purchase-orders.index')
                ->with('success', 'Purchase Order created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create Purchase Order')
                ->withInput();
        }
    }
}
