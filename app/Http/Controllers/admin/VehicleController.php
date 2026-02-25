<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleMaintenance;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::orderBy('created_at', 'desc')->get();
        
        return view('admin.logistics.list.list-vehicle', compact('vehicles'));
    }
    
    public function maintenance()
    {
        $maintenances = VehicleMaintenance::with('vehicle')->orderBy('created_at', 'desc')->get();
        
        return view('admin.logistics.maintenance.vehicle-maintenance', compact('maintenances'));
    }
    
    public function create()
    {
        return view('admin.logistics.create.add-vehicle');
    }
    
    public function store(Request $request)
    {
        // Validation rules for vehicle
        $validated = $request->validate([
            'plate_number' => 'nullable|string|max:20|unique:vehicles,plate_number',
            'type' => 'nullable|string|max:100',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'brand' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'capacity' => 'nullable|integer|min:1',
            'driver' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,maintenance,inactive',
        ]);
        
        // Create vehicle in database
        $vehicle = Vehicle::create([
            'plate_number' => $validated['plate_number'] ?? null,
            'type' => $validated['type'] ?? null,
            'year' => $validated['year'] ?? null,
            'brand' => $validated['brand'] ?? null,
            'color' => $validated['color'] ?? null,
            'capacity' => $validated['capacity'] ?? null,
            'driver' => $validated['driver'] ?? null,
            'status' => $validated['status'] ?? 'active',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Vehicle added successfully!',
            'vehicle' => $vehicle
        ]);
    }
    
    public function setMaintenance(Request $request)
    {
        try {
            $validated = $request->validate([
                'vehicle_id' => 'required|integer|exists:vehicles,id',
                'maintenance_reason' => 'required|string|max:1000',
                'maintenance_date' => 'required|date',
            ]);

            // Create maintenance record
            $maintenance = VehicleMaintenance::create([
                'vehicle_id' => $validated['vehicle_id'],
                'maintenance_reason' => $validated['maintenance_reason'],
                'maintenance_date' => $validated['maintenance_date'],
                'status' => 'pending',
            ]);

            // Update vehicle status to maintenance
            $vehicle = Vehicle::find($validated['vehicle_id']);
            if ($vehicle) {
                $vehicle->status = 'maintenance';
                $vehicle->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Maintenance scheduled successfully!',
                'maintenance' => $maintenance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function updateMaintenanceStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:ongoing,done,completed',
            ]);

            $maintenance = VehicleMaintenance::find($id);
            if (!$maintenance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maintenance record not found'
                ], 404);
            }

            $maintenance->status = $validated['status'];
            $maintenance->save();

            // Update vehicle status if maintenance is completed/done
            if (in_array($validated['status'], ['done', 'completed'])) {
                $vehicle = $maintenance->vehicle;
                if ($vehicle) {
                    $vehicle->status = 'active';
                    $vehicle->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Maintenance status updated successfully!',
                'maintenance' => $maintenance
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
