@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Asset Maintenance Records</h1>
        <p class="text-slate-500 mt-2">View all asset maintenance history and current status</p>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <form method="GET" action="{{ route('admin.maintenance.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by asset ID or maintenance reason..." 
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       onkeyup="if(this.value.length >= 2 || this.value.length === 0) { this.form.submit(); }">
            </div>
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('admin.maintenance.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Clear
            </a>
        </form>
    </div>

    {{-- Maintenance Records Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Maintenance ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Asset ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Asset Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Maintenance Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Created Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($maintenances as $maintenance)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#MNT{{ str_pad($maintenance->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#AST{{ str_pad($maintenance->asset->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $maintenance->asset->item_name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <div class="max-w-xs truncate" title="{{ $maintenance->maintenance_reason }}">
                                    {{ $maintenance->maintenance_reason }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $maintenance->maintenance_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($maintenance->status)
                                    @case('pending')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                        @break
                                    @case('ongoing')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Ongoing</span>
                                        @break
                                    @case('done')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Done</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $maintenance->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($maintenance->status === 'pending')
                                    <button onclick="updateMaintenanceStatus({{ $maintenance->id }}, 'ongoing')" class="text-blue-600 hover:text-blue-800 font-medium mr-3">Ongoing</button>
                                    <button onclick="updateMaintenanceStatus({{ $maintenance->id }}, 'done')" class="text-green-600 hover:text-green-800 font-medium">Done</button>
                                @elseif($maintenance->status === 'ongoing')
                                    <button onclick="updateMaintenanceStatus({{ $maintenance->id }}, 'done')" class="text-green-600 hover:text-green-800 font-medium">Done</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    @if(request('search') || request('status'))
                                        <p class="text-lg font-medium text-slate-600">No maintenance records found</p>
                                        <p class="text-sm text-slate-500 mt-1">Try adjusting your search or filter criteria</p>
                                    @else
                                        <p class="text-lg font-medium text-slate-600">No maintenance records found</p>
                                        <p class="text-sm text-slate-500 mt-1">Set assets to maintenance to see records here</p>
                                    @endif
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
                Showing <span class="font-medium">{{ $maintenances->firstItem() }}</span> to <span class="font-medium">{{ $maintenances->lastItem() }}</span> of <span class="font-medium">{{ $maintenances->total() }}</span> results
            </div>
            <div class="flex gap-2">
                {{ $maintenances->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function updateMaintenanceStatus(maintenanceId, newStatus) {
        if (!confirm('Are you sure you want to update the maintenance status to ' + newStatus + '?')) {
            return;
        }

        fetch('/admin/assets/maintenance/' + maintenanceId + '/status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the status');
        });
    }
</script>
@endsection