<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\Inventory;
use App\Models\StorageLocation;
use Illuminate\Http\Request;

class OutboundController extends Controller
{
    /**
     * Display the outbound shipments page.
     */
    public function index(Request $request)
    {
        // Build the query for outbound shipments
        $query = Outbound::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $outbounds = $query->paginate(5);

        // Get available inventory for creating new outbound shipments
        $availableInventory = Inventory::with(['inbound.purchaseOrder.request', 'inbound.storageLocation'])
            ->where('quantity', '>', 0)
            ->get();

        // Calculate KPI statistics
        $allOutbounds = Outbound::all();
        $stats = [
            'total' => $allOutbounds->count(),
            'pending' => $allOutbounds->where('status', 'pending')->count(),
            'shipped' => $allOutbounds->where('status', 'shipped')->count(),
            'delivered' => $allOutbounds->where('status', 'delivered')->count(),
        ];

        return view('admin.warehouse.outbound.outbound', compact('outbounds', 'availableInventory', 'stats'));
    }

    /**
     * Store a new outbound shipment.
     */
    public function store(Request $request)
    {
        // Check if this is an AJAX request
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $validated = $request->validate([
                    'inventory_id' => 'required|exists:inventories,id',
                    'name' => 'required|string|max:255',
                    'quantity' => 'required|integer|min:1',
                    'location' => 'required|string|max:255',
                    'ship_date' => 'required|date|after_or_equal:today',
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

            // Create outbound shipment
            $outbound = Outbound::create([
                'inventory_id' => $validated['inventory_id'],
                'name' => $validated['name'],
                'quantity' => $validated['quantity'],
                'location' => $validated['location'],
                'ship_date' => $validated['ship_date'],
                'status' => 'pending',
            ]);

            // Deduct quantity from inventory
            $inventory->quantity = $inventory->quantity - $validated['quantity'];
            $inventory->save();

            return response()->json([
                'success' => true,
                'message' => 'Outbound shipment created successfully! Inventory quantity updated.',
                'outbound' => $outbound,
                'remaining_quantity' => $inventory->quantity
            ]);
        }

        // Handle non-AJAX requests (if needed)
        return redirect()->back()->with('error', 'This endpoint only accepts AJAX requests');
    }

    /**
     * Update the status of an outbound shipment.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,shipped,delivered,cancelled',
        ]);

        $outbound = Outbound::findOrFail($id);
        $oldStatus = $outbound->status;
        $outbound->status = $validated['status'];
        $outbound->save();

        // If outbound is cancelled, restore the quantity to inventory
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            $inventory = $outbound->inventory;
            $inventory->quantity = $inventory->quantity + $outbound->quantity;
            $inventory->save();
        }
        // If outbound was cancelled and now is being reactivated, deduct again
        elseif ($oldStatus === 'cancelled' && $validated['status'] !== 'cancelled') {
            $inventory = $outbound->inventory;
            if ($inventory->quantity >= $outbound->quantity) {
                $inventory->quantity = $inventory->quantity - $outbound->quantity;
                $inventory->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Outbound status updated successfully!'
        ]);
    }

    /**
     * Show the details of an outbound shipment.
     */
    public function show($id)
    {
        $outbound = Outbound::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->findOrFail($id);

        return view('admin.warehouse.outbound.show', compact('outbound'));
    }
}
