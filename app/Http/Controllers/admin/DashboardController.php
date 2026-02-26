<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\VehicleMaintenance;
use App\Models\User;
use App\Models\PurchaseOrder;
use App\Models\Request as RequestModel;
use App\Models\Asset;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'active')->count(),
            'maintenance_pending' => VehicleMaintenance::where('status', 'pending')->count(),
            'maintenance_ongoing' => VehicleMaintenance::where('status', 'ongoing')->count(),
            'total_users' => User::count(),
            'active_users' => User::count(), // All users are considered active for now
            'total_purchase_orders' => PurchaseOrder::count(),
            'pending_purchase_orders' => PurchaseOrder::where('status', 'pending')->count(),
            'total_requests' => RequestModel::count(),
            'pending_requests' => RequestModel::where('status', 'pending')->count(),
            'total_assets' => Asset::count(),
            'active_assets' => Asset::where('status', 'active')->count(),
            'maintenance_assets' => Asset::where('status', 'maintenance')->count(),
            'total_suppliers' => Supplier::count(),
            'active_suppliers' => Supplier::where('status', 'active')->count(),
        ];

        // Get recent activities
        $recentActivities = [
            'recent_vehicles' => Vehicle::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_maintenance' => VehicleMaintenance::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_requests' => RequestModel::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_purchase_orders' => PurchaseOrder::orderBy('created_at', 'desc')->take(5)->get(),
        ];

        // Get charts data
        $chartsData = [
            'vehicle_status' => [
                'active' => Vehicle::where('status', 'active')->count(),
                'inactive' => Vehicle::where('status', 'inactive')->count(),
                'maintenance' => Vehicle::where('status', 'maintenance')->count(),
            ],
            'maintenance_status' => [
                'pending' => VehicleMaintenance::where('status', 'pending')->count(),
                'ongoing' => VehicleMaintenance::where('status', 'ongoing')->count(),
                'done' => VehicleMaintenance::where('status', 'done')->count(),
            ],
            'request_status' => [
                'pending' => RequestModel::where('status', 'pending')->count(),
                'approved' => RequestModel::where('status', 'approved')->count(),
                'rejected' => RequestModel::where('status', 'rejected')->count(),
            ],
            'purchase_order_status' => [
                'pending' => PurchaseOrder::where('status', 'pending')->count(),
                'approved' => PurchaseOrder::where('status', 'approved')->count(),
                'rejected' => PurchaseOrder::where('status', 'rejected')->count(),
            ],
        ];

        return view('admin.dashboard', compact('stats', 'recentActivities', 'chartsData'));
    }

    public function getStats()
    {
        // API endpoint for real-time stats
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'active')->count(),
            'maintenance_pending' => VehicleMaintenance::where('status', 'pending')->count(),
            'maintenance_ongoing' => VehicleMaintenance::where('status', 'ongoing')->count(),
            'total_users' => User::count(),
            'active_users' => User::count(), // All users are considered active for now
            'total_purchase_orders' => PurchaseOrder::count(),
            'pending_purchase_orders' => PurchaseOrder::where('status', 'pending')->count(),
            'total_requests' => RequestModel::count(),
            'pending_requests' => RequestModel::where('status', 'pending')->count(),
            'total_assets' => Asset::count(),
            'active_assets' => Asset::where('status', 'active')->count(),
            'maintenance_assets' => Asset::where('status', 'maintenance')->count(),
            'total_suppliers' => Supplier::count(),
            'active_suppliers' => Supplier::where('status', 'active')->count(),
        ];

        return response()->json($stats);
    }

    public function getRecentActivities()
    {
        // API endpoint for recent activities
        $recentActivities = [
            'recent_vehicles' => Vehicle::with('driver')->orderBy('created_at', 'desc')->take(5)->get(),
            'recent_maintenance' => VehicleMaintenance::with('vehicle')->orderBy('created_at', 'desc')->take(5)->get(),
            'recent_requests' => RequestModel::orderBy('created_at', 'desc')->take(5)->get(),
            'recent_purchase_orders' => PurchaseOrder::orderBy('created_at', 'desc')->take(5)->get(),
        ];

        return response()->json($recentActivities);
    }

    public function getChartsData()
    {
        // API endpoint for charts data
        $chartsData = [
            'vehicle_status' => [
                'active' => Vehicle::where('status', 'active')->count(),
                'inactive' => Vehicle::where('status', 'inactive')->count(),
                'maintenance' => Vehicle::where('status', 'maintenance')->count(),
            ],
            'maintenance_status' => [
                'pending' => VehicleMaintenance::where('status', 'pending')->count(),
                'ongoing' => VehicleMaintenance::where('status', 'ongoing')->count(),
                'done' => VehicleMaintenance::where('status', 'done')->count(),
            ],
            'request_status' => [
                'pending' => RequestModel::where('status', 'pending')->count(),
                'approved' => RequestModel::where('status', 'approved')->count(),
                'rejected' => RequestModel::where('status', 'rejected')->count(),
            ],
            'purchase_order_status' => [
                'pending' => PurchaseOrder::where('status', 'pending')->count(),
                'approved' => PurchaseOrder::where('status', 'approved')->count(),
                'rejected' => PurchaseOrder::where('status', 'rejected')->count(),
            ],
        ];

        return response()->json($chartsData);
    }
}
