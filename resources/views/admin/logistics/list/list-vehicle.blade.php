@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Vehicle List</h1>
        <p class="text-slate-500 mt-2">Manage and track all company vehicles</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" onclick="window.location.href='{{ route('logistics.vehicles.create') }}'">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Add Vehicle 
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Import
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Export
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by vehicle ID, brand, or plate number..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Active</option>
                <option>Maintenance</option>
                <option>Replacement</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Types</option>
                <option>6 Seater</option>
                <option>4 Seater</option>
                <option>SUV</option>
                <option>Truck</option>
            </select>
            <input type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    {{-- Vehicle Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Vehicle ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Plate Number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Color</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Driver</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#VHL{{ str_pad($vehicle->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $vehicle->brand ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $vehicle->type ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $vehicle->plate_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $vehicle->color ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $vehicle->driver ?? 'Not Assigned' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($vehicle->status ?? 'active')
                                    @case('active')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                                        @break
                                    @case('maintenance')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Maintenance</span>
                                        @break
                                    @case('replacement')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Replacement</span>
                                        @break
                                    @case('inactive')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Inactive</span>
                                        @break
                                    @default
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                                @if($vehicle->status === 'maintenance')
                                    <button class="text-amber-300 font-medium mr-3 cursor-not-allowed" disabled title="Vehicle already under maintenance">
                                        Maintenance
                                    </button>
                                @else
                                    <button onclick="openMaintenanceModal({{ $vehicle->id }})" class="text-amber-600 hover:text-amber-800 font-medium mr-3">
                                        Maintenance
                                    </button>
                                @endif
                                <button class="text-purple-600 hover:text-purple-800 font-medium">Replacement</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-600">No vehicles found</p>
                                    <p class="text-sm text-slate-500 mt-1">Get started by adding your first vehicle</p>
                                    <button onclick="window.location.href='{{ route('logistics.vehicles.create') }}'" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Add Vehicle
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">6</span> of <span class="font-medium">24</span> results
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

{{-- Maintenance Modal --}}
<div id="maintenanceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-slate-900">Schedule Maintenance</h3>
            <button onclick="closeMaintenanceModal()" class="text-slate-400 hover:text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        <form id="maintenanceForm" onsubmit="submitMaintenance(event)">
            @csrf
            <input type="hidden" id="vehicleId" name="vehicle_id">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Maintenance Reason</label>
                <textarea name="maintenance_reason" required rows="3"
                          class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                          placeholder="Describe the maintenance needed..."></textarea>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-slate-700 mb-2">Maintenance Date</label>
                <input type="date" name="maintenance_date" required
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeMaintenanceModal()" 
                        class="flex-1 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors">
                    Schedule Maintenance
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openMaintenanceModal(vehicleId) {
    document.getElementById('vehicleId').value = vehicleId;
    document.getElementById('maintenanceModal').classList.remove('hidden');
    document.getElementById('maintenanceModal').classList.add('flex');
}

function closeMaintenanceModal() {
    document.getElementById('maintenanceModal').classList.add('hidden');
    document.getElementById('maintenanceModal').classList.remove('flex');
    document.getElementById('maintenanceForm').reset();
}

function submitMaintenance(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Scheduling...';
    
    fetch('/admin/vehicles/maintenance', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            vehicle_id: formData.get('vehicle_id'),
            maintenance_reason: formData.get('maintenance_reason'),
            maintenance_date: formData.get('maintenance_date')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeMaintenanceModal();
            location.reload(); // Reload to show updated status
        } else {
            alert('Error: ' + (data.message || 'Failed to schedule maintenance'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error scheduling maintenance');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
}
</script>
@endsection