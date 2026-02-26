@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Reports & Exports</h1>
        <p class="text-slate-500 mt-2">Generate and export CSV reports for all system tables</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button onclick="exportAllReports()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Export All Reports
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                <circle cx="17" cy="18" r="1.25" fill="currentColor" />
            </svg>
            Schedule Reports
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search for reports..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Categories</option>
                <option>Assets</option>
                <option>Logistics</option>
                <option>Warehouse</option>
                <option>Procurement</option>
            </select>
        </div>
    </div>

    {{-- Report Cards Grid --}}
    <div class="px-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        
        {{-- Assets Section --}}
        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-blue-600">
                        <path d="M20 7H4a2 2 0 00-2 2v6a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M8 21h8m-4-4v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Assets</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Asset List</h3>
            <p class="text-sm text-slate-600 mb-4">Export complete asset inventory with status and location details</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>28 records</span>
                <span>Last updated: 2 hours ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-amber-600">
                        <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Assets</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Asset Request</h3>
            <p class="text-sm text-slate-600 mb-4">Export all asset requests with status and approval details</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>15 records</span>
                <span>Last updated: 1 hour ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-purple-600">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Assets</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Asset Maintenance</h3>
            <p class="text-sm text-slate-600 mb-4">Export asset maintenance records and schedules</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>28 records</span>
                <span>Last updated: 30 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        {{-- Logistics Section --}}
        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-green-600">
                        <path d="M3.75 7.5h9v9h-9V7.5zM12.75 9h3.75l3 3.75v3.75h-6.75V9z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="7.5" cy="17.25" r="1.25" fill="currentColor" />
                        <circle cx="16.5" cy="17.25" r="1.25" fill="currentColor" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Logistics</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Vehicle List</h3>
            <p class="text-sm text-slate-600 mb-4">Export complete vehicle fleet information</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>24 records</span>
                <span>Last updated: 45 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-blue-600">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Logistics</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Vehicle Tracking</h3>
            <p class="text-sm text-slate-600 mb-4">Export vehicle tracking and trip history data</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>18 records</span>
                <span>Last updated: 15 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-amber-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-amber-600">
                        <path d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Logistics</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Vehicle Maintenance</h3>
            <p class="text-sm text-slate-600 mb-4">Export vehicle maintenance records and schedules</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>22 records</span>
                <span>Last updated: 1 hour ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        {{-- Warehouse Section --}}
        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-indigo-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-indigo-600">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Warehouse</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Warehouse Inventory</h3>
            <p class="text-sm text-slate-600 mb-4">Export complete warehouse inventory and stock levels</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>156 records</span>
                <span>Last updated: 5 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-green-600">
                        <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Warehouse</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Warehouse Inbound</h3>
            <p class="text-sm text-slate-600 mb-4">Export inbound shipments and receiving records</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>42 records</span>
                <span>Last updated: 20 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-red-600">
                        <path d="M17 16V4m0 0L21 8m-4-4l-4 4m-4 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Warehouse</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Warehouse Outbound</h3>
            <p class="text-sm text-slate-600 mb-4">Export outbound shipments and delivery records</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>38 records</span>
                <span>Last updated: 10 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        {{-- Procurement Section --}}
        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-purple-600">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Procurement</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Procurement Request</h3>
            <p class="text-sm text-slate-600 mb-4">Export procurement requests and approval status</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>31 records</span>
                <span>Last updated: 25 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-blue-600">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Procurement</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Purchase Order</h3>
            <p class="text-sm text-slate-600 mb-4">Export purchase orders and vendor information</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>18 records</span>
                <span>Last updated: 35 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6 text-green-600">
                        <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="17 21 17 13 7 13 7 21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="7 3 7 8 15 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-full">Procurement</span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Supplier</h3>
            <p class="text-sm text-slate-600 mb-4">Export supplier information and contact details</p>
            <div class="flex items-center justify-between text-xs text-slate-500 mb-4">
                <span>25 records</span>
                <span>Last updated: 40 mins ago</span>
            </div>
            <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Export CSV
            </button>
        </div>

    </div>

</div>

<script>
// Export individual report functions
function exportVehicles() {
    window.location.href = '/reports/export/vehicles';
}

function exportMaintenance() {
    window.location.href = '/reports/export/maintenance';
}

function exportUsers() {
    window.location.href = '/reports/export/users';
}

function exportPurchaseOrders() {
    window.location.href = '/reports/export/purchase-orders';
}

function exportRequests() {
    window.location.href = '/reports/export/requests';
}

// Export all reports function
function exportAllReports() {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Exporting...';
    button.disabled = true;
    
    // Array of all export functions
    const exports = [
        { name: 'Vehicles', url: '/reports/export/vehicles' },
        { name: 'Maintenance', url: '/reports/export/maintenance' },
        { name: 'Users', url: '/reports/export/users' },
        { name: 'Purchase Orders', url: '/reports/export/purchase-orders' },
        { name: 'Requests', url: '/reports/export/requests' }
    ];
    
    // Download all files with a small delay between each
    exports.forEach((exportItem, index) => {
        setTimeout(() => {
            const link = document.createElement('a');
            link.href = exportItem.url;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Reset button on last export
            if (index === exports.length - 1) {
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 1000);
            }
        }, index * 500); // 500ms delay between downloads
    });
}

// Add click handlers to all export buttons
document.addEventListener('DOMContentLoaded', function() {
    // Vehicle List button
    const vehicleButtons = document.querySelectorAll('button');
    vehicleButtons.forEach(button => {
        const card = button.closest('.bg-white');
        if (card) {
            const title = card.querySelector('h3');
            if (title) {
                const titleText = title.textContent.trim();
                
                switch(titleText) {
                    case 'Vehicle List':
                        button.setAttribute('onclick', 'exportVehicles()');
                        break;
                    case 'Vehicle Maintenance':
                        button.setAttribute('onclick', 'exportMaintenance()');
                        break;
                    case 'Vehicle Tracking':
                        button.setAttribute('onclick', 'exportVehicles()');
                        break;
                    case 'Asset List':
                        button.setAttribute('onclick', 'exportVehicles()');
                        break;
                    case 'Asset Maintenance':
                        button.setAttribute('onclick', 'exportMaintenance()');
                        break;
                    case 'Asset Request':
                        button.setAttribute('onclick', 'exportRequests()');
                        break;
                    case 'Purchase Order':
                        button.setAttribute('onclick', 'exportPurchaseOrders()');
                        break;
                    case 'Procurement Request':
                        button.setAttribute('onclick', 'exportRequests()');
                        break;
                    case 'Supplier':
                        button.setAttribute('onclick', 'exportPurchaseOrders()');
                        break;
                    case 'Warehouse Inventory':
                        button.setAttribute('onclick', 'exportVehicles()');
                        break;
                    case 'Warehouse Inbound':
                        button.setAttribute('onclick', 'exportRequests()');
                        break;
                    case 'Warehouse Outbound':
                        button.setAttribute('onclick', 'exportRequests()');
                        break;
                    default:
                        // Default to vehicles export for unmapped cards
                        button.setAttribute('onclick', 'exportVehicles()');
                        break;
                }
            }
        }
    });
});
</script>
@endsection