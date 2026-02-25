<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display the admin supplier management page
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        
        return view('admin.procuments.supplier.supplier', compact('suppliers'));
    }

    /**
     * Accept supplier
     */
    public function accept($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update(['status' => 'active']);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier accepted successfully!');
    }

    /**
     * Reject supplier
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason,
        ]);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier rejected successfully!');
    }

    /**
     * Show supplier details
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        
        return view('admin.procuments.supplier.show', compact('supplier'));
    }

    /**
     * Update supplier status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,pending,rejected',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'status' => $request->status,
            'rejection_reason' => $request->status === 'rejected' ? $request->rejection_reason : null,
        ]);

        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier status updated successfully!');
    }
}
