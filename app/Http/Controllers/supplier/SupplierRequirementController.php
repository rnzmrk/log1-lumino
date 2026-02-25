<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SupplierRequirement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SupplierRequirementController extends Controller
{
    /**
     * Display the requirements page
     */
    public function index()
    {
        $requirements = SupplierRequirement::where('supplier_id', Auth::guard('supplier')->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('supplier.requirements', compact('requirements'));
    }

    /**
     * Store a new requirement
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'years_in_business' => 'required|integer|min:0|max:100',
            'business_license' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string|max:1000',
        ]);

        $businessLicensePath = null;
        if ($request->hasFile('business_license')) {
            $businessLicensePath = $request->file('business_license')->store('business_licenses', 'public');
        }

        SupplierRequirement::create([
            'supplier_id' => Auth::guard('supplier')->user()->id,
            'company_name' => $request->company_name,
            'years_in_business' => $request->years_in_business,
            'business_license' => $businessLicensePath,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('supplier.requirements')
            ->with('success', 'Requirement submitted successfully! Your documents are under review.');
    }

    /**
     * Update requirement status
     */
    public function update(Request $request, $id)
    {
        $requirement = SupplierRequirement::findOrFail($id);
        
        // Only allow owner to update
        if ($requirement->supplier_id !== Auth::guard('supplier')->user()->id) {
            abort(403);
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'years_in_business' => 'required|integer|min:0|max:100',
            'business_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string|max:1000',
        ]);

        $data = [
            'company_name' => $request->company_name,
            'years_in_business' => $request->years_in_business,
            'description' => $request->description,
        ];

        if ($request->hasFile('business_license')) {
            // Delete old file if exists
            if ($requirement->business_license) {
                Storage::disk('public')->delete($requirement->business_license);
            }
            $data['business_license'] = $request->file('business_license')->store('business_licenses', 'public');
        }

        $requirement->update($data);

        return redirect()->route('supplier.requirements')
            ->with('success', 'Requirement updated successfully!');
    }

    /**
     * Delete requirement
     */
    public function destroy($id)
    {
        $requirement = SupplierRequirement::findOrFail($id);
        
        // Only allow owner to delete
        if ($requirement->supplier_id !== Auth::guard('supplier')->user()->id) {
            abort(403);
        }

        // Delete file if exists
        if ($requirement->business_license) {
            Storage::disk('public')->delete($requirement->business_license);
        }

        $requirement->delete();

        return redirect()->route('supplier.requirements')
            ->with('success', 'Requirement deleted successfully!');
    }
}
