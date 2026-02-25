@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Vehicle Maintenance</h1>
        <p class="text-slate-500 mt-2">Track and manage vehicle maintenance activities</p>
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
                    @forelse($maintenances as $maintenance)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MTN{{ str_pad($maintenance->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#VHL{{ str_pad($maintenance->vehicle->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $maintenance->vehicle->brand ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $maintenance->vehicle->year ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $maintenance->vehicle->type ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $maintenance->vehicle->plate_number ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs">
                                <div class="truncate" title="{{ $maintenance->maintenance_reason }}">
                                    {{ $maintenance->maintenance_reason }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {!! $maintenance->status_badge !!}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($maintenance->status === 'pending')
                                    <button onclick="updateMaintenanceStatus({{ $maintenance->id }}, 'ongoing')" class="text-blue-600 hover:text-blue-800 font-medium">Start Maintenance</button>
                                @endif
                                @if($maintenance->status === 'ongoing')
                                    <button onclick="updateMaintenanceStatus({{ $maintenance->id }}, 'done')" class="text-green-600 hover:text-green-800 font-medium">Done</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-600">No maintenance records found</p>
                                    <p class="text-sm text-slate-500 mt-1">Schedule maintenance for vehicles to see records here</p>
                                    <button onclick="window.location.href='{{ route('logistics.vehicles') }}'" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        View Vehicles
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
                Showing <span class="font-medium">1</span> to <span class="font-medium">{{ $maintenances->count() }}</span> of <span class="font-medium">{{ $maintenances->count() }}</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<script>
function updateMaintenanceStatus(maintenanceId, newStatus) {
    if (confirm('Are you sure you want to update the maintenance status?')) {
        fetch(`/admin/vehicles/maintenance/${maintenanceId}/status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to update status'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating maintenance status');
        });
    }
}
</script>
@endsection