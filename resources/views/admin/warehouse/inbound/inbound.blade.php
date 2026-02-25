@extends('components.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['total'] }}</p>
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
                    <p class="text-2xl font-bold text-amber-600 mt-2">{{ $stats['in_transit'] }}</p>
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
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $stats['arrived'] }}</p>
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
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['received'] }}</p>
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
        <button onclick="openInboundModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            New Inbound
        </button>
        
        {{-- Filter Button --}}
        <div class="relative">
            <button onclick="toggleFilterDropdown()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Filter
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M19 9l-7 7-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            {{-- Filter Dropdown --}}
            <div id="filterDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg border border-slate-200 shadow-lg z-10 hidden">
                <div class="p-3">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Filter by Status</label>
                    <select id="statusFilter" onchange="filterByStatus()" class="w-full px-3 py-2 border border-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="in_transit">In Transit</option>
                        <option value="arrived">Arrived</option>
                        <option value="received">Received</option>
                    </select>
                </div>
            </div>
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
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-32">Quantity Received</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-40">Location</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 min-w-[300px]">Description</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-40">Supplier</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-36">Status Instance</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700 w-32">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($inbounds as $inbound)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#INB{{ str_pad($inbound->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">#PO{{ $inbound->purchaseOrder->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $inbound->purchaseOrder->request->item_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $inbound->purchaseOrder->request->quantity ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $inbound->quantity_received }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $inbound->location }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $inbound->purchaseOrder->request->description ?? 'No description available' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $inbound->purchaseOrder->supplier }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($inbound->status)
                                @case('pending')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Pending</span>
                                    @break
                                @case('in_transit')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">In Transit</span>
                                    @break
                                @case('arrived')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Arrived</span>
                                    @break
                                @case('received')
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">Received</span>
                                    @break
                                @default
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">{{ ucfirst($inbound->status) }}</span>
                            @endswitch
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.inbound.show', $inbound->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</a>
                            @if($inbound->status !== 'received')
                                <button onclick="updateStatus({{ $inbound->id }}, 'received')" class="text-green-600 hover:text-green-800 font-medium transition-colors">Receive</button>
                            @else
                                <button class="text-slate-400 font-medium cursor-not-allowed" disabled>Receive</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p class="text-lg font-medium text-slate-600">No inbound shipments found</p>
                                <p class="text-sm text-slate-500 mt-1">Create your first inbound shipment to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">{{ $inbounds->firstItem() }}</span> to <span class="font-medium">{{ $inbounds->lastItem() }}</span> of <span class="font-medium">{{ $inbounds->total() }}</span> results
            </div>
            <div class="flex gap-2">
                {{ $inbounds->links() }}
            </div>
        </div>
    </div>
</div>

{{-- New Inbound Modal --}}
<div id="inboundModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-slate-900">Create New Inbound Shipment</h2>
                <button onclick="closeInboundModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('admin.inbound.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Select Purchase Order -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Purchase Order</label>
                    <select name="purchase_order_id" id="purchaseOrderSelect" required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose an approved purchase order...</option>
                        @foreach($approvedPOs as $po)
                            <option value="{{ $po->id }}" 
                                    data-supplier="{{ $po->supplier }}" 
                                    data-price="{{ $po->price }}" 
                                    data-quantity="{{ $po->request ? $po->request->quantity : 'N/A' }}" 
                                    data-item="{{ $po->request ? $po->request->item_name : 'N/A' }}">
                                #PO{{ $po->id }} - {{ $po->supplier }} ({{ $po->price }})
                            </option>
                        @endforeach
                    </select>
                    @error('purchase_order_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PO Details Display -->
                <div id="poDetails" class="hidden bg-slate-50 p-4 rounded-lg">
                    <h4 class="font-medium text-slate-900 mb-2">Purchase Order Details</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-600">PO ID:</span>
                            <span id="poId" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Supplier:</span>
                            <span id="poSupplier" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Item Name:</span>
                            <span id="poItem" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Quantity:</span>
                            <span id="poQuantity" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Price:</span>
                            <span id="poPrice" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Expected Delivery:</span>
                            <span id="poDelivery" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                    </div>
                </div>

                <!-- Storage Location -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Storage Location</label>
                    <input type="text" name="location" required
                           placeholder="e.g., Warehouse A-1, Section B, Rack 3"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity Received -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Quantity Received</label>
                    <input type="number" name="quantity_received" required min="1" value="1"
                           placeholder="Enter quantity"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('quantity_received')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                    <textarea name="notes" rows="4" placeholder="Additional notes about the inbound shipment..."
                              class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeInboundModal()" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Inbound Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openInboundModal() {
    document.getElementById('inboundModal').classList.remove('hidden');
    document.getElementById('inboundModal').classList.add('flex');
}

function closeInboundModal() {
    document.getElementById('inboundModal').classList.add('hidden');
    document.getElementById('inboundModal').classList.remove('flex');
    document.getElementById('poDetails').classList.add('hidden');
}

// Show PO details when a PO is selected
document.getElementById('purchaseOrderSelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const poDetails = document.getElementById('poDetails');
    
    if (this.value) {
        // Show PO details
        document.getElementById('poId').textContent = '#PO' + this.value;
        document.getElementById('poSupplier').textContent = selectedOption.dataset.supplier;
        document.getElementById('poItem').textContent = selectedOption.dataset.item;
        document.getElementById('poQuantity').textContent = selectedOption.dataset.quantity;
        document.getElementById('poPrice').textContent = selectedOption.dataset.price;
        document.getElementById('poDelivery').textContent = new Date().toLocaleDateString();
        
        poDetails.classList.remove('hidden');
    } else {
        poDetails.classList.add('hidden');
    }
});

// Close modal when clicking outside
document.getElementById('inboundModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInboundModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeInboundModal();
    }
});

// Filter dropdown functionality
function toggleFilterDropdown() {
    const dropdown = document.getElementById('filterDropdown');
    dropdown.classList.toggle('hidden');
}

// Close filter dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('filterDropdown');
    const filterButton = e.target.closest('button[onclick="toggleFilterDropdown()"]');
    
    if (!filterButton && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

// Filter by status
function filterByStatus() {
    const status = document.getElementById('statusFilter').value;
    const currentUrl = new URL(window.location);
    
    if (status) {
        currentUrl.searchParams.set('status', status);
    } else {
        currentUrl.searchParams.delete('status');
    }
    
    // Reset to page 1 when filtering
    currentUrl.searchParams.delete('page');
    
    window.location.href = currentUrl.toString();
}

// Set the initial filter value based on URL parameter
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const statusFilter = document.getElementById('statusFilter');
    
    if (urlParams.has('status') && statusFilter) {
        statusFilter.value = urlParams.get('status');
    }
});

// Update status function
function updateStatus(inboundId, newStatus) {
    if (!confirm('Are you sure you want to update the status?')) {
        return;
    }
    
    fetch(`/admin/inbound/${inboundId}/update-status`, {
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
            // Reload the page to show updated status
            window.location.reload();
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating status');
    });
}
</script>
@endsection