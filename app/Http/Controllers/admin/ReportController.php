<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleMaintenance;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\Request as RequestModel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.documents.report.report');
    }

    public function exportVehicles()
    {
        $vehicles = Vehicle::all();
        
        $csvContent = "ID,Plate Number,Brand,Type,Year,Color,Capacity,Driver,Status,Created At\n";
        
        foreach ($vehicles as $vehicle) {
            $csvContent .= "{$vehicle->id},{$vehicle->plate_number},{$vehicle->brand},{$vehicle->type},{$vehicle->year},{$vehicle->color},{$vehicle->capacity},{$vehicle->driver},{$vehicle->status},{$vehicle->created_at}\n";
        }
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="vehicles_report.csv"');
    }

    public function exportMaintenance()
    {
        $maintenances = VehicleMaintenance::with('vehicle')->get();
        
        $csvContent = "ID,Vehicle ID,Vehicle Plate,Brand,Type,Maintenance Reason,Maintenance Date,Status,Created At\n";
        
        foreach ($maintenances as $maintenance) {
            $vehiclePlate = isset($maintenance->vehicle->plate_number) ? $maintenance->vehicle->plate_number : 'N/A';
            $vehicleBrand = isset($maintenance->vehicle->brand) ? $maintenance->vehicle->brand : 'N/A';
            $vehicleType = isset($maintenance->vehicle->type) ? $maintenance->vehicle->type : 'N/A';
            
            $csvContent .= "{$maintenance->id},{$maintenance->vehicle_id},{$vehiclePlate},{$vehicleBrand},{$vehicleType},{$maintenance->maintenance_reason},{$maintenance->maintenance_date},{$maintenance->status},{$maintenance->created_at}\n";
        }
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="maintenance_report.csv"');
    }

    public function exportUsers()
    {
        $users = User::all();
        
        $csvContent = "ID,Name,Email,Role,Created At\n";
        
        foreach ($users as $user) {
            $userRole = isset($user->role) ? $user->role : 'N/A';
            $csvContent .= "{$user->id},{$user->name},{$user->email},{$userRole},{$user->created_at}\n";
        }
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="users_report.csv"');
    }

    public function exportPurchaseOrders()
    {
        $orders = PurchaseOrder::all();
        
        $csvContent = "ID,PO Number,Supplier,Total Amount,Status,Created At\n";
        
        foreach ($orders as $order) {
            $csvContent .= "{$order->id},{$order->po_number},{$order->supplier},{$order->total_amount},{$order->status},{$order->created_at}\n";
        }
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="purchase_orders_report.csv"');
    }

    public function exportRequests()
    {
        $requests = RequestModel::all();
        
        $csvContent = "ID,Request Number,Request Type,Status,Priority,Created At\n";
        
        foreach ($requests as $request) {
            $csvContent .= "{$request->id},{$request->request_number},{$request->request_type},{$request->status},{$request->priority},{$request->created_at}\n";
        }
        
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="requests_report.csv"');
    }

    public function exportAll()
    {
        // This will trigger JavaScript to download all files
        return response()->json(['message' => 'Export all reports initiated']);
    }
}
