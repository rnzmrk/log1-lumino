<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierAccountController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')->get();
        return view('admin.others.supplier-accounts.index', compact('suppliers'));
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        if (!$supplier) {
            return redirect()->route('supplier-accounts.index')
                ->with('error', 'Supplier not found');
        }
        return view('admin.others.supplier-accounts.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $validated = $request->validate([
                'email' => 'required|email|unique:suppliers,email,' . $id,
                'password' => 'nullable|min:6',
                'contact_person' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'status' => 'required|in:active,inactive'
            ]);

            $supplier->email = $validated['email'];
            $supplier->contact_person = $validated['contact_person'];
            $supplier->phone = $validated['phone'];
            $supplier->address = $validated['address'];
            $supplier->status = $validated['status'];

            // Only update password if provided
            if (!empty($validated['password'])) {
                $supplier->password = bcrypt($validated['password']);
            }

            $supplier->save();

            return response()->json([
                'success' => true,
                'message' => 'Supplier account updated successfully!',
                'supplier' => $supplier
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $supplier->delete();

            return response()->json([
                'success' => true,
                'message' => 'Supplier account deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $supplier = Supplier::find($id);
            if (!$supplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'Supplier not found'
                ], 404);
            }

            $supplier->status = $validated['status'];
            $supplier->save();

            return response()->json([
                'success' => true,
                'message' => 'Supplier status updated successfully!',
                'supplier' => $supplier
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
