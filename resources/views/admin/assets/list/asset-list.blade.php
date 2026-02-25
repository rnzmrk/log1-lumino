@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Asset List</h1>
        <p class="text-slate-500 mt-2">Manage and track all company assets</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" onclick="openAddAssetModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Add Asset
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <form method="GET" action="{{ route('assets.list') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by asset ID or item name..." 
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       onkeyup="if(this.value.length >= 2 || this.value.length === 0) { this.form.submit(); }">
            </div>
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="replacement" {{ request('status') == 'replacement' ? 'selected' : '' }}>Replacement</option>
            </select>
            <select name="type" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Types</option>
                <option value="laptop" {{ request('type') == 'laptop' ? 'selected' : '' }}>Laptop</option>
                <option value="monitor" {{ request('type') == 'monitor' ? 'selected' : '' }}>Monitor</option>
                <option value="phone" {{ request('type') == 'phone' ? 'selected' : '' }}>Phone</option>
                <option value="printer" {{ request('type') == 'printer' ? 'selected' : '' }}>Printer</option>
                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <select name="location" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="">All Locations</option>
                <option value="Office A" {{ request('location') == 'Office A' ? 'selected' : '' }}>Office A</option>
                <option value="Office B" {{ request('location') == 'Office B' ? 'selected' : '' }}>Office B</option>
                <option value="Warehouse" {{ request('location') == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                <option value="Remote" {{ request('location') == 'Remote' ? 'selected' : '' }}>Remote</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('assets.list') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Clear
            </a>
        </form>
    </div>

    {{-- Asset List Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Asset ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($assets as $asset)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AST{{ str_pad($asset->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $asset->item_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $asset->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ ucfirst($asset->item_type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $asset->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $asset->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($asset->status)
                                    @case('active')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                                        @break
                                    @case('maintenance')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Maintenance</span>
                                        @break
                                    @case('replacement')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Replacement</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.assets.show', $asset->id) }}" class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</a>
                                @if($asset->status === 'maintenance')
                                    <a href="{{ route('admin.maintenance.index') }}?search={{ $asset->id }}" class="text-amber-600 hover:text-amber-800 font-medium mr-3">View Maintenance</a>
                                @endif
                                @if($asset->status === 'active')
                                    <button onclick="openMaintenanceModal({{ $asset->id }})" class="text-amber-600 hover:text-amber-800 font-medium mr-3">Maintenance</button>
                                    <button onclick="updateAssetStatus({{ $asset->id }}, 'replacement')" class="text-purple-600 hover:text-purple-800 font-medium">Replacement</button>
                                @else
                                    <button disabled class="text-slate-400 font-medium mr-3 cursor-not-allowed">Maintenance</button>
                                    <button disabled class="text-slate-400 font-medium cursor-not-allowed">Replacement</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke="join="round"/>
                                    </svg>
                                    @if(request('search') || request('status') || request('type') || request('location'))
                                        <p class="text-lg font-medium text-slate-600">No assets found</p>
                                        <p class="text-sm text-slate-500 mt-1">Try adjusting your search or filter criteria</p>
                                    @else
                                        <p class="text-lg font-medium text-slate-600">No assets found</p>
                                        <p class="text-sm text-slate-500 mt-1">Add your first asset to get started</p>
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
                Showing <span class="font-medium">{{ $assets->firstItem() }}</span> to <span class="font-medium">{{ $assets->lastItem() }}</span> of <span class="font-medium">{{ $assets->total() }}</span> results
            </div>
            <div class="flex gap-2">
                {{ $assets->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Asset Modal -->
<div id="addAssetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-slate-900">Add Asset</h2>
                <button onclick="closeAddAssetModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <form id="addAssetForm" onsubmit="addAsset(event)">
                @csrf
                <div class="space-y-4">
                    <!-- Inventory Selection -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Select Inventory Item</label>
                        <select id="inventoryId" name="inventory_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Choose an inventory item...</option>
                        </select>
                    </div>

                    <!-- Selected Item Info -->
                    <div id="selectedItemInfo" class="hidden bg-blue-50 p-3 rounded-lg">
                        <p class="text-sm font-medium text-blue-900">Selected Item:</p>
                        <div id="itemDetails" class="text-sm text-blue-700 mt-1"></div>
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Quantity to Add as Asset</label>
                        <input type="number" id="assetQuantity" name="quantity" min="1" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter quantity">
                        <p class="text-xs text-slate-500 mt-1">Available quantity will be shown after selection</p>
                    </div>
                    
                    <!-- Department -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Department</label>
                        <input type="text" id="department" name="department" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter department (optional)">
                    </div>
                    
                    
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Add Asset
                    </button>
                    <button type="button" onclick="closeAddAssetModal()" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
<div id="maintenanceModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-slate-900">Set Asset to Maintenance</h2>
                <button onclick="closeMaintenanceModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <form id="maintenanceForm" onsubmit="submitMaintenance(event)">
                @csrf
                <input type="hidden" id="maintenanceAssetId" name="asset_id">
                <div class="space-y-4">
                    <!-- Maintenance Reason -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Maintenance Reason</label>
                        <textarea id="maintenanceReason" name="reason" required rows="3"
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter reason for maintenance..."></textarea>
                    </div>
                    
                    <!-- Maintenance Date -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Maintenance Date</label>
                        <input type="date" id="maintenanceDate" name="maintenance_date" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <!-- Expected Return Date -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Expected Return Date</label>
                        <input type="date" id="returnDate" name="expected_return_date" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-amber-600 text-white py-2 px-4 rounded-lg hover:bg-amber-700 transition-colors">
                        Set to Maintenance
                    </button>
                    <button type="button" onclick="closeMaintenanceModal()" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let inventoryData = [];

    function openAddAssetModal() {
        document.getElementById('addAssetModal').classList.remove('hidden');
        loadInventoryItems();
    }
    
    function closeAddAssetModal() {
        document.getElementById('addAssetModal').classList.add('hidden');
        document.getElementById('addAssetForm').reset();
        document.getElementById('selectedItemInfo').classList.add('hidden');
    }
    
    function loadInventoryItems() {
        fetch('/admin/inventory/asset-items')
            .then(response => response.json())
            .then(data => {
                inventoryData = data.items || [];
                const select = document.getElementById('inventoryId');
                select.innerHTML = '<option value="">Choose an inventory item...</option>';
                
                inventoryData.forEach(item => {
                    if (item.quantity > 0) {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = `${item.item_name} (Available: ${item.quantity})`;
                        select.appendChild(option);
                    }
                });
                
                select.addEventListener('change', showItemDetails);
            })
            .catch(error => {
                console.error('Error loading inventory:', error);
                showNotification('Failed to load inventory items', 'error');
            });
    }
    
    function showItemDetails() {
        const select = document.getElementById('inventoryId');
        const selectedId = select.value;
        const infoDiv = document.getElementById('selectedItemInfo');
        const detailsDiv = document.getElementById('itemDetails');
        const quantityInput = document.getElementById('assetQuantity');
        
        if (selectedId) {
            const item = inventoryData.find(i => i.id == selectedId);
            if (item) {
                detailsDiv.innerHTML = `
                    <strong>${item.item_name}</strong><br>
                    Type: ${item.type}<br>
                    Available Quantity: ${item.quantity}<br>
                    Location: ${item.location}
                `;
                infoDiv.classList.remove('hidden');
                quantityInput.max = item.quantity;
                quantityInput.placeholder = `Max: ${item.quantity}`;
            }
        } else {
            infoDiv.classList.add('hidden');
            quantityInput.max = '';
            quantityInput.placeholder = 'Enter quantity';
        }
    }
    
    function addAsset(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const inventoryId = formData.get('inventory_id');
        const quantity = parseInt(formData.get('quantity'));
        
        // Validate quantity
        const item = inventoryData.find(i => i.id == inventoryId);
        if (item && quantity > item.quantity) {
            showNotification('Quantity cannot exceed available inventory', 'error');
            return;
        }
        
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';
        
        fetch('/admin/assets/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                inventory_id: formData.get('inventory_id'),
                quantity: quantity,
                department: formData.get('department')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Asset added successfully!', 'success');
                closeAddAssetModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Failed to add asset', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
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
    
    function openMaintenanceModal(assetId) {
        document.getElementById('maintenanceAssetId').value = assetId;
        document.getElementById('maintenanceDate').value = new Date().toISOString().split('T')[0];
        document.getElementById('maintenanceModal').classList.remove('hidden');
    }
    
    function closeMaintenanceModal() {
        document.getElementById('maintenanceModal').classList.add('hidden');
        document.getElementById('maintenanceForm').reset();
    }
    
    function submitMaintenance(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Processing...';
        
        fetch('/admin/assets/maintenance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                asset_id: formData.get('asset_id'),
                reason: formData.get('reason'),
                maintenance_date: formData.get('maintenance_date'),
                expected_return_date: formData.get('expected_return_date')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeMaintenanceModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Failed to set maintenance', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    }
    
    function updateAssetStatus(assetId, newStatus) {
        if (confirm(`Are you sure you want to set this asset to ${newStatus}?`)) {
            fetch(`/admin/assets/${assetId}/status`, {
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
</script>
@endsection