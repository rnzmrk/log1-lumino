<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Supplier Website Route
Route::get('/supplier', function () {
    return view('supplier-website');
})->name('supplier.website');

// Supplier Authentication Routes
Route::get('/supplier/login', [App\Http\Controllers\Auth\SupplierAuthController::class, 'showLogin'])->name('supplier.login');
Route::post('/supplier/login', [App\Http\Controllers\Auth\SupplierAuthController::class, 'login'])->name('supplier.login.submit');

Route::get('/supplier/register', [App\Http\Controllers\Auth\SupplierAuthController::class, 'showRegister'])->name('supplier.register');
Route::post('/supplier/register', [App\Http\Controllers\Auth\SupplierAuthController::class, 'register'])->name('supplier.register.submit');

Route::post('/supplier/logout', [App\Http\Controllers\Auth\SupplierAuthController::class, 'logout'])->name('supplier.logout');

Route::get('/supplier/dashboard', function () {
    return view('supplier.dashboard');
})->name('supplier.dashboard')->middleware('auth:supplier');

Route::get('/supplier/biddings', function () {
    return view('supplier.biddings');
})->name('supplier.biddings')->middleware('auth:supplier');

Route::get('/supplier/orders', [App\Http\Controllers\Supplier\SupplierOrderController::class, 'index'])->name('supplier.orders')->middleware('auth:supplier');
Route::put('/supplier/orders/{id}', [App\Http\Controllers\Supplier\SupplierOrderController::class, 'update'])->name('supplier.orders.update')->middleware('auth:supplier');

Route::get('/supplier/inbound', [App\Http\Controllers\Supplier\SupplierInboundController::class, 'index'])->name('supplier.inbound')->middleware('auth:supplier');
Route::get('/supplier/inbound/{id}', [App\Http\Controllers\Supplier\SupplierInboundController::class, 'show'])->name('supplier.inbound.show')->middleware('auth:supplier');
Route::post('/supplier/inbound/{id}/update-status', [App\Http\Controllers\Supplier\SupplierInboundController::class, 'updateStatus'])->name('supplier.inbound.update-status')->middleware('auth:supplier');

Route::get('/supplier/returns', [App\Http\Controllers\supplier\SupplierReturnController::class, 'index'])->name('supplier.returns')->middleware('auth:supplier');
Route::get('/supplier/returns/{id}', [App\Http\Controllers\supplier\SupplierReturnController::class, 'show'])->name('supplier.return.show')->middleware('auth:supplier');
Route::post('/supplier/returns/{id}/update-status', [App\Http\Controllers\supplier\SupplierReturnController::class, 'updateStatus'])->name('supplier.return.update-status')->middleware('auth:supplier');

Route::get('/supplier/requirements', [App\Http\Controllers\Supplier\SupplierRequirementController::class, 'index'])->name('supplier.requirements')->middleware('auth:supplier');
Route::post('/supplier/requirements', [App\Http\Controllers\Supplier\SupplierRequirementController::class, 'store'])->name('supplier.requirements.store')->middleware('auth:supplier');

// Supplier Bidding Routes
Route::post('/supplier/bids', [App\Http\Controllers\Supplier\BidController::class, 'store'])->name('supplier.bids.store')->middleware('auth:supplier');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/warehouse/inventory', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('warehouse.inventory');
Route::get('/admin/inventory/asset-items', [App\Http\Controllers\Admin\AssetController::class, 'getAssetItems'])->name('admin.inventory.asset-items');
Route::get('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'show'])->name('admin.inventory.show');
Route::get('/admin/inventory/{id}/edit', [App\Http\Controllers\Admin\InventoryController::class, 'edit'])->name('admin.inventory.edit');
Route::put('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'update'])->name('admin.inventory.update');
Route::delete('/admin/inventory/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
Route::post('/admin/inventory/{id}/update-status', [App\Http\Controllers\Admin\InventoryController::class, 'updateStatus'])->name('admin.inventory.update-status');

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
Route::get('/admin/bids', [App\Http\Controllers\Admin\BidController::class, 'index'])->name('admin.bids.index');
Route::post('/admin/bids/{id}/status', [App\Http\Controllers\Admin\BidController::class, 'updateBidStatus'])->name('admin.bids.updateStatus');

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

Route::get('/logistics/vehicles', function () {
    return view('admin.logistics.list.list-vehicle');
})->name('logistics.vehicles');

Route::get('/logistics/tracking', function () {
    return view('admin.logistics.tracking.vehicle-tracking');
})->name('logistics.tracking');

Route::get('/logistics/maintenance', function () {
    return view('admin.logistics.maintnance.vehicle-maintenance');
})->name('logistics.maintenance');

Route::get('/documents/reports', function () {
    return view('admin.documents.report.report');
})->name('documents.reports');

Route::get('/documents/requirements', [App\Http\Controllers\Admin\RequirementController::class, 'index'])->name('documents.requirements');
Route::post('/requirements/update-status/{id}', [App\Http\Controllers\Admin\RequirementController::class, 'updateStatus'])->name('requirements.update.status');
Route::delete('/requirements/delete/{id}', [App\Http\Controllers\Admin\RequirementController::class, 'destroy'])->name('requirements.delete');

// Request Routes
Route::post('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'store'])->name('admin.requests.store');
Route::get('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'index'])->name('admin.requests.index');
Route::get('/procurement/request', [App\Http\Controllers\Admin\RequestController::class, 'supplyRequests'])->name('procurement.request');
Route::put('/admin/requests/{id}/status', [App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
Route::post('/admin/requests/{id}/bid', [App\Http\Controllers\Admin\RequestController::class, 'createBid'])->name('admin.requests.createBid');
