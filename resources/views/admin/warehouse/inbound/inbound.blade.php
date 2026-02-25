@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Inbound Inventory</h1>
        <p class="text-slate-500 mt-2">Track and manage incoming inventory shipments</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-4">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Inbound</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">47</p>
                    <p class="text-sm text-slate-500 mt-1">All shipments</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-blue-600">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">In Transit</p>
                    <p class="text-2xl font-bold text-amber-600 mt-2">12</p>
                    <p class="text-sm text-slate-500 mt-1">On the way</p>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-amber-600">
                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Arrived</p>
                    <p class="text-2xl font-bold text-blue-600 mt-2">25</p>
                    <p class="text-sm text-slate-500 mt-1">At warehouse</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-blue-600">
                        <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Received</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">10</p>
                    <p class="text-sm text-slate-500 mt-1">Processed</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-green-600">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            New Inbound
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            History
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                <circle cx="17" cy="18" r="1.25" fill="currentColor" />
            </svg>
            Request
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by item name, PO ID, or inbound ID..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Pending</option>
                <option>In Transit</option>
                <option>Arrived</option>
                <option>Received</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Types</option>
                <option>Supplies</option>
                <option>Equipment</option>
                <option>Materials</option>
            </select>
        </div>
    </div>

    {{-- Inbound Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-white border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-36">Inbound ID</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-32">PO ID</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 min-w-[200px]">Item Name</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-28">Quantity</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-40">Location</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-32">Type</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 min-w-[300px]">Description</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-40">Supplier</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-36">Status Instance</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-32">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB001</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO0456</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Office Paper A4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">1000</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse A-1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Supplies</td>
                    <td class="px-6 py-4 text-sm text-slate-600">Standard A4 office paper, 80gsm, white - Premium quality</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Office Supplies Co</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">In Transit</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</button>
                        <button class="text-green-600 hover:text-green-800 font-medium transition-colors">Receive</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB002</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO0457</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Laptop Stand</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">50</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse B-2</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Equipment</td>
                    <td class="px-6 py-4 text-sm text-slate-600">Adjustable aluminum laptop stand for ergonomic use</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">TechGear Inc</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Arrived</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</button>
                        <button class="text-green-600 hover:text-green-800 font-medium transition-colors">Receive</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB003</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO0458</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Printer Toner Black</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">25</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse A-3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Supplies</td>
                    <td class="px-6 py-4 text-sm text-slate-600">HP LaserJet toner cartridge, black, compatible with various models</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">PrintMaster Ltd</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Pending</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</button>
                        <button class="text-green-600 hover:text-green-800 font-medium transition-colors">Receive</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB004</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO0459</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Safety Gloves</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">500</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse C-1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Supplies</td>
                    <td class="px-6 py-4 text-sm text-slate-600">Disposable nitrile gloves, size large, powder-free</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">SafetyFirst Corp</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Arrived</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</button>
                        <button class="text-green-600 hover:text-green-800 font-medium transition-colors">Receive</button>
                    </td>
                </tr>
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB005</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO0460</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">USB Cable 3m</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">100</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse B-1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Equipment</td>
                    <td class="px-6 py-4 text-sm text-slate-600">USB 2.0 extension cable, 3 meters, black</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">CablePro Solutions</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">Received</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</button>
                        <button class="text-slate-400 font-medium cursor-not-allowed">Receive</button>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">47</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">2</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">3</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection