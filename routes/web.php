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

Route::get('/procurement/supplier', function () {
    return view('admin.procuments.supplier.supplier');
})->name('procurement.supplier');

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

// Request Routes
Route::post('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'store'])->name('admin.requests.store');
Route::get('/admin/requests', [App\Http\Controllers\Admin\RequestController::class, 'index'])->name('admin.requests.index');
Route::get('/procurement/request', [App\Http\Controllers\Admin\RequestController::class, 'supplyRequests'])->name('procurement.request');
Route::put('/admin/requests/{id}/status', [App\Http\Controllers\Admin\RequestController::class, 'updateStatus'])->name('admin.requests.updateStatus');
