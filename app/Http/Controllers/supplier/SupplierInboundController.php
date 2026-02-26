<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use App\Models\Inbound;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class SupplierInboundController extends Controller
{
    /**
     * Display the supplier's inbound shipments page.
     */
    public function index(Request $request)
    {
        // Get the logged-in supplier's company name
        $supplierCompanyName = auth('supplier')->user()->company_name;

        // Build the query for inbound shipments that belong to this supplier
        $query = Inbound::with(['purchaseOrder.request', 'creator'])
            ->whereHas('purchaseOrder', function ($q) use ($supplierCompanyName) {
                $q->where('supplier', $supplierCompanyName);
            })
            ->orderBy('created_at', 'desc');

        // Apply status filter if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Paginate the results (5 per page)
        $inbounds = $query->paginate(5);

        // Calculate KPI statistics for this supplier only
        $allInbounds = Inbound::whereHas('purchaseOrder', function ($q) use ($supplierCompanyName) {
            $q->where('supplier', $supplierCompanyName);
        })->get();

        $stats = [
            'total' => $allInbounds->count(),
            'pending' => $allInbounds->where('status', 'pending')->count(),
            'in_transit' => $allInbounds->where('status', 'in_transit')->count(),
            'arrived' => $allInbounds->where('status', 'arrived')->count(),
            'received' => $allInbounds->where('status', 'received')->count(),
        ];

        return view('supplier.inbound', compact('inbounds', 'stats'));
    }

    /**
     * Show the details of a specific inbound shipment.
     */
    public function show($id)
    {
        $supplierCompanyName = auth('supplier')->user()->company_name;

        $inbound = Inbound::with(['purchaseOrder.request', 'creator'])
            ->whereHas('purchaseOrder', function ($q) use ($supplierCompanyName) {
                $q->where('supplier', $supplierCompanyName);
            })
            ->findOrFail($id);

        return view('supplier.inbound-show', compact('inbound'));
    }

    /**
     * Update the status of an inbound shipment.
     */
    public function updateStatus(Request $request, $id)
    {
        $supplierCompanyName = auth('supplier')->user()->company_name;

        $inbound = Inbound::with(['purchaseOrder.request', 'creator'])
            ->whereHas('purchaseOrder', function ($q) use ($supplierCompanyName) {
                $q->where('supplier', $supplierCompanyName);
            })
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
