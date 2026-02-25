<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetMaintenance;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Asset;
use App\Models\Inventory;

class AssetController extends Controller
{
    public function index(HttpRequest $request)
    {
        $query = Asset::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->orderBy('created_at', 'desc');

        // Apply search filter if provided
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('inventory', function($q) use ($search) {
                $q->where('item_name', 'like', '%' . $search . '%')
                  ->orWhere('id', 'like', '%' . $search . '%');
            });
        }

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Apply type filter if provided
        if ($request->has('type') && $request->type !== '') {
            $query->whereHas('inventory', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        // Apply location filter if provided
        if ($request->has('location') && $request->location !== '') {
            $query->whereHas('inventory.inbound.storageLocation', function($q) use ($request) {
                $q->where('name', $request->location);
            });
        }

        $assets = $query->paginate(10);

        return view('admin.assets.list.asset-list', compact('assets'));
    }

    public function getAssetItems()
    {
        $inventoryItems = Inventory::with(['inbound.purchaseOrder.request', 'inbound.storageLocation'])
            ->whereHas('inbound.purchaseOrder.request', function($query) {
                $query->where('type', 'asset');
            })
            ->where('quantity', '>', 0)
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'item_name' => $item->inbound->purchaseOrder->request->item_name ?? 'Unknown Item',
                    'type' => $item->inbound->purchaseOrder->request->type ?? 'unknown',
                    'quantity' => $item->quantity,
                    'location' => $item->inbound->storageLocation->name ?? 'N/A'
                ];
            });

        return response()->json([
            'success' => true,
            'items' => $inventoryItems
        ]);
    }

    public function store(HttpRequest $request)
    {
        try {
            // Step 1: Get request data
            $data = $request->all();
            
            // Step 2: Try basic validation
            $validated = $request->validate([
                'inventory_id' => 'required|integer|exists:inventories,id',
                'quantity' => 'required|integer|min:1',
                'department' => 'nullable|string|max:255'
            ]);

            // Get inventory item
            $inventory = Inventory::findOrFail($validated['inventory_id']);
            
            // Check if enough quantity is available
            if ($inventory->quantity < $validated['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient inventory quantity. Available: ' . $inventory->quantity
                ], 400);
            }

            // Create asset
            $asset = Asset::create([
                'inventory_id' => $validated['inventory_id'],
                'quantity' => $validated['quantity'],
                'department' => $validated['department'],
                'status' => 'active'
            ]);

            // Step 5: Auto-deduct quantity from inventory
            $inventory->decrement('quantity', $validated['quantity']);

            return response()->json([
                'success' => true,
                'message' => 'Asset created successfully! Inventory quantity updated.',
                'asset_id' => $asset->id,
                'inventory_remaining' => $inventory->quantity
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function setMaintenance(HttpRequest $request)
    {
        try {
            // Step 1: Get request data
            $data = $request->all();
            
            // Step 2: Try basic validation
            $validated = $request->validate([
                'asset_id' => 'required|integer',
                'reason' => 'required|string|max:1000',
                'maintenance_date' => 'required|date'
            ]);

            // Step 3: Try to get asset
            $asset = Asset::find($validated['asset_id']);
            if (!$asset) {
                return response()->json([
                    'success' => false,
                    'message' => 'Asset not found'
                ], 400);
            }

            // Step 4: Try to create maintenance record manually
            $maintenance = new AssetMaintenance();
            $maintenance->asset_id = $validated['asset_id'];
            $maintenance->maintenance_reason = $validated['reason'];
            $maintenance->maintenance_date = $validated['maintenance_date'];
            $maintenance->status = 'pending';
            $maintenance->save();

            // Step 5: Try to update asset status
            $asset->status = 'maintenance';
            $asset->save();

            return response()->json([
                'success' => true,
                'message' => 'Asset successfully set to maintenance!',
                'maintenance_id' => $maintenance->id,
                'asset_status' => $asset->status
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function maintenanceIndex(HttpRequest $request)
    {
        $query = AssetMaintenance::with('asset')
            ->orderBy('created_at', 'desc');

        // Search by maintenance reason or asset ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('maintenance_reason', 'like', "%{$search}%")
                  ->orWhereHas('asset', function($assetQuery) use ($search) {
                      $assetQuery->where('id', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $maintenances = $query->paginate(15);

        return view('admin.assets.maintenance.maintenance', compact('maintenances'));
    }

    public function updateMaintenanceStatus(HttpRequest $request, $id)
    {
        try {
            $maintenance = AssetMaintenance::findOrFail($id);
            
            $validated = $request->validate([
                'status' => 'required|in:pending,ongoing,done'
            ]);

            $maintenance->status = $validated['status'];
            $maintenance->save();

            // If maintenance is done, update asset status back to active
            if ($validated['status'] === 'done') {
                $asset = Asset::find($maintenance->asset_id);
                if ($asset) {
                    $asset->status = 'active';
                    $asset->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Maintenance status updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $asset = Asset::with(['inventory.inbound.purchaseOrder.request', 'inventory.inbound.storageLocation'])
            ->findOrFail($id);

        return view('admin.assets.show.asset-detail', compact('asset'));
    }

    public function edit($id)
    {
        $asset = Asset::with(['inventory'])->findOrFail($id);
        return view('admin.assets.edit.asset-edit', compact('asset'));
    }

    public function update(HttpRequest $request, $id)
    {
        $validated = $request->validate([
            'duration' => 'required|integer|min:1',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,replacement'
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Asset updated successfully!',
            'asset' => $asset
        ]);
    }

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        
        // Return quantity to inventory when asset is deleted
        $asset->inventory->increment('quantity', $asset->quantity);
        
        $asset->delete();

        return response()->json([
            'success' => true,
            'message' => 'Asset deleted successfully!'
        ]);
    }

    public function updateStatus(HttpRequest $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,maintenance,replacement'
        ]);

        $asset = Asset::findOrFail($id);
        $asset->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => "Asset status updated to {$validated['status']} successfully!",
            'asset' => $asset
        ]);
    }
}
