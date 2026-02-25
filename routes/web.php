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

Route::get('/supplier/orders', function () {
    return view('supplier.orders');
})->name('supplier.orders')->middleware('auth:supplier');

Route::get('/supplier/returns', function () {
    return view('supplier.returns');
})->name('supplier.returns')->middleware('auth:supplier');

Route::get('/supplier/requirements', [App\Http\Controllers\Supplier\SupplierRequirementController::class, 'index'])->name('supplier.requirements')->middleware('auth:supplier');
Route::post('/supplier/requirements', [App\Http\Controllers\Supplier\SupplierRequirementController::class, 'store'])->name('supplier.requirements.store')->middleware('auth:supplier');

// Supplier Bidding Routes
Route::post('/supplier/bids', [App\Http\Controllers\Supplier\BidController::class, 'store'])->name('supplier.bids.store')->middleware('auth:supplier');

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::get('/warehouse/inventory', function () {
    return view('admin.warehouse.inventory.inventory');
})->name('warehouse.inventory');

Route::get('/warehouse/inbound', function () {
    return view('admin.warehouse.inbound.inbound');
})->name('warehouse.inbound');

Route::get('/warehouse/outbound', function () {
    return view('admin.warehouse.outbound.outbound');
})->name('warehouse.outbound');

Route::get('/warehouse/return', function () {
    return view('admin.warehouse.return.return');
})->name('warehouse.return');

Route::get('/procurement/request', function () {
    return view('admin.procuments.request.request');
})->name('procurement.request');

Route::get('/procurement/po', function () {
    return view('admin.procuments.po.po');
})->name('procurement.po');

// Admin Bid Management Routes
Route::get('/admin/bids', [App\Http\Controllers\Admin\BidController::class, 'index'])->name('admin.bids.index');
Route::get('/admin/requests/{requestId}/bids', [App\Http\Controllers\Admin\BidController::class, 'showRequestBids'])->name('admin.requests.bids');
Route::post('/admin/bids/{bidId}/status', [App\Http\Controllers\Admin\BidController::class, 'updateBidStatus'])->name('admin.bids.update-status');

Route::get('/procurement/supplier', [App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('admin.supplier.index');
Route::get('/admin/supplier/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'show'])->name('admin.supplier.show');
Route::post('/admin/supplier/accept/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'accept'])->name('admin.supplier.accept');
Route::post('/admin/supplier/reject/{id}', [App\Http\Controllers\Admin\SupplierController::class, 'reject'])->name('admin.supplier.reject');

Route::get('/assets/request', function () {
    return view('admin.assets.request.asset-request');
})->name('assets.request');

Route::get('/assets/list', function () {
    return view('admin.assets.list.asset-list');
})->name('assets.list');

Route::get('/assets/maintenance', function () {
    return view('admin.assets.maintenance.maintenance');
})->name('assets.maintenance');

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
