<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inbound;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class InboundController extends Controller
{
    /**
     * Display the inbound shipments page.
     */
    public function index(Request $request)
    {
        // Get only approved purchase orders with their related requests
        $approvedPOs = PurchaseOrder::where('status', 'approved')
            ->with('request') // Load the related request
            ->orderBy('created_at', 'desc')
            ->get();

        // Build the query for inbound shipments
        $query = Inbound::with(['purchaseOrder.request', 'creator'])
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

        return view('admin.warehouse.inbound.inbound', compact('approvedPOs', 'inbounds', 'stats'));
    }

    /**
     * Store a new inbound shipment.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'location' => 'required|string|max:255',
            'quantity_received' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the purchase order
        $purchaseOrder = PurchaseOrder::findOrFail($validated['purchase_order_id']);

        // Check if PO is approved
        if ($purchaseOrder->status !== 'approved') {
            return redirect()->back()->with('error', 'Only approved purchase orders can be used for inbound shipments.');
        }

        // Create the inbound shipment
        $inbound = Inbound::create([
            'purchase_order_id' => $validated['purchase_order_id'],
            'location' => $validated['location'],
            'quantity_received' => $validated['quantity_received'],
            'notes' => $validated['notes'],
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('warehouse.inbound')->with('success', 'Inbound shipment created successfully!');
    }

    /**
     * Show the details of a specific inbound shipment.
     */
    public function show($id)
    {
        $inbound = Inbound::with(['purchaseOrder.request', 'creator'])
            ->findOrFail($id);

        return view('admin.warehouse.inbound.show', compact('inbound'));
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
