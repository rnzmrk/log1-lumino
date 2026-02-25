@php
    $statusColors = [
        'pending' => 'bg-amber-100 text-amber-700',
        'approved' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        'completed' => 'bg-blue-100 text-blue-700'
    ];
    
    // Calculate status counts
    $totalRequests = isset($requests) ? $requests->count() : 0;
    $pendingCount = isset($requests) ? $requests->where('status', 'pending')->count() : 0;
    $approvedCount = isset($requests) ? $requests->where('status', 'approved')->count() : 0;
    $rejectedCount = isset($requests) ? $requests->where('status', 'rejected')->count() : 0;
@endphp

@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Supply Requests</h1>
        <p class="text-slate-500 mt-2">Manage and approve supply requests only</p>
    </div>

    {{-- Status Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 px-4">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Requests</p>
                    <p class="text-2xl font-bold text-slate-900 mt-2">{{ $totalRequests }}</p>
                    <p class="text-sm text-slate-500 mt-1">All supply requests</p>
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
                    <p class="text-2xl font-bold text-amber-600 mt-2">{{ $pendingCount }}</p>
                    <p class="text-sm text-slate-500 mt-1">Awaiting approval</p>
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
                    <p class="text-sm font-medium text-slate-600">Approved</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">{{ $approvedCount }}</p>
                    <p class="text-sm text-slate-500 mt-1">Approved requests</p>
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
                    <p class="text-sm font-medium text-slate-600">Rejected</p>
                    <p class="text-2xl font-bold text-red-600 mt-2">{{ $rejectedCount }}</p>
                    <p class="text-sm text-slate-500 mt-1">Rejected requests</p>
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
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            History
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by request ID or item name..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Pending</option>
                <option>Approved</option>
                <option>Rejected</option>
            </select>
            <input type="date" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
    </div>

    {{-- Request Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Request ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @if(isset($requests) && $requests->count() > 0)
                        @foreach($requests as $request)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#REQ00{{ sprintf('%03d', $request->id) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $request->item_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $request->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ ucfirst($request->type) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 max-w-xs truncate">{{ $request->description ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $request->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $statusColors[$request->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewRequestDetails({{ $request->id }}, '{{ $request->item_name }}', {{ $request->quantity }}, '{{ $request->type }}', '{{ $request->description ?? 'N/A' }}', '{{ $request->created_at->format('Y-m-d') }}', '{{ $request->status }}')" class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                                @if($request->status === 'pending')
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'approved')" class="text-green-600 hover:text-green-800 font-medium mr-3">Approve</button>
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'rejected')" class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-sm text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-12 h-12 text-slate-300 mb-4">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <p class="font-medium">No supply requests found</p>
                                    <p class="text-slate-400 mt-1">All supply requests will appear here</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if(isset($requests) && $requests->count() > 0)
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">{{ $requests->count() }}</span> of <span class="font-medium">{{ $requests->count() }}</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white" disabled>Next</button>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- View Request Modal --}}
<div id="viewRequestModal" class="fixed inset-0 bg-slate-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-slate-900">Request Details</h2>
                <button onclick="closeViewModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Request ID</label>
                        <p id="viewRequestId" class="text-sm text-slate-900 font-medium">#REQ001</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <span id="viewRequestStatus" class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Item Name</label>
                        <p id="viewItemName" class="text-sm text-slate-900">Office Paper A4</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Quantity</label>
                        <p id="viewQuantity" class="text-sm text-slate-900">500</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                        <p id="viewType" class="text-sm text-slate-900">Supply</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Request Date</label>
                        <p id="viewDate" class="text-sm text-slate-900">2024-01-15</p>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <p id="viewDescription" class="text-sm text-slate-900 bg-slate-50 p-3 rounded-lg">Standard A4 office paper, 80gsm, white</p>
                </div>
                
                <div class="flex gap-3 pt-4 border-t border-slate-200" id="viewModalActions">
                    <!-- Action buttons will be inserted here dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function viewRequestDetails(id, itemName, quantity, type, description, date, status) {
        // Set modal content
        document.getElementById('viewRequestId').textContent = `#REQ00${String(id).padStart(3, '0')}`;
        document.getElementById('viewItemName').textContent = itemName;
        document.getElementById('viewQuantity').textContent = quantity;
        document.getElementById('viewType').textContent = type.charAt(0).toUpperCase() + type.slice(1);
        document.getElementById('viewDate').textContent = date;
        document.getElementById('viewDescription').textContent = description;
        
        // Set status with appropriate color
        const statusElement = document.getElementById('viewRequestStatus');
        const statusColors = {
            'pending': 'bg-amber-100 text-amber-700',
            'approved': 'bg-green-100 text-green-700',
            'rejected' : 'bg-red-100 text-red-700',
            'completed' : 'bg-blue-100 text-blue-700'
        };
        
        statusElement.className = `inline-flex px-2.5 py-1 text-xs font-medium rounded-full ${statusColors[status] || 'bg-gray-100 text-gray-700'}`;
        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        
        // Set action buttons
        const actionsContainer = document.getElementById('viewModalActions');
        if (status === 'pending') {
            actionsContainer.innerHTML = `
                <button onclick="updateRequestStatus(${id}, 'approved'); closeViewModal();" class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors">
                    Approve Request
                </button>
                <button onclick="updateRequestStatus(${id}, 'rejected'); closeViewModal();" class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors">
                    Reject Request
                </button>
                <button onclick="closeViewModal()" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                    Close
                </button>
            `;
        } else {
            actionsContainer.innerHTML = `
                <button onclick="closeViewModal()" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                    Close
                </button>
            `;
        }
        
        // Show modal
        document.getElementById('viewRequestModal').classList.remove('hidden');
    }
    
    function closeViewModal() {
        document.getElementById('viewRequestModal').classList.add('hidden');
    }

    async function updateRequestStatus(requestId, newStatus) {
        if (!confirm(`Are you sure you want to ${newStatus} this request?`)) {
            return;
        }

        try {
            const response = await fetch(`/admin/requests/${requestId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: newStatus
                })
            });

            const data = await response.json();

            if (data.success) {
                showNotification(`Request ${newStatus} successfully!`, 'success');
                // Reload page to show updated status
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification('Failed to update request status. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
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
    
    // Close modal when clicking outside
    document.getElementById('viewRequestModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeViewModal();
        }
    });
</script>
@endsection