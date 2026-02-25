@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Inventory Management</h1>
        <p class="text-slate-500 mt-2">Track and manage warehouse inventory items</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Stock</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $stats['total'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">All items</p>
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
                    <p class="text-sm font-medium text-slate-600">In Stock</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $stats['in_stock'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">Available items</p>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-green-600">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Low Stock</p>
                    <p class="text-2xl font-bold text-amber-600 mt-2">{{ $stats['low_stock'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">Need reorder</p>
                </div>
                <div class="bg-amber-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-amber-600">
                        <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Out of Stock</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">{{ $stats['out_of_stock'] }}</p>
                    <p class="text-sm text-slate-500 mt-1">Items unavailable</p>
                </div>
                <div class="bg-red-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6 text-red-600">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3">
        <button class="px-4 py-2 bg-blue-700 border border-slate-200 text-white rounded-lg flex items-center gap-2" onclick="openRequestModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                <circle cx="17" cy="18" r="1.25" fill="currentColor" />
            </svg>
            Request
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            History
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4">
        <form method="GET" action="{{ route('warehouse.inventory') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by item name..." 
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       onkeyup="if(this.value.length >= 2 || this.value.length === 0) { this.form.submit(); }">
            </div>
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('warehouse.inventory') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Clear
            </a>
        </form>
    </div>

    {{-- Inventory Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-32">Inventory ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-32">PO ID</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-32">Item Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-24">Quantity</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-28">Price</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-28">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-36">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-32">Supplier</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-28">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-28">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-700 w-20">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($inventories as $inventory)
                    @php
                        // Safe data extraction with null checks
                        $quantity = 0;
                        $itemName = 'N/A';
                        $poId = 'N/A';
                        $itemType = 'N/A';
                        $location = 'N/A';
                        $supplier = 'N/A';
                        $date = 'N/A';
                        $price = 'N/A';
                        
                        if ($inventory && $inventory->inbound) {
                            $quantity = $inventory->quantity ?? 0;
                            $date = $inventory->inbound->created_at ? $inventory->inbound->created_at->format('M d, Y') : 'N/A';
                            
                            if ($inventory->inbound->purchaseOrder) {
                                $poId = $inventory->inbound->purchaseOrder->id;
                                $price = number_format($inventory->inbound->purchaseOrder->price ?? 0, 2);
                                
                                // Handle both cases: supplier as object (relationship) or string (direct field)
                                if (is_object($inventory->inbound->purchaseOrder->supplier)) {
                                    $supplier = $inventory->inbound->purchaseOrder->supplier->company_name ?? 'N/A';
                                } else {
                                    $supplier = $inventory->inbound->purchaseOrder->supplier ?? 'N/A';
                                }
                                
                                if ($inventory->inbound->purchaseOrder->request) {
                                    $itemName = $inventory->inbound->purchaseOrder->request->item_name ?? 'N/A';
                                    $itemType = $inventory->inbound->purchaseOrder->request->type ?? 'N/A';
                                }
                            }
                            
                            $location = $inventory->inbound->storageLocation ? 
                                $inventory->inbound->storageLocation->name : 
                                ($inventory->inbound->location ?? 'N/A');
                        }
                        
                        // Use calculated status from controller or calculate fallback
                        $status = $inventory->calculated_status ?? 'in_stock';
                        
                        // Determine status display
                        if ($status == 'out_of_stock' || $quantity == 0) {
                            $statusClass = 'bg-red-100 text-red-700';
                            $statusText = 'Out of Stock';
                        } elseif ($status == 'low_stock' || $quantity <= 20) {
                            $statusClass = 'bg-amber-100 text-amber-700';
                            $statusText = 'Low Stock';
                        } else {
                            $statusClass = 'bg-green-100 text-green-700';
                            $statusText = 'In Stock';
                        }
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 whitespace-nowrap text-sm font-medium text-slate-900">#INV{{ str_pad($inventory->id ?? 0, 3, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">#PO{{ $poId }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">{{ $itemName }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">{{ $quantity }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">{{ $price }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">{{ ucfirst($itemType) }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">{{ $location }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-900">{{ $supplier }}</td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-600">{{ $date }}</td>
                        <td class="px-6 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-3 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.inventory.show', $inventory->id ?? 0) }}" class="text-blue-600 hover:text-blue-800 font-medium transition-colors">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @if(request('search') || request('status'))
                                    <p class="text-lg font-medium text-slate-600">No inventory items found</p>
                                    <p class="text-sm text-slate-500 mt-1">Try adjusting your search or filter criteria</p>
                                @else
                                    <p class="text-lg font-medium text-slate-600">No inventory items found</p>
                                    <p class="text-sm text-slate-500 mt-1">Move inbound shipments to inventory to get started</p>
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
            Showing <span class="font-medium">{{ $inventories->firstItem() }}</span> to <span class="font-medium">{{ $inventories->lastItem() }}</span> of <span class="font-medium">{{ $inventories->total() }}</span> results
        </div>
        <div class="flex gap-2">
            {{ $inventories->links() }}
        </div>
    </div>
</div>

{{-- Request Modal --}}
<div id="requestModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-slate-900">Request Item</h2>
                <button onclick="closeRequestModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <form id="requestForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Item Name</label>
                    <input type="text" name="item_name" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter item name" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter quantity" min="1" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                    <select name="type" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Select type</option>
                        <option value="asset">Asset</option>
                        <option value="supply">Supply</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Enter description"></textarea>
                </div>
                
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Submit Request
                    </button>
                    <button type="button" onclick="closeRequestModal()" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRequestModal() {
        document.getElementById('requestModal').classList.remove('hidden');
        document.getElementById('requestForm').reset();
    }
    
    function closeRequestModal() {
        document.getElementById('requestModal').classList.add('hidden');
        document.getElementById('requestForm').reset();
    }
    
    // Handle form submission
    document.getElementById('requestForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        try {
            const response = await fetch('{{ route("admin.requests.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    item_name: formData.get('item_name'),
                    quantity: formData.get('quantity'),
                    type: formData.get('type'),
                    description: formData.get('description')
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Show success message
                showNotification('Request submitted successfully!', 'success');
                closeRequestModal();
                
                // Optionally refresh the page or update the UI
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification('Failed to submit request. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
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
    document.getElementById('requestModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRequestModal();
        }
    });
</script>
@endsection