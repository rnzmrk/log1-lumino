<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Request as RequestModel;

class BidController extends Controller
{
    public function index(Request $request)
    {
        // Check if request_id parameter is provided
        if ($request->has('request_id')) {
            // Show bids for specific request
            $request = RequestModel::with('bids')->findOrFail($request->request_id);
            return view('admin.procuments.bid.request-bids', compact('request'));
        }

        // Get requests that have bids
        $requestsWithBids = RequestModel::whereHas('bids')
            ->withCount('bids')
            ->withMin('bids', 'bid_amount')
            ->get()
            ->map(function ($request) {
                $request->lowest_bid = $request->bids_min_bid_amount;
                return $request;
            });

        // Get bid counts
        $pendingBidsCount = Bid::where('status', 'pending')->count();
        $approvedBidsCount = Bid::where('status', 'accepted')->count();
        $rejectedBidsCount = Bid::where('status', 'rejected')->count();

        return view('admin.procuments.bid.bid', compact(
            'requestsWithBids',
            'pendingBidsCount',
            'approvedBidsCount',
            'rejectedBidsCount'
        ));
    }

    public function showRequestBids($requestId)
    {
        $request = RequestModel::with('bids')->findOrFail($requestId);
        return view('admin.procuments.bid.request-bids', compact('request'));
    }

    public function updateBidStatus(Request $request, $bidId)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:accepted,rejected'
            ]);

            $bid = Bid::findOrFail($bidId);
            $bid->update(['status' => $validated['status']]);

            return response()->json([
                'success' => true,
                'message' => "Bid {$validated['status']} successfully!"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating bid status: ' . $e->getMessage()
            ], 500);
        }
    }
}
