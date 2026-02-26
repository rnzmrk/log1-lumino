<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Request as RequestModel;
use App\Models\Bid;

class SupplierBiddingController extends Controller
{
    /**
     * Display the supplier's bidding interface.
     */
    public function index()
    {
        $supplier = auth()->guard('supplier')->user();
        
        // Get available requests for bidding
        $requests = RequestModel::where('status', 'for_bid')
            ->whereDoesntHave('bids', function($query) use ($supplier) {
                $query->where('supplier_id', $supplier->id);
            })
            ->withCount('bids')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get supplier's existing bids
        $myBids = Bid::where('supplier_id', $supplier->id)
            ->with('request')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('supplier.biddings', compact('requests', 'myBids'));
    }

    /**
     * Submit a bid for a request.
     */
    public function submitBid(Request $request)
    {
        try {
            $validated = $request->validate([
                'request_id' => 'required|exists:requests,id',
                'bid_amount' => 'required|numeric|min:0',
                'currency' => 'required|string|max:10',
                'proposal' => 'nullable|string|max:1000',
            ]);

            $supplier = auth()->guard('supplier')->user();
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not authenticated.'
                ], 401);
            }

            $requestModel = RequestModel::findOrFail($validated['request_id']);

            // Check if supplier already bid on this request
            $existingBid = Bid::where('request_id', $validated['request_id'])
                ->where('supplier_id', $supplier->id)
                ->first();

            if ($existingBid) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already submitted a bid for this request.'
                ], 400);
            }

            // Create new bid
            $bid = Bid::create([
                'request_id' => $validated['request_id'],
                'supplier_id' => $supplier->id,
                'supplier_name' => $supplier->company_name ?? $supplier->name,
                'bid_amount' => $validated['bid_amount'],
                'price' => $validated['bid_amount'], // price should be bid_amount
                'currency' => $validated['currency'],
                'proposal' => $validated['proposal'],
                'bid_date' => now()->format('Y-m-d'),
                'status' => 'submitted'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bid submitted successfully!',
                'bid' => $bid
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get bid details for a specific request.
     */
    public function getBidDetails($requestId)
    {
        $supplier = auth()->guard('supplier')->user();
        
        $bid = Bid::where('request_id', $requestId)
            ->where('supplier_id', $supplier->id)
            ->with('request')
            ->first();

        if (!$bid) {
            return response()->json([
                'success' => false,
                'message' => 'Bid not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'bid' => $bid
        ]);
    }
}
