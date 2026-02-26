<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BidController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\SupplierAuthController;
use App\Http\Controllers\supplier\SupplierRequirementController;
use App\Http\Controllers\supplier\SupplierOrderController;
use App\Http\Controllers\supplier\SupplierInboundController;
use App\Http\Controllers\supplier\SupplierReturnController;
use Illuminate\Support\Facades\Route;

// Authentication Routes with web middleware
Route::middleware(['web'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.submit');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.verify-otp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('auth.resend-otp');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    // CSRF token refresh endpoint
    Route::get('/csrf-token', function() {
        return response()->json(['token' => csrf_token()]);
    });

    // Legacy route aliases (for backward compatibility)
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
});

// Admin Dashboard Route (requires authentication)
Route::get('/dashboard', function() {
    try {
        // Try to instantiate the controller directly
        $controller = new DashboardController();
        return $controller->index();
    } catch (\Exception $e) {
        // Fallback: return a simple dashboard view
        return view('admin.dashboard');
    }
})->name('dashboard')->middleware('auth');

// Supplier Website Route
Route::get('/supplier', function () {
    return view('supplier-website');
})->name('supplier.website');

// Supplier Authentication Routes
Route::get('/supplier/login', [SupplierAuthController::class, 'showLogin'])->name('supplier.login');
Route::post('/supplier/login', [SupplierAuthController::class, 'login'])->name('supplier.login.submit');

Route::get('/supplier/register', [SupplierAuthController::class, 'showRegister'])->name('supplier.register');
Route::post('/supplier/register', [SupplierAuthController::class, 'register'])->name('supplier.register.submit');

Route::post('/supplier/logout', [SupplierAuthController::class, 'logout'])->name('supplier.logout');

Route::get('/supplier/dashboard', function () {
    return view('supplier.dashboard');
})->name('supplier.dashboard')->middleware('auth:supplier');

Route::get('/supplier/biddings', function () {
    return view('supplier.biddings');
})->name('supplier.biddings')->middleware('auth:supplier');

Route::get('/supplier/orders', [SupplierOrderController::class, 'index'])->name('supplier.orders')->middleware('auth:supplier');
Route::put('/supplier/orders/{id}', [SupplierOrderController::class, 'update'])->name('supplier.orders.update')->middleware('auth:supplier');

Route::get('/supplier/inbound', [SupplierInboundController::class, 'index'])->name('supplier.inbound')->middleware('auth:supplier');
Route::get('/supplier/inbound/{id}', [SupplierInboundController::class, 'show'])->name('supplier.inbound.show')->middleware('auth:supplier');
Route::post('/supplier/inbound/{id}/update-status', [SupplierInboundController::class, 'updateStatus'])->name('supplier.inbound.update-status')->middleware('auth:supplier');

Route::get('/supplier/returns', [SupplierReturnController::class, 'index'])->name('supplier.returns')->middleware('auth:supplier');
Route::get('/supplier/returns/{id}', [SupplierReturnController::class, 'show'])->name('supplier.return.show')->middleware('auth:supplier');

Route::get('/supplier/requirements', [SupplierRequirementController::class, 'index'])->name('supplier.requirements')->middleware('auth:supplier');
Route::post('/supplier/requirements', [SupplierRequirementController::class, 'store'])->name('supplier.requirements.store')->middleware('auth:supplier');

Route::get('/warehouse/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('warehouse.inventory');
Route::get('/admin/inventory/asset-items', [App\Http\Controllers\Admin\AssetController::class, 'getAssetItems'])->name('admin.inventory.asset-items');
Route::get('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'show'])->name('admin.inventory.show');
Route::get('/admin/inventory/{id}/edit', [App\Http\Controllers\Admin\InventoryController::class, 'edit'])->name('admin.inventory.edit');
Route::put('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'update'])->name('admin.inventory.update');
Route::delete('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
Route::post('/admin/inventory/{id}/update-status', [App\Http\Controllers\Admin\InventoryController::class, 'updateStatus'])->name('admin.inventory.update-status');
Route::post('/admin/inventory/{id}/auto-update-status', [App\Http\Controllers\Admin\InventoryController::class, 'autoUpdateStatus'])->name('admin.inventory.auto-update-status');
Route::post('/admin/inventory/batch-update-statuses', [App\Http\Controllers\Admin\InventoryController::class, 'batchUpdateStatuses'])->name('admin.inventory.batch-update-statuses');

Route::get('/warehouse/inbound', [App\Http\Controllers\Admin\InboundController::class, 'index'])->name('warehouse.inbound');
Route::get('/admin/inbound/{id}', [App\Http\Controllers\Admin\InboundController::class, 'show'])->name('admin.inbound.show');
Route::put('/admin/inbound/{id}', [App\Http\Controllers\Admin\InboundController::class, 'update'])->name('admin.inbound.update');
Route::post('/admin/inbound/{id}/move-to-inventory', [App\Http\Controllers\Admin\InboundController::class, 'moveToInventory'])->name('admin.inbound.move-to-inventory');
Route::post('/admin/inbound/{id}/update-status', [App\Http\Controllers\Admin\InboundController::class, 'updateStatus'])->name('admin.inbound.update-status');
Route::post('/admin/inbound/store', [App\Http\Controllers\Admin\InboundController::class, 'store'])->name('admin.inbound.store');

Route::get('/warehouse/storage', [App\Http\Controllers\Admin\StorageLocationController::class, 'index'])->name('warehouse.storage');
Route::get('/warehouse/storage/create', [App\Http\Controllers\Admin\StorageLocationController::class, 'create'])->name('warehouse.storage.create');
Route::post('/warehouse/storage', [App\Http\Controllers\Admin\StorageLocationController::class, 'store'])->name('warehouse.storage.store');
Route::put('/warehouse/storage/{id}', [App\Http\Controllers\Admin\StorageLocationController::class, 'update'])->name('warehouse.storage.update');
Route::delete('/warehouse/storage/{id}', [App\Http\Controllers\Admin\StorageLocationController::class, 'destroy'])->name('warehouse.storage.destroy');

Route::get('/warehouse/outbound', [App\Http\Controllers\Admin\OutboundController::class, 'index'])->name('warehouse.outbound');
Route::get('/admin/outbound/{id}', [App\Http\Controllers\Admin\OutboundController::class, 'show'])->name('admin.outbound.show');
Route::post('/admin/outbound/store', [App\Http\Controllers\Admin\OutboundController::class, 'store'])->name('admin.outbound.store');
Route::post('/admin/outbound/{id}/update-status', [App\Http\Controllers\Admin\OutboundController::class, 'updateStatus'])->name('admin.outbound.update-status');

Route::get('/warehouse/return', [App\Http\Controllers\Admin\ItemReturnController::class, 'index'])->name('warehouse.return');
Route::get('/admin/return/{id}', [App\Http\Controllers\Admin\ItemReturnController::class, 'show'])->name('admin.return.show');
Route::post('/admin/return/store', [App\Http\Controllers\Admin\ItemReturnController::class, 'store'])->name('admin.return.store');
Route::post('/admin/return/{id}/update-status', [App\Http\Controllers\Admin\ItemReturnController::class, 'updateStatus'])->name('admin.return.update-status');

Route::get('/procurement/request', function () {
    return view('admin.procuments.request.request');
})->name('procurement.request');

Route::get('/procurement/po', [App\Http\Controllers\Admin\PurchaseOrderController::class, 'index'])->name('procurement.po');

// Admin Bid Management Routes
Route::get('/admin/bids', [BidController::class, 'index'])->name('admin.bids.index');
Route::post('/admin/bids/{id}/status', [BidController::class, 'updateBidStatus'])->name('admin.bids.updateStatus');

// Admin Purchase Order Routes
Route::get('/admin/purchase-orders', [App\Http\Controllers\Admin\PurchaseOrderController::class, 'index'])->name('admin.purchase-orders.index');
Route::get('/admin/purchase-orders/create', [App\Http\Controllers\Admin\PurchaseOrderController::class, 'create'])->name('admin.purchase-orders.create');
Route::post('/admin/purchase-orders', [App\Http\Controllers\Admin\PurchaseOrderController::class, 'store'])->name('admin.purchase-orders.store');

Route::get('/procurement/supplier', [App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('admin.supplier.index');
Route::get('/admin/supplier/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'show'])->name('admin.supplier.show');
Route::post('/admin/supplier/accept/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'accept'])->name('admin.supplier.accept');
Route::post('/admin/supplier/reject/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'reject'])->name('admin.supplier.reject');

Route::get('/assets/request', [App\Http\Controllers\Admin\RequestController::class, 'assetRequests'])->name('assets.requests');
Route::post('/admin/requests/search', [App\Http\Controllers\Admin\RequestController::class, 'search'])->name('admin.requests.search');
Route::post('/admin/requests/store', [App\Http\Controllers\Admin\RequestController::class, 'store'])->name('admin.requests.store');
Route::post('/admin/requests/{id}/status', [App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('admin.requests.update-status');

Route::get('/assets/list', [App\Http\Controllers\Admin\AssetController::class, 'index'])->name('assets.list');
Route::post('/admin/assets/store', [App\Http\Controllers\Admin\AssetController::class, 'store'])->name('admin.assets.store');
Route::post('/admin/assets/maintenance', [App\Http\Controllers\Admin\AssetController::class, 'setMaintenance'])->name('admin.assets.maintenance');
Route::get('/admin/assets/maintenance', [App\Http\Controllers\Admin\AssetController::class, 'maintenanceIndex'])->name('admin.maintenance.index');
Route::post('/admin/assets/maintenance/{id}/status', [App\Http\Controllers\Admin\AssetController::class, 'updateMaintenanceStatus'])->name('admin.maintenance.update-status');
Route::get('/admin/assets/{id}', [App\Http\Controllers\Admin\AssetController::class, 'show'])->name('admin.assets.show');
Route::get('/admin/assets/{id}/edit', [App\Http\Controllers\Admin\AssetController::class, 'edit'])->name('admin.assets.edit');
Route::put('/admin/assets/{id}', [App\Http\Controllers\Admin\AssetController::class, 'update'])->name('admin.assets.update');
Route::delete('/admin/assets/{id}', [App\Http\Controllers\Admin\AssetController::class, 'destroy'])->name('admin.assets.destroy');
Route::post('/admin/assets/{id}/status', [App\Http\Controllers\Admin\AssetController::class, 'updateStatus'])->name('admin.assets.update-status');

Route::get('/logistics/vehicles', [App\Http\Controllers\Admin\VehicleController::class, 'index'])->name('logistics.vehicles');
Route::get('/logistics/vehicles/create', [App\Http\Controllers\Admin\VehicleController::class, 'create'])->name('logistics.vehicles.create');
Route::post('/logistics/vehicles', [App\Http\Controllers\Admin\VehicleController::class, 'store'])->name('logistics.vehicles.store');
Route::get('/logistics/vehicles/maintenance', [App\Http\Controllers\Admin\VehicleController::class, 'maintenance'])->name('logistics.vehicles.maintenance');
Route::post('/admin/vehicles/maintenance', [App\Http\Controllers\Admin\VehicleController::class, 'setMaintenance'])->name('admin.vehicles.maintenance');
Route::post('/admin/vehicles/maintenance/{id}/status', [App\Http\Controllers\Admin\VehicleController::class, 'updateMaintenanceStatus'])->name('admin.vehicles.maintenance.update-status');

Route::get('/logistics/tracking', function () {
    return view('admin.logistics.tracking.vehicle-tracking');
})->name('logistics.tracking');

Route::get('/documents/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('documents.reports');
Route::get('/reports/export/vehicles', [App\Http\Controllers\Admin\ReportController::class, 'exportVehicles'])->name('reports.export.vehicles');
Route::get('/reports/export/maintenance', [App\Http\Controllers\Admin\ReportController::class, 'exportMaintenance'])->name('reports.export.maintenance');
Route::get('/reports/export/users', [App\Http\Controllers\Admin\ReportController::class, 'exportUsers'])->name('reports.export.users');
Route::get('/reports/export/purchase-orders', [App\Http\Controllers\Admin\ReportController::class, 'exportPurchaseOrders'])->name('reports.export.purchase-orders');
Route::get('/reports/export/requests', [App\Http\Controllers\Admin\ReportController::class, 'exportRequests'])->name('reports.export.requests');
Route::get('/reports/export/all', [App\Http\Controllers\Admin\ReportController::class, 'exportAll'])->name('reports.export.all');

// Supplier Account Routes
Route::get('/supplier-accounts', [App\Http\Controllers\Admin\SupplierAccountController::class, 'index'])->name('supplier-accounts.index');
Route::get('/supplier-accounts/{id}/edit', [App\Http\Controllers\Admin\SupplierAccountController::class, 'edit'])->name('supplier-accounts.edit');
Route::put('/supplier-accounts/{id}', [App\Http\Controllers\Admin\SupplierAccountController::class, 'update'])->name('supplier-accounts.update');
Route::delete('/supplier-accounts/{id}', [App\Http\Controllers\Admin\SupplierAccountController::class, 'destroy'])->name('supplier-accounts.destroy');
Route::put('/supplier-accounts/{id}/status', [App\Http\Controllers\Admin\SupplierAccountController::class, 'updateStatus'])->name('supplier-accounts.update-status');

// Dashboard Routes
Route::get('/api/dashboard/stats', [App\Http\Controllers\Admin\DashboardController::class, 'getStats'])->name('dashboard.stats')->middleware('auth');
Route::get('/api/dashboard/activities', [App\Http\Controllers\Admin\DashboardController::class, 'getRecentActivities'])->name('dashboard.activities')->middleware('auth');
Route::get('/api/dashboard/charts', [App\Http\Controllers\Admin\DashboardController::class, 'getChartsData'])->name('dashboard.charts')->middleware('auth');

Route::get('/documents/requirements', [App\Http\Controllers\Admin\RequirementController::class, 'index'])->name('documents.requirements');
Route::post('/requirements/update-status/{id}', [App\Http\Controllers\Admin\RequirementController::class, 'updateStatus'])->name('requirements.update.status');
Route::delete('/requirements/delete/{id}', [App\Http\Controllers\Admin\RequirementController::class, 'destroy'])->name('requirements.delete');

// Request Routes
Route::post('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'store'])->name('admin.requests.store');
Route::get('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'index'])->name('admin.requests.index');
Route::get('/procurement/request', [App\Http\Controllers\Admin\RequestController::class, 'supplyRequests'])->name('procurement.request');
Route::put('/admin/requests/{id}/status', [App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
Route::post('/admin/requests/{id}/bid', [App\Http\Controllers\Admin\RequestController::class, 'createBid'])->name('admin.requests.createBid');
