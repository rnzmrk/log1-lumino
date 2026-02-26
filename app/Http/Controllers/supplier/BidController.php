<?php

namespace App\Http\Controllers\supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Request as RequestModel;

class BidController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Bid submission attempt', [
            'request_data' => $request->all(),
            'supplier_authenticated' => auth('supplier')->check()
        ]);

        $validated = $request->validate([
            'request_id' => 'required|exists:requests,id',
            'supplier_name' => 'required|string|max:255',
            'bid_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|in:USD,EUR,GBP,PHP',
            'proposal' => 'nullable|string|max:1000'
        ]);

        \Log::info('Validation passed', ['validated' => $validated]);

        // Check if request is available for bidding
        $requestModel = RequestModel::find($validated['request_id']);
        if (!$requestModel) {
            \Log::error('Request not found', ['request_id' => $validated['request_id']]);
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }

        if ($requestModel->status !== 'for_bid') {
            \Log::error('Request not available for bidding', [
                'request_id' => $validated['request_id'],
                'current_status' => $requestModel->status
            ]);
            return response()->json([
                'success' => false,
                'message' => 'This request is not available for bidding. Current status: ' . $requestModel->status
            ], 400);
        }

        // Check if supplier already has a bid on this request and update it
        $existingBid = Bid::where('request_id', $validated['request_id'])
                           ->where('supplier_name', $validated['supplier_name'])
                           ->first();
        
        if ($existingBid) {
            \Log::info('Updating existing bid', [
                'request_id' => $validated['request_id'],
                'supplier_name' => $validated['supplier_name'],
                'existing_bid_id' => $existingBid->id,
                'old_amount' => $existingBid->bid_amount,
                'new_amount' => $validated['bid_amount']
            ]);

            // Update the existing bid
            $bidData = $validated;
            $bidData['price'] = $validated['bid_amount']; // Map bid_amount to price for compatibility
            $bidData['bid_date'] = now()->format('Y-m-d'); // Update bid_date to current date
            
            $existingBid->update($bidData);
            
            return response()->json([
                'success' => true,
                'message' => 'Bid updated successfully!',
                'bid' => $existingBid
            ]);
        }

        \Log::info('New bid being submitted', [
            'request_id' => $validated['request_id'],
            'supplier_name' => $validated['supplier_name'],
            'bid_amount' => $validated['bid_amount']
        ]);

        // Prepare bid data with both price and bid_amount for compatibility
        $bidData = $validated;
        $bidData['price'] = $validated['bid_amount']; // Map bid_amount to price for compatibility
        $bidData['bid_date'] = now()->format('Y-m-d'); // Add current date for bid_date field

        \Log::info('Creating bid', ['bid_data' => $bidData]);

        try {
            $bid = Bid::create($bidData);
            \Log::info('Bid created successfully', ['bid_id' => $bid->id]);
        } catch (\Exception $e) {
            \Log::error('Failed to create bid', [
                'error' => $e->getMessage(),
                'bid_data' => $bidData
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create bid: ' . $e->getMessage()
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bid submitted successfully!',
            'bid' => $bid
        ]);
    }
}
