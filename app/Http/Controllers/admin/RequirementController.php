<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierRequirement;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    /**
     * Display the admin requirements page
     */
    public function index()
    {
        $requirements = SupplierRequirement::with('supplier')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Debug: Log the requirements count
        \Log::info('Requirements count: ' . $requirements->count());
        
        return view('admin.documents.requirement.requirements', compact('requirements'));
    }

    /**
     * Update requirement status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $requirement = SupplierRequirement::findOrFail($id);
        $requirement->update([
            'status' => $request->status,
            'admin_notes' => $request->notes,
        ]);

        return redirect()->route('documents.requirements')
            ->with('success', 'Requirement status updated successfully!');
    }

    /**
     * Delete requirement
     */
    public function destroy($id)
    {
        $requirement = SupplierRequirement::findOrFail($id);
        
        // Delete file if exists
        if ($requirement->business_license) {
            Storage::disk('public')->delete($requirement->business_license);
        }

        $requirement->delete();

        return redirect()->route('documents.requirements')
            ->with('success', 'Requirement deleted successfully!');
    }

    /**
     * View requirement details
     */
    public function show($id)
    {
        $requirement = SupplierRequirement::with('supplier')->findOrFail($id);
        
        return view('admin.documents.requirement.show', compact('requirement'));
    }
}
