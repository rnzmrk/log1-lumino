<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StorageLocation;
use Illuminate\Http\Request;

class StorageLocationController extends Controller
{
    public function index()
    {
        $storageLocations = StorageLocation::orderBy('name')->get();
        return view('admin.warehouse.storage.storage', compact('storageLocations'));
    }

    public function create()
    {
        return view('admin.warehouse.storage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        StorageLocation::create($validated);

        return redirect()->route('warehouse.storage')
            ->with('success', 'Storage location created successfully.');
    }

}
