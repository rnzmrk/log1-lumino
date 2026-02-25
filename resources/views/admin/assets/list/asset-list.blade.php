@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Asset List</h1>
        <p class="text-slate-500 mt-2">Manage and track all company assets</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Add Asset
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Import
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                <circle cx="17" cy="18" r="1.25" fill="currentColor" />
            </svg>
            Export
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by asset ID or item name..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Active</option>
                <option>Maintenance</option>
                <option>Replacement</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Types</option>
                <option>Laptop</option>
                <option>Monitor</option>
                <option>Phone</option>
                <option>Printer</option>
                <option>Other</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Locations</option>
                <option>Office A</option>
                <option>Office B</option>
                <option>Warehouse</option>
                <option>Remote</option>
            </select>
        </div>
    </div>

    {{-- Asset List Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Asset ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Dell Laptop Pro</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Laptop</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Office A</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2 years</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">HP Monitor 24"</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">25</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Monitor</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Office B</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-14</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">3 years</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Maintenance</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">iPhone 15</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">8</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Phone</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Remote</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-13</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">1 year</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Office Chair</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">30</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Other</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Office A</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-12</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">5 years</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST005</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Brother Printer</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">5</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Printer</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Warehouse</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-11</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">4 years</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST006</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">MacBook Pro</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">12</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Laptop</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Office B</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2024-01-10</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">2 years</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Replacement</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-amber-600 hover:text-amber-800 font-medium">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">48</span> results
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