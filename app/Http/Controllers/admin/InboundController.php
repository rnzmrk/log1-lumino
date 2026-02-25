<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inbound;
use App\Models\PurchaseOrder;
use App\Models\StorageLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InboundController extends Controller
{
    /**
     * Display the inbound shipments page.
     */
    public function index(Request $request)
    {
        // Get only approved purchase orders with their related requests that don't have inbound shipments yet
        $approvedPOs = PurchaseOrder::where('status', 'approved')
            ->whereDoesntHave('inbound')
            ->with('request') // Load the related request
            ->orderBy('created_at', 'desc')
            ->get();

        // Get all storage locations
        $storageLocations = StorageLocation::orderBy('name')->get();

        // Build the query for inbound shipments
        $query = Inbound::with(['purchaseOrder.request', 'creator', 'storageLocation', 'inventory'])
            ->orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $inbounds = $query->paginate(5);

        // Calculate KPI statistics (from all inbounds, not just filtered)
        $allInbounds = Inbound::all();
        $stats = [
            'total' => $allInbounds->count(),
            'in_transit' => $allInbounds->where('status', 'in_transit')->count(),
            'arrived' => $allInbounds->where('status', 'arrived')->count(),
            'received' => $allInbounds->where('status', 'received')->count(),
        ];

        return view('admin.warehouse.inbound.inbound', compact('approvedPOs', 'storageLocations', 'inbounds', 'stats'));
    }

    /**
     * Store a new inbound shipment.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'storage_location_id' => 'nullable|exists:storage_locations,id',
            'quantity_received' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the purchase order
        $purchaseOrder = PurchaseOrder::findOrFail($validated['purchase_order_id']);

        // Check if PO is approved
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved purchase orders can be used for inbound shipments.');
        }

        // Create the inbound shipment
        $storageLocation = \App\Models\StorageLocation::find($validated['storage_location_id']);
        
        $inboundData = [
            'purchase_order_id' => $validated['purchase_order_id'],
            'location' => $storageLocation ? $storageLocation->name : null,
            'quantity_received' => $validated['quantity_received'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'created_by' => auth()->id(),
        ];
        
        // Add storage_location_id if the column exists
        if (Schema::hasColumn('inbounds', 'storage_location_id')) {
            $inboundData['storage_location_id'] = $validated['storage_location_id'];
        }
        
        $inbound = Inbound::create($inboundData);

        return redirect()->route('warehouse.inbound')->with('success', 'Inbound shipment created successfully!');
    }

    /**
     * Show the details of a specific inbound shipment.
     */
    public function show($id)
    {
        $inbound = Inbound::with(['purchaseOrder.request', 'creator', 'storageLocation'])
            ->findOrFail($id);
        
        $storageLocations = StorageLocation::orderBy('name')->get();

        return view('admin.warehouse.inbound.show', compact('inbound', 'storageLocations'));
    }

    /**
     * Update the specified inbound shipment.
     */
    public function update(Request $request, $id)
    {
        $inbound = Inbound::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'storage_location_id' => 'nullable|exists:storage_locations,id',
            'quantity_received' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Update the inbound shipment
        $inboundData = [];
        
        if (isset($validated['storage_location_id'])) {
            $inboundData['storage_location_id'] = $validated['storage_location_id'];
            
            // Also update the location name if storage location is provided
            if ($validated['storage_location_id']) {
                $storageLocation = StorageLocation::find($validated['storage_location_id']);
                $inboundData['location'] = $storageLocation ? $storageLocation->name : null;
            }
        }
        
        if (isset($validated['quantity_received'])) {
            $inboundData['quantity_received'] = $validated['quantity_received'];
        }
        
        if (isset($validated['notes'])) {
            $inboundData['notes'] = $validated['notes'];
        }

        if (!empty($inboundData)) {
            $inbound->update($inboundData);
        }

        return redirect()->route('admin.inbound.show', $inbound->id)
            ->with('success', 'Inbound shipment updated successfully!');
    }

    /**
     * Move inbound shipment to inventory.
     */
    public function moveToInventory(Request $request, $id)
    {
        $inbound = Inbound::findOrFail($id);

        // Check if inbound is received
        if ($inbound->status !== 'received') {
            return response()->json([
                'success' => false,
                'message' => 'Only received inbound shipments can be moved to inventory.'
            ], 400);
        }

        // Check if already moved to inventory
        $existingInventory = \App\Models\Inventory::where('inbound_id', $inbound->id)->first();
        if ($existingInventory) {
            return response()->json([
                'success' => false,
                'message' => 'This inbound shipment has already been moved to inventory.'
            ], 400);
        }

        // Create inventory record
        \App\Models\Inventory::create([
            'inbound_id' => $inbound->id,
            'quantity' => $inbound->quantity_received,
            'status' => 'in_stock',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inbound shipment moved to inventory successfully!'
        ]);
    }

    /**
     * Update the status of an inbound shipment.
     */
    public function updateStatus(Request $request, $id)
    {
        $inbound = Inbound::with(['purchaseOrder.request', 'creator'])
            ->findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'status' => 'required|in:pending,in_transit,arrived,received'
        ]);

        // Define valid status transitions
        $validTransitions = [
            'pending' => ['in_transit'],
            'in_transit' => ['arrived'],
            'arrived' => ['received'],
            'received' => [] // Can't change from received
        ];

        $currentStatus = $inbound->status;
        $newStatus = $validated['status'];

        // Check if the transition is valid
        if (!in_array($newStatus, $validTransitions[$currentStatus] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition from ' . $currentStatus . ' to ' . $newStatus
            ], 400);
        }

        // Update the status
        $inbound->status = $newStatus;
        $inbound->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully to ' . ucfirst(str_replace('_', ' ', $newStatus))
        ]);
    }
}
