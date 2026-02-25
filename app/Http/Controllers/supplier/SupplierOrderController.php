<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierOrderController extends Controller
{
    /**
     * Display supplier's purchase orders.
     */
    public function index()
    {
        $supplier = Auth::guard('supplier')->user();
        
        // Get all purchase orders for this supplier with 'ordered' status
        $purchaseOrders = PurchaseOrder::where('supplier', $supplier->company_name)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('supplier.orders', compact('purchaseOrders'));
    }

    /**
     * Update purchase order status (approve/cancel).
     */
    public function update(Request $request, $id)
    {
        $supplier = Auth::guard('supplier')->user();
        
        $purchaseOrder = PurchaseOrder::where('id', $id)
            ->where('supplier', $supplier->company_name)
            ->firstOrFail();

        $action = $request->input('action');

        if ($action === 'approve') {
            $purchaseOrder->status = 'approved';
            $message = 'Purchase Order approved successfully!';
        } elseif ($action === 'cancel') {
            $purchaseOrder->status = 'cancelled';
            $message = 'Purchase Order cancelled successfully!';
        } else {
            return redirect()->back()->with('error', 'Invalid action.');
        }

        $purchaseOrder->save();

        return redirect()->route('supplier.orders')->with('success', $message);
    }
}
