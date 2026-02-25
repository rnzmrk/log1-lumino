<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemReturn;
use App\Models\Inventory;
use Illuminate\Http\Request;

class ItemReturnController extends Controller
{
    /**
     * Display a listing of returns.
     */
    public function index(Request $request)
    {
        $query = ItemReturn::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->orderBy('created_at', 'desc');

        // Apply status OR reason filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        } elseif ($request->has('reason') && $request->reason !== '') {
            $query->where('reason', $request->reason);
        }

        $returns = $query->paginate(5);

        // Get available inventory for creating new returns
        $availableInventory = Inventory::with(['inbound.purchaseOrder.request', 'inbound.storageLocation'])
            ->where('quantity', '>', 0)
            ->get();

        // Calculate KPI statistics
        $allReturns = ItemReturn::all();
        $stats = [
            'total' => $allReturns->count(),
            'pending' => $allReturns->where('status', 'pending')->count(),
            'approved' => $allReturns->where('status', 'approved')->count(),
            'processed' => $allReturns->where('status', 'processed')->count(),
            'completed' => $allReturns->where('status', 'completed')->count(),
        ];

        return view('admin.warehouse.return.return', compact('returns', 'availableInventory', 'stats'));
    }

    /**
     * Store a new return.
     */
    public function store(Request $request)
    {
        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $validated = $request->validate([
                    'inventory_id' => 'required|exists:inventories,id',
                    'quantity' => 'required|integer|min:1',
                    'reason' => 'required|in:defective,wrong_item,damaged,expired,other',
                    'notes' => 'nullable|string|max:1000',
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }

            // Check if inventory has enough quantity
            $inventory = Inventory::findOrFail($validated['inventory_id']);
            $availableQuantity = $inventory->quantity ?? 0;

            if ($validated['quantity'] > $availableQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requested quantity exceeds available inventory. Available: ' . $availableQuantity
                ], 400);
            }

            // Create return record
            $return = ItemReturn::create([
                'inventory_id' => $validated['inventory_id'],
                'quantity' => $validated['quantity'],
                'reason' => $validated['reason'],
                'notes' => $validated['notes'],
                'status' => 'pending',
            ]);

            // Deduct quantity from inventory
            $inventory->quantity = $inventory->quantity - $validated['quantity'];
            $inventory->save();

            return response()->json([
                'success' => true,
                'message' => 'Return created successfully! Inventory quantity updated.',
                'return' => $return,
                'remaining_quantity' => $inventory->quantity
            ]);
        }

        // Handle non-AJAX requests (if needed)
        return redirect()->back()->with('error', 'This endpoint only accepts AJAX requests');
    }

    /**
     * Update the status of a return.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,processed',
        ]);

        $return = ItemReturn::findOrFail($id);
        $oldStatus = $return->status;
        $return->status = $validated['status'];
        $return->save();

        // If return is rejected, restore the quantity to inventory
        if ($validated['status'] === 'rejected' && $oldStatus !== 'rejected') {
            $inventory = $return->inventory;
            $inventory->quantity = $inventory->quantity + $return->quantity;
            $inventory->save();
        }
        // If return was rejected and now is being reactivated, deduct again
        elseif ($oldStatus === 'rejected' && $validated['status'] !== 'rejected') {
            $inventory = $return->inventory;
            if ($inventory->quantity >= $return->quantity) {
                $inventory->quantity = $inventory->quantity - $return->quantity;
                $inventory->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Return status updated successfully!'
        ]);
    }

    /**
     * Show the details of a return.
     */
    public function show($id)
    {
        $return = ItemReturn::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->findOrFail($id);

        return view('admin.warehouse.return.show', compact('return'));
    }
}
