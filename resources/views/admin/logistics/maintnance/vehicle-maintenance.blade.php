@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Vehicle Maintenance</h1>
        <p class="text-slate-500 mt-2">Track and manage vehicle maintenance activities</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Schedule Maintenance
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
            Report
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by maintenance ID, vehicle ID, or plate number..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Pending</option>
                <option>Ongoing</option>
                <option>Done</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Types</option>
                <option>6 Seater</option>
                <option>4 Seater</option>
                <option>Van</option>
                <option>SUV</option>
                <option>Truck</option>
            </select>
            <input type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    {{-- Vehicle Maintenance Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1600px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Maintenance ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Vehicle ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Plate Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Maintenance Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Toyota</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Camry</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">SUV</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">ABC-1234</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Oil change and filter replacement</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">Ongoing</button>
                            <button class="text-green-600 hover:text-green-800 font-medium">Done</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Honda</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Civic</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">6 Seater</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">XYZ-5678</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Brake pad replacement</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Ongoing</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium">Done</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Ford</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Transit</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Van</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">DEF-9012</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Engine tune-up and inspection</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Done</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">View</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Nissan</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Sentra</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">4 Seater</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">GHI-3456</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Tire rotation and alignment</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">Ongoing</button>
                            <button class="text-green-600 hover:text-green-800 font-medium">Done</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN005</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL005</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Isuzu</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Elf</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Truck</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">JKL-7890</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Transmission fluid change</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Ongoing</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium">Done</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN006</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL006</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Mitsubishi</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Outlander</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">SUV</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">MNO-2345</td>
                        <td class="px-6 py-4 text-sm text-slate-600">Air conditioning service</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Done</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">22</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">2</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">3</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">4</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection