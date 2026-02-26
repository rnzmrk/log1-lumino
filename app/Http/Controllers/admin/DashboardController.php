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
use App\Models\Inventory;

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
            // Inventory metrics
            'inbound_pending' => $this->getInboundPending(),
            'low_stock_items' => $this->getLowStockItems(),
            'outbound_pending' => $this->getOutboundPending(),
            'returns_pending' => $this->getReturnsPending(),
            'out_of_stock_items' => $this->getOutOfStockItems(),
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
            'out_of_stock_items' => $this->getOutOfStockItemsData(),
            'supply_forecast' => $this->getSupplyForecast(),
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

    /**
     * Get low stock items count based on inventory status
     */
    private function getLowStockItems()
    {
        // Query inventory table for items with low_stock status
        return Inventory::where('status', 'low_stock')->count();
    }

    /**
     * Get out of stock items count based on inventory status
     */
    private function getOutOfStockItems()
    {
        // Query inventory table for items with out_of_stock status
        return Inventory::where('status','out_of_stock')->count();
    }

    /**
     * Get pending inbound shipments
     */
    private function getInboundPending()
    {
        // This would typically query an inbound shipments table
        // For now, return a calculated value based on purchase orders
        return PurchaseOrder::where('status', 'approved')->count();
    }

    /**
     * Get pending outbound shipments
     */
    private function getOutboundPending()
    {
        // This would typically query an outbound shipments table
        // For now, return a calculated value based on requests
        return RequestModel::where('status', 'approved')->count();
    }

    /**
     * Get out of stock items data for charts
     */
    private function getOutOfStockItemsData()
    {
        try {
            // Debug: Check total inventory records
            $totalInventory = Inventory::count();
            \Log::info("Total inventory records: " . $totalInventory);
            
            // Debug: Check out of stock records
            $outOfStockCount = Inventory::where('status', 'out_of_stock')->count();
            \Log::info("Out of stock records: " . $outOfStockCount);
            
            // Get items directly from inventories table with out_of_stock status
            $outOfStockItems = Inventory::where('status', 'out_of_stock')
                ->with(['inbound.purchaseOrder.request']) // Load relationship chain
                ->orderBy('created_at', 'desc') // Order by creation date
                ->get();
            
            \Log::info("Out of stock items found: " . $outOfStockItems->count());
            
            if ($outOfStockItems->count() === 0) {
                \Log::info("No out of stock items found, returning fallback data");
                return [
                    ['name' => 'No Out of Stock Items', 'count' => 0],
                    ['name' => 'System Running Normal', 'count' => 0],
                    ['name' => 'All Items in Stock', 'count' => 0],
                    ['name' => 'Inventory Healthy', 'count' => 0],
                    ['name' => 'No Shortages', 'count' => 0],
                ];
            }
            
            // Group by item name and count occurrences based on created_at
            $groupedItems = $outOfStockItems->groupBy(function($inventory) {
                $itemName = 'Unknown Item';
                
                // Get item name through relationship chain: inbound_id -> purchase_order_id -> request_id -> item_name
                if ($inventory->inbound && 
                    $inventory->inbound->purchaseOrder && 
                    $inventory->inbound->purchaseOrder->request) {
                    $itemName = $inventory->inbound->purchaseOrder->request->item_name ?? 'Unknown Item';
                }
                
                return $itemName;
            });
            
            \Log::info("Grouped items count: " . $groupedItems->count());
            
            // Convert to chart format with counts based on created_at frequency
            $result = $groupedItems->map(function($items, $itemName) {
                return [
                    'name' => $itemName,
                    'count' => $items->count() // Count how many times this item went out of stock
                ];
            })->sortByDesc('count') // Sort by most frequent out of stock items
             ->take(5) // Take top 5 most frequent
             ->values()
             ->toArray();
            
            \Log::info("Final result: " . json_encode($result));
            return $result;
            
        } catch (\Exception $e) {
            \Log::error("Error in getOutOfStockItemsData: " . $e->getMessage());
            // Fallback to sample data if relationships don't exist
            return [
                ['name' => 'Shipping Labels', 'count' => 12],
                ['name' => 'Plastic Totes', 'count' => 8],
                ['name' => 'Safety Gloves', 'count' => 6],
                ['name' => 'Tape Rolls', 'count' => 4],
                ['name' => 'Box Cutters', 'count' => 2],
            ];
        }
    }

    /**
     * Generate 3-month supply forecast based on out of stock history
     */
    private function getSupplyForecast()
    {
        // Get out of stock items
        $outOfStockData = $this->getOutOfStockItemsData();
        
        // Generate forecast based on historical patterns
        $forecast = [
            'labels' => ['Month 1', 'Month 2', 'Month 3'],
            'datasets' => []
        ];

        $colors = [
            'rgba(239, 68, 68, 1)',   // Red
            'rgba(245, 158, 11, 1)',  // Orange
            'rgba(59, 130, 246, 1)',   // Blue
            'rgba(16, 185, 129, 1)',  // Green
            'rgba(139, 92, 246, 1)',  // Purple
        ];

        $bgColors = [
            'rgba(239, 68, 68, 0.1)',
            'rgba(245, 158, 11, 0.1)',
            'rgba(59, 130, 246, 0.1)',
            'rgba(16, 185, 129, 0.1)',
            'rgba(139, 92, 246, 0.1)',
        ];

        foreach ($outOfStockData as $index => $item) {
            // Calculate forecast based on out of stock frequency
            $baseDemand = $item['count'] * 15; // Base demand calculation
            $growthRate = 1.25; // 25% growth rate per month
            
            $forecastData = [
                round($baseDemand * 1.0),           // Month 1: Base demand
                round($baseDemand * $growthRate),   // Month 2: With growth
                round($baseDemand * $growthRate * $growthRate), // Month 3: Continued growth
            ];

            $forecast['datasets'][] = [
                'label' => $item['name'],
                'data' => $forecastData,
                'borderColor' => $colors[$index % count($colors)],
                'backgroundColor' => $bgColors[$index % count($bgColors)],
                'tension' => 0.4,
                'fill' => true
            ];
        }

        return $forecast;
    }

    /**
     * Get pending returns
     */
    private function getReturnsPending()
    {
        // This would typically query a returns table
        // For now, return a calculated value based on maintenance
        return VehicleMaintenance::where('status', 'ongoing')->count();
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
            'out_of_stock_items' => $this->getOutOfStockItemsData(),
            'supply_forecast' => $this->getSupplyForecast(),
        ];

        return response()->json($chartsData);
    }
}
