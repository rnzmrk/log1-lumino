<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Request;

class RequestController extends Controller
{
    public function store(HttpRequest $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:asset,supply',
            'description' => 'nullable|string|max:1000',
        ]);

        $newRequest = Request::create([
            'item_name' => $validated['item_name'],
            'quantity' => $validated['quantity'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Request submitted successfully!',
            'request' => $newRequest
        ]);
    }

    public function index()
    {
        $requests = Request::orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'requests' => $requests
        ]);
    }

    public function supplyRequests()
    {
        $requests = Request::where('type', 'supply')->orderBy('created_at', 'desc')->get();
        return view('admin.procuments.request.request', compact('requests'));
    }

    public function updateStatus(HttpRequest $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed,for_bid,done'
        ]);

        $requestModel = Request::find($id);
        
        if (!$requestModel) {
            return response()->json([
                'success' => false,
                'message' => 'Request not found'
            ], 404);
        }

        $requestModel->update([
            'status' => $validated['status']
        ]);

        return response()->json([
            'success' => true,
            'message' => "Request {$validated['status']} successfully!",
            'request' => $requestModel
        ]);
    }

}
