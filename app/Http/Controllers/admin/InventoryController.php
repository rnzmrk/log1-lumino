<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller  
{
    /**
     * Display a listing of the inventory.
     */
    public function index(Request $request)
    {
        $query = Inventory::with(['inbound.purchaseOrder.request', 'inbound.purchaseOrder.supplier', 'inbound.storageLocation'])
            ->orderBy('created_at', 'desc');

        // Apply search OR status filter (not both)
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('inbound.purchaseOrder.request', function($subQ) use ($search) {
                    $subQ->where('item_name', 'like', '%' . $search . '%');
                });
            });
        } elseif ($request->has('status') && $request->status !== '') {
            // Filter by status field in inventory database
            $query->where('status', $request->status);
        }

        $inventories = $query->paginate(5);

        // Calculate stats and update status based on quantity
        $stats = [
            'total' => 0,
            'in_stock' => 0,
            'low_stock' => 0,
            'out_of_stock' => 0,
        ];

        foreach ($inventories as $inventory) {
            $quantity = $inventory->quantity ?? 0;
            
            // Determine status based on quantity
            if ($quantity == 0) {
                $inventory->calculated_status = 'out_of_stock';
                $stats['out_of_stock']++;
            } elseif ($quantity <= 20) {
                $inventory->calculated_status = 'low_stock';
                $stats['low_stock']++;
            } else {
                $inventory->calculated_status = 'in_stock';
                $stats['in_stock']++;
            }
            
            $stats['total']++;
        }

        return view('admin.warehouse.inventory.inventory', compact('inventories', 'stats'));
    }

    /**
     * Show the form for creating a new inventory item.
     */
    public function create()
    {
        return view('admin.warehouse.inventory.create');
    }

    /**
     * Store a newly created inventory item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inbound_id' => 'required|exists:inbounds,id',
            'status' => 'required|in:in_stock,low_stock,out_of_stock',
        ]);

        // Check if inventory already exists for this inbound
        $existing = Inventory::where('inbound_id', $validated['inbound_id'])->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Inventory already exists for this inbound shipment.');
        }

        Inventory::create($validated);

        return redirect()->route('warehouse.inventory')
            ->with('success', 'Inventory item created successfully!');
    }

    /**
     * Display the specified inventory item.
     */
    public function show($id)
    {
        $inventory = Inventory::with(['inbound.purchaseOrder.request', 'inbound.storageLocation'])
            ->findOrFail($id);

        return view('admin.warehouse.inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     */
    public function edit($id)
    {
        $inventory = Inventory::findOrFail($id);
        return view('admin.warehouse.inventory.edit', compact('inventory'));
    }

    /**
     * Update the specified inventory item.
     */
    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:in_stock,low_stock,out_of_stock',
        ]);

        $inventory->update($validated);

        return redirect()->route('warehouse.inventory')
            ->with('success', 'Inventory item updated successfully!');
    }

    /**
     * Remove the specified inventory item.
     */
    public function destroy($id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('warehouse.inventory')
            ->with('success', 'Inventory item deleted successfully!');
    }

    /**
     * Update the status of an inventory item.
     */
    public function updateStatus(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:in_stock,low_stock,out_of_stock',
        ]);

        $inventory->status = $validated['status'];
        $inventory->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }

    /**
     * Automatically update inventory status based on quantity
     */
    public function autoUpdateStatus($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            $quantity = $inventory->quantity ?? 0;
            
            // Auto-update status based on quantity
            if ($quantity == 0) {
                $newStatus = 'out_of_stock';
            } elseif ($quantity <= 20) {
                $newStatus = 'low_stock';
            } else {
                $newStatus = 'in_stock';
            }
            
            // Only update if status changed
            if ($inventory->status !== $newStatus) {
                $inventory->status = $newStatus;
                $inventory->save();
                
                \Log::info("Inventory #{$id} status auto-updated to '{$newStatus}' (quantity: {$quantity})");
            }
            
            return response()->json([
                'success' => true,
                'message' => "Status auto-updated to {$newStatus}",
                'status' => $newStatus,
                'quantity' => $quantity
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Auto-update status error for inventory #{$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Batch update all inventory statuses based on quantity
     */
    public function batchUpdateStatuses()
    {
        try {
            $inventories = Inventory::all();
            $updatedCount = 0;
            
            foreach ($inventories as $inventory) {
                $quantity = $inventory->quantity ?? 0;
                
                // Determine new status based on quantity
                if ($quantity == 0) {
                    $newStatus = 'out_of_stock';
                } elseif ($quantity <= 20) {
                    $newStatus = 'low_stock';
                } else {
                    $newStatus = 'in_stock';
                }
                
                // Update if status changed
                if ($inventory->status !== $newStatus) {
                    $inventory->status = $newStatus;
                    $inventory->save();
                    $updatedCount++;
                }
            }
            
            \Log::info("Batch update completed: {$updatedCount} inventory statuses updated");
            
            return response()->json([
                'success' => true,
                'message' => "Batch update completed: {$updatedCount} items updated",
                'updated_count' => $updatedCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Batch update error: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Batch update failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
