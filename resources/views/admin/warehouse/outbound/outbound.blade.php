@extends('components.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Outbound Inventory</h1>
        <p class="text-slate-500 mt-2">Track and manage outgoing inventory shipments</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-4">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Outbound</p>
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
                    <p class="text-sm font-medium text-slate-600">Pending</p>
                    <p class="text-2xl font-bold text-amber-600 mt-2">{{ $stats['pending'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">Awaiting shipment</p>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-amber-600">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Shipped</p>
                    <p class="text-2xl font-bold text-blue-600 mt-2">{{ $stats['shipped'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">In transit</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-blue-600">
                        <path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Delivered</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['delivered'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">Completed</p>
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
        <button onclick="openOutboundModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            New Outbound
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <form method="GET" action="{{ route('warehouse.outbound') }}" class="flex gap-4">
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('warehouse.outbound') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Clear
            </a>
        </form>
    </div>

    {{-- Outbound Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Outbound ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Ship Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($outbounds as $outbound)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#OUT{{ str_pad($outbound->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $outbound->inventory->inbound->purchaseOrder->request->item_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $outbound->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $outbound->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                {{ $outbound->ship_date ? $outbound->ship_date->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($outbound->status)
                                    @case('pending')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                                        @break
                                    @case('shipped')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">Shipped</span>
                                        @break
                                    @case('delivered')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Delivered</span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Cancelled</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.outbound.show', $outbound->id) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">View</a>
                                
                                @if($outbound->status === 'pending')
                                    <button onclick="updateOutboundStatus({{ $outbound->id }}, 'shipped')" class="text-blue-600 hover:text-blue-800 font-medium transition-colors mr-3">Shipped</button>
                                    <button onclick="updateOutboundStatus({{ $outbound->id }}, 'delivered')" class="text-green-600 hover:text-green-800 font-medium transition-colors mr-3">Delivered</button>
                                    <button onclick="updateOutboundStatus({{ $outbound->id }}, 'cancelled')" class="text-red-600 hover:text-red-800 font-medium transition-colors">Cancel</button>
                                @elseif($outbound->status === 'shipped')
                                    <button onclick="updateOutboundStatus({{ $outbound->id }}, 'delivered')" class="text-green-600 hover:text-green-800 font-medium transition-colors mr-3">Delivered</button>
                                    <button onclick="updateOutboundStatus({{ $outbound->id }}, 'cancelled')" class="text-red-600 hover:text-red-800 font-medium transition-colors">Cancel</button>
                                @elseif($outbound->status === 'delivered')
                                    <span class="text-green-600 font-medium">Completed</span>
                                @else
                                    <span class="text-slate-400 font-medium">Cancelled</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="text-lg font-medium text-slate-600">No outbound shipments found</p>
                                    <p class="text-sm text-slate-500 mt-1">Create your first outbound shipment to get started</p>
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
                Showing <span class="font-medium">{{ $outbounds->firstItem() }}</span> to <span class="font-medium">{{ $outbounds->lastItem() }}</span> of <span class="font-medium">{{ $outbounds->total() }}</span> results
            </div>
            <div class="flex gap-2">
                {{ $outbounds->links() }}
            </div>
        </div>
    </div>
</div>

{{-- New Outbound Modal --}}
<div id="outboundModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-slate-900">Create New Outbound Shipment</h2>
                <button onclick="closeOutboundModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-6 w-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>

            <form id="outboundForm" class="space-y-6">
                @csrf
                
                <!-- Select Inventory Item -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Select Inventory Item</label>
                    <select name="inventory_id" id="inventorySelect" required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Choose an inventory item...</option>
                        @foreach($availableInventory as $inventory)
                            @php
                                $itemName = $inventory->inbound->purchaseOrder->request->item_name ?? 'N/A';
                                $availableQty = $inventory->quantity ?? 0;
                                $location = $inventory->inbound->storageLocation ? $inventory->inbound->storageLocation->name : ($inventory->inbound->location ?? 'N/A');
                            @endphp
                            <option value="{{ $inventory->id }}" 
                                    data-item="{{ $itemName }}" 
                                    data-quantity="{{ $availableQty }}"
                                    data-location="{{ $location }}">
                                {{ $itemName }} (Available: {{ $availableQty }}) - {{ $location }}
                            </option>
                        @endforeach
                    </select>
                    @error('inventory_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Item Details Display -->
                <div id="itemDetails" class="hidden bg-slate-50 p-4 rounded-lg">
                    <h4 class="font-medium text-slate-900 mb-2">Item Details</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-slate-600">Item Name:</span>
                            <span id="itemName" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Available Quantity:</span>
                            <span id="availableQuantity" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Current Location:</span>
                            <span id="currentLocation" class="font-medium text-slate-900 ml-2"></span>
                        </div>
                        <div>
                            <span class="text-slate-600">Remaining After Outbound:</span>
                            <span id="remainingQuantity" class="font-medium text-amber-600 ml-2"></span>
                        </div>
                    </div>
                    <div class="mt-3 p-2 bg-amber-50 border border-amber-200 rounded">
                        <p class="text-xs text-amber-700">
                            <strong>Note:</strong> Outbound quantity will be automatically deducted from inventory.
                        </p>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Name</label>
                    <input type="text" name="name" 
                           placeholder="Enter shipment name"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Outbound Quantity -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Outbound Quantity</label>
                    <input type="number" name="quantity" id="outboundQuantity" min="1" value="1"
                           placeholder="Enter quantity to ship"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Destination Location -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Destination Location</label>
                    <input type="text" name="location" 
                           placeholder="Enter destination location"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ship Date -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Ship Date</label>
                    <input type="date" name="ship_date" 
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('ship_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeOutboundModal()" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Create Outbound Shipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openOutboundModal() {
    document.getElementById('outboundModal').classList.remove('hidden');
    document.getElementById('outboundModal').classList.add('flex');
    document.getElementById('outboundForm').reset();
    document.getElementById('itemDetails').classList.add('hidden');
}

function closeOutboundModal() {
    document.getElementById('outboundModal').classList.add('hidden');
    document.getElementById('outboundModal').classList.remove('flex');
    document.getElementById('itemDetails').classList.add('hidden');
}

// Show item details when an inventory item is selected
document.getElementById('inventorySelect').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const itemDetails = document.getElementById('itemDetails');
    const outboundQuantity = document.getElementById('outboundQuantity');
    
    if (this.value) {
        // Show item details
        document.getElementById('itemName').textContent = selectedOption.dataset.item;
        document.getElementById('availableQuantity').textContent = selectedOption.dataset.quantity;
        document.getElementById('currentLocation').textContent = selectedOption.dataset.location;
        
        // Set max quantity for outbound
        outboundQuantity.max = selectedOption.dataset.quantity;
        
        // Calculate remaining quantity
        updateRemainingQuantity();
        
        itemDetails.classList.remove('hidden');
    } else {
        itemDetails.classList.add('hidden');
        outboundQuantity.max = '';
    }
});

// Update remaining quantity when outbound quantity changes
document.getElementById('outboundQuantity').addEventListener('input', updateRemainingQuantity);

function updateRemainingQuantity() {
    const availableQty = parseInt(document.getElementById('availableQuantity').textContent) || 0;
    const outboundQty = parseInt(document.getElementById('outboundQuantity').value) || 0;
    const remainingQty = availableQty - outboundQty;
    
    const remainingElement = document.getElementById('remainingQuantity');
    remainingElement.textContent = remainingQty;
    
    // Update color based on remaining quantity
    if (remainingQty < 0) {
        remainingElement.className = 'font-medium text-red-600 ml-2';
    } else if (remainingQty === 0) {
        remainingElement.className = 'font-medium text-amber-600 ml-2';
    } else {
        remainingElement.className = 'font-medium text-green-600 ml-2';
    }
}

// Handle form submission
document.getElementById('outboundForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Creating...';
    
    try {
        const response = await fetch('{{ route("admin.outbound.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                inventory_id: formData.get('inventory_id'),
                name: formData.get('name'),
                quantity: formData.get('quantity'),
                location: formData.get('location'),
                ship_date: formData.get('ship_date')
            })
        });
        
        // Check if response is OK
        if (!response.ok) {
            // Get response text to see what the server actually returned
            const responseText = await response.text();
            console.error('Server returned non-JSON response:', responseText);
            showNotification('Server error: ' + response.statusText, 'error');
            return;
        }
        
        // Try to parse JSON
        let data;
        try {
            data = await response.json();
        } catch (parseError) {
            console.error('JSON parsing error:', parseError);
            const responseText = await response.text();
            console.error('Response text:', responseText);
            showNotification('Invalid server response', 'error');
            return;
        }
        
        if (data.success) {
            // Show success message
            showNotification('Outbound shipment created successfully!', 'success');
            closeOutboundModal();
            
            // Reload the page to show the new outbound
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Failed to create outbound shipment', 'error');
        }
    } catch (error) {
        console.error('Fetch error:', error);
        showNotification('An error occurred. Please try again.', 'error');
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    }
});

// Show notification function
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

// Close modal when clicking outside
document.getElementById('outboundModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeOutboundModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeOutboundModal();
    }
});

// Update outbound status function
async function updateOutboundStatus(outboundId, newStatus) {
    if (!confirm(`Are you sure you want to update the status to "${newStatus}"?`)) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/outbound/${outboundId}/update-status`, {
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
</script>
@endsection