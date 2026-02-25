@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Return Details</h1>
                <p class="text-slate-500 mt-2">View detailed return information</p>
            </div>
            <a href="{{ route('warehouse.return') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M10 19l-7-7m0 0l6-6m-6 6h12a2 2 0 012 2v3a2 2 0 01-2 2H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Returns
            </a>
        </div>
    </div>

    @if($return)
        {{-- Return Details Card --}}
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">#RET{{ str_pad($return->id, 3, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-slate-500 mt-1">Return Details</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @switch($return->status)
                            @case('pending')
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                                @break
                            @case('approved')
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-700">Approved</span>
                                @break
                            @case('rejected')
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-red-100 text-red-700">Rejected</span>
                                @break
                            @case('completed')
                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-700">Completed</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Return Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Return Information</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Return Quantity</label>
                                <p class="text-slate-900">{{ $return->quantity ?? 0 }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Reason</label>
                                <p class="text-slate-900">{{ ucfirst($return->reason ?? 'N/A') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Return Date</label>
                                <p class="text-slate-900">{{ $return->created_at ? $return->created_at->format('M d, Y') : 'N/A' }}</p>
                            </div>
                            
                            @if($return->notes)
                            <div>
                                <label class="text-sm font-medium text-slate-600">Notes</label>
                                <p class="text-slate-900">{{ $return->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Item Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Item Information</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Item Name</label>
                                <p class="text-slate-900">{{ $return->inventory->inbound->purchaseOrder->request->item_name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Item Type</label>
                                <p class="text-slate-900">{{ ucfirst($return->inventory->inbound->purchaseOrder->request->type ?? 'N/A') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Unit Price</label>
                                <p class="text-slate-900">{{ number_format($return->inventory->inbound->purchaseOrder->price ?? 0, 2) }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Total Value</label>
                                <p class="text-slate-900">{{ number_format(($return->quantity ?? 0) * ($return->inventory->inbound->purchaseOrder->price ?? 0), 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Source Inventory</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Inventory ID</label>
                                <p class="text-slate-900">#INV{{ str_pad($return->inventory->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Current Quantity</label>
                                <p class="text-slate-900">{{ $return->inventory->quantity ?? 0 }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Location</label>
                                <p class="text-slate-900">{{ $return->inventory->inbound->storageLocation->name ?? ($return->inventory->inbound->location ?? 'N/A') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Status</label>
                                @php
                                    $invQty = $return->inventory->quantity ?? 0;
                                    if ($invQty == 0) {
                                        $invStatusClass = 'bg-red-100 text-red-700';
                                        $invStatusText = 'Out of Stock';
                                    } elseif ($invQty <= 20) {
                                        $invStatusClass = 'bg-amber-100 text-amber-700';
                                        $invStatusText = 'Low Stock';
                                    } else {
                                        $invStatusClass = 'bg-green-100 text-green-700';
                                        $invStatusText = 'In Stock';
                                    }
                                @endphp
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $invStatusClass }}">
                                    {{ $invStatusText }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Information --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Purchase Order Information --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Purchase Order Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">PO ID:</span>
                            <span class="text-slate-900">#PO{{ $return->inventory->inbound->purchaseOrder->id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Supplier:</span>
                            <span class="text-slate-900">
                                @if(is_object($return->inventory->inbound->purchaseOrder->supplier))
                                    {{ $return->inventory->inbound->purchaseOrder->supplier->company_name ?? 'N/A' }}
                                @else
                                    {{ $return->inventory->inbound->purchaseOrder->supplier ?? 'N/A' }}
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Original Quantity:</span>
                            <span class="text-slate-900">{{ $return->inventory->inbound->purchaseOrder->request->quantity ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Quantity Received:</span>
                            <span class="text-slate-900">{{ $return->inventory->inbound->quantity_received ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">PO Status:</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                Approved
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inbound Shipment Information --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Inbound Shipment Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Inbound ID:</span>
                            <span class="text-slate-900">#INB{{ str_pad($return->inventory->inbound->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Status:</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">
                                {{ ucfirst($return->inventory->inbound->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Received Date:</span>
                            <span class="text-slate-900">{{ $return->inventory->inbound->created_at ? $return->inventory->inbound->created_at->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Original Quantity:</span>
                            <span class="text-slate-900">{{ $return->inventory->inbound->quantity_received ?? 'N/A' }}</span>
                        </div>
                        
                        @if($return->inventory->inbound->notes)
                        <div>
                            <span class="text-sm font-medium text-slate-600">Inbound Notes:</span>
                            <p class="text-slate-900 mt-1">{{ $return->inventory->inbound->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Update Actions --}}
        <div class="mt-6 bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Status Management</h3>
                
                <div class="flex flex-wrap gap-3">
                    @if($return->status === 'pending')
                        <button onclick="updateReturnStatus({{ $return->id }}, 'approved')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Approve Return
                        </button>
                        
                        <button onclick="updateReturnStatus({{ $return->id }}, 'rejected')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Reject Return
                        </button>
                    @elseif($return->status === 'approved')
                        <button onclick="updateReturnStatus({{ $return->id }}, 'completed')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Mark as Completed
                        </button>
                        
                        <button onclick="updateReturnStatus({{ $return->id }}, 'rejected')" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Reject Return
                        </button>
                    @elseif($return->status === 'completed')
                        <div class="flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Return Completed
                        </div>
                    @else
                        <div class="flex items-center gap-2 px-4 py-2 bg-red-100 text-red-700 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Return Rejected
                        </div>
                    @endif
                </div>
            </div>
        </div>

    @else
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mx-auto mb-4">
                    <path d="M9 15L3 9m0 0l6-6m-6 6h12a2 2 0 012 2v3a2 2 0 01-2 2H6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="text-lg font-medium text-slate-600 mb-2">Return Not Found</h3>
                <p class="text-slate-500 mb-4">The return you're looking for doesn't exist or has been removed.</p>
                <a href="{{ route('warehouse.return') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Back to Returns
                </a>
            </div>
        </div>
    @endif
</div>

<script>
// Update return status function
async function updateReturnStatus(returnId, newStatus) {
    if (!confirm(`Are you sure you want to update the status to "${newStatus}"?`)) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/return/${returnId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: newStatus
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showNotification(`Status updated to "${newStatus}" successfully!`, 'success');
            // Reload the page to show updated status
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Failed to update status. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while updating status.', 'error');
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
