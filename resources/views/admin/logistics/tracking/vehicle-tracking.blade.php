@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Vehicle Tracking</h1>
        <p class="text-slate-500 mt-2">Track vehicle movements and status in real-time</p>
    </div>


    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by tracking ID, vehicle ID, or plate number..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Available</option>
                <option>On Trip</option>
            </select>
            <input type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    {{-- Vehicle Tracking Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tracking ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Vehicle ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Plate Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pickup</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Drop Off</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200" id="trackingTableBody">
                    <!-- Data will be loaded from API -->
                    <tr id="loadingRow">
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3 animate-spin">
                                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path d="M12 2a10 10 0 0 1 0 20" stroke="currentColor" stroke-width="2"/>
                                </svg>
                                <p class="text-lg font-medium text-slate-600">Loading tracking data...</p>
                                <p class="text-sm text-slate-500 mt-1">Fetching vehicle tracking information</p>
                            </div>
                        </td>
                    </tr>
                    <tr id="noDataRow" class="hidden">
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                    <path d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p class="text-lg font-medium text-slate-600">No tracking data found</p>
                                <p class="text-sm text-slate-500 mt-1">No vehicles are currently being tracked</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">18</span> results
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

<script>
// Fetch tracking data from API
async function loadTrackingData() {
    const tableBody = document.getElementById('trackingTableBody');
    const loadingRow = document.getElementById('loadingRow');
    const noDataRow = document.getElementById('noDataRow');
    
    try {
        // Show loading state
        loadingRow.classList.remove('hidden');
        noDataRow.classList.add('hidden');
        
        // Fetch data from API - you can change this endpoint
        const response = await fetch('/api/vehicles');
        const vehicles = await response.json();
        
        // Clear loading state
        loadingRow.classList.add('hidden');
        
        if (vehicles.length === 0) {
            noDataRow.classList.remove('hidden');
            return;
        }
        
        // Clear existing rows except loading/no data rows
        const existingRows = tableBody.querySelectorAll('tr:not(#loadingRow):not(#noDataRow)');
        existingRows.forEach(row => row.remove());
        
        // Populate table with API data
        vehicles.forEach((vehicle, index) => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-slate-50';
            
            // Format tracking ID
            const trackingId = `#TRK${String(index + 1).padStart(3, '0')}`;
            const vehicleId = `#VHL${String(vehicle.id).padStart(3, '0')}`;
            
            // Status badge styling
            const statusBadge = vehicle.status === 'active' 
                ? '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Available</span>'
                : '<span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">On Trip</span>';
            
            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">${trackingId}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">${vehicleId}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">${vehicle.plate_number || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">${vehicle.driver || 'Not Assigned'}</td>
                <td class="px-6 py-4 text-sm text-slate-600">${vehicle.pickup_location || 'N/A'}</td>
                <td class="px-6 py-4 text-sm text-slate-600">${vehicle.dropoff_location || 'N/A'}</td>
                <td class="px-6 py-4 whitespace-nowrap">${statusBadge}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <button class="text-blue-600 hover:text-blue-800 font-medium">View</button>
                </td>
            `;
            
            tableBody.appendChild(row);
        });
        
    } catch (error) {
        console.error('Error loading tracking data:', error);
        loadingRow.classList.add('hidden');
        noDataRow.classList.remove('hidden');
        noDataRow.querySelector('p').textContent = 'Error loading tracking data';
        noDataRow.querySelector('p:last-child').textContent = 'Please try again later';
    }
}

// Load data when page loads
document.addEventListener('DOMContentLoaded', loadTrackingData);

// Optional: Refresh data every 30 seconds
setInterval(loadTrackingData, 30000);
</script>
@endsection