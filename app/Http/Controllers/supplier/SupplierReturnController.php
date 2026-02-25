<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\ItemReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierReturnController extends Controller
{
    /**
     * Display the supplier returns page.
     */
    public function index()
    {
        $supplier = Auth::guard('supplier')->user();
        $supplierName = $supplier->company_name;

        // Get returns where the purchase order supplier matches this supplier
        $returns = ItemReturn::with(['inventory.inbound.purchaseOrder'])
            ->whereHas('inventory.inbound.purchaseOrder', function ($query) use ($supplierName) {
                $query->where('supplier', $supplierName);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate stats
        $stats = [
            'total' => $returns->count(),
            'pending' => $returns->where('status', 'pending')->count(),
            'approved' => $returns->where('status', 'approved')->count(),
            'completed' => $returns->where('status', 'completed')->count(),
        ];

        return view('supplier.returns', compact('returns', 'stats'));
    }

    /**
     * Update return status.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected,completed'
            ]);

            $supplier = Auth::guard('supplier')->user();
            $supplierName = $supplier->company_name;

            $return = ItemReturn::with(['inventory.inbound.purchaseOrder'])
                ->whereHas('inventory.inbound.purchaseOrder', function ($query) use ($supplierName) {
                    $query->where('supplier', $supplierName);
                })
                ->findOrFail($id);

            $return->status = $request->status;
            $return->save();

            return response()->json([
                'success' => true,
                'message' => 'Return status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating return status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show return details.
     */
    public function show($id)
    {
        $supplier = Auth::guard('supplier')->user();
        $supplierName = $supplier->company_name;

        $return = ItemReturn::with(['inventory.inbound.purchaseOrder', 'inventory.inbound.purchaseOrder.request'])
            ->whereHas('inventory.inbound.purchaseOrder', function ($query) use ($supplierName) {
                $query->where('supplier', $supplierName);
            })
            ->findOrFail($id);

        return view('supplier.return-detail', compact('return'));
    }
}
