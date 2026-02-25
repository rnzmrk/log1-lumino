@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center gap-4 mb-4">
            <a href="{{ route('assets.list') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Assets
            </a>
        </div>
        <h1 class="text-3xl font-bold text-slate-900">Asset Details</h1>
        <p class="text-slate-500 mt-2">View and manage asset information</p>
    </div>

    {{-- Asset Information --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-slate-900">Asset #AST{{ str_pad($asset->id, 3, '0', STR_PAD_LEFT) }}</h2>
                <div class="flex items-center gap-3">
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $asset->getStatusBadgeClass() }}">
                        {{ $asset->getStatusLabel() }}
                    </span>
                    @if($asset->status === 'active')
                        <button onclick="updateAssetStatus('maintenance')" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Set to Maintenance
                        </button>
                        <button onclick="updateAssetStatus('replacement')" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Set to Replacement
                        </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Asset Details --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-slate-900 mb-4">Asset Information</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Asset ID</p>
                            <p class="font-medium text-slate-900">#AST{{ str_pad($asset->id, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Quantity</p>
                            <p class="font-medium text-slate-900">{{ $asset->quantity }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Duration</p>
                            <p class="font-medium text-slate-900">{{ $asset->duration }} years</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Department</p>
                            <p class="font-medium text-slate-900">{{ $asset->department ?? 'Not Assigned' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Status</p>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $asset->getStatusBadgeClass() }}">
                                {{ $asset->getStatusLabel() }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Created Date</p>
                            <p class="font-medium text-slate-900">{{ $asset->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Item Details --}}
                <div class="space-y-4">
                    <h3 class="text-lg font-medium text-slate-900 mb-4">Item Information</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-slate-500">Item Name</p>
                            <p class="font-medium text-slate-900">{{ $asset->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Type</p>
                            <p class="font-medium text-slate-900">{{ ucfirst($asset->item_type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Location</p>
                            <p class="font-medium text-slate-900">{{ $asset->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500">Inventory ID</p>
                            <p class="font-medium text-slate-900">#INV{{ str_pad($asset->inventory_id, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="mt-8 pt-6 border-t border-slate-200">
                <h3 class="text-lg font-medium text-slate-900 mb-4">Activity Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Asset Created</p>
                            <p class="text-sm text-slate-500">{{ $asset->created_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                    @if($asset->updated_at != $asset->created_at)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                        <div>
                            <p class="text-sm font-medium text-slate-900">Asset Updated</p>
                            <p class="text-sm text-slate-500">{{ $asset->updated_at->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateAssetStatus(newStatus) {
        if (confirm(`Are you sure you want to set this asset to ${newStatus}?`)) {
            fetch(`/admin/assets/{{ $asset->id }}/status`, {
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
                    showNotification(data.message, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification(data.message || 'Failed to update status', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            });
        }
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>
@endsection
