@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Asset Requests</h1>
        <p class="text-slate-500 mt-2">Manage and approve asset requests from employees</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" onclick="openNewRequestModal()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            New Request
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <form method="GET" action="{{ route('assets.requests') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Search by item name..." 
                       class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select name="status" class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="for_bid" {{ request('status') == 'for_bid' ? 'selected' : '' }}>For Bid</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
            <a href="{{ route('assets.requests') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                Clear
            </a>
        </form>
    </div>

    {{-- Asset Request Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Request ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Item Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($requests as $request)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#AR{{ str_pad($request->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $request->item_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $request->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ ucfirst($request->type) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $request->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($request->status)
                                    @case('pending')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                                        @break
                                    @case('for_bid')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">For Bid</span>
                                        @break
                                    @case('approved')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Approved</span>
                                        @break
                                    @case('completed')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">Completed</span>
                                        @break
                                    @case('rejected')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Rejected</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($request->status === 'pending')
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'approved')" class="text-green-600 hover:text-green-800 font-medium mr-3">Approve</button>
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'rejected')" class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                @elseif($request->status === 'approved')
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'for_bid')" class="text-blue-600 hover:text-blue-800 font-medium mr-3">For Bid</button>
                                @elseif($request->status === 'for_bid')
                                    <button onclick="updateRequestStatus({{ $request->id }}, 'completed')" class="text-purple-600 hover:text-purple-800 font-medium">Completed</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke="join="round"/>
                                    </svg>
                                    @if(request('search') || request('status') || request('date'))
                                        <p class="text-lg font-medium text-slate-600">No asset requests found</p>
                                        <p class="text-sm text-slate-500 mt-1">Try adjusting your search or filter criteria</p>
                                    @else
                                        <p class="text-lg font-medium text-slate-600">No asset requests found</p>
                                        <p class="text-sm text-slate-500 mt-1">Asset requests will appear here once submitted</p>
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
                Showing <span class="font-medium">{{ $requests->firstItem() }}</span> to <span class="font-medium">{{ $requests->lastItem() }}</span> of <span class="font-medium">{{ $requests->total() }}</span> results
            </div>
            <div class="flex gap-2">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
</div>

<!-- New Request Modal -->
<div id="newRequestModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-slate-900">New Asset Request</h2>
                <button onclick="closeNewRequestModal()" class="text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <form id="newRequestForm" onsubmit="submitNewRequest(event)">
                @csrf
                <div class="space-y-4">

                    
                    <!-- Item Name -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Item Name</label>
                        <input type="text" id="itemName" name="item_name" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter item name...">
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Quantity</label>
                        <input type="number" id="quantity" name="quantity" min="1" required 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter quantity...">
                    </div>
                    <!-- Request Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Type</label>
                        <select id="requestType" name="request_type" required 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select type...</option>
                            <option value="asset">Asset</option>
                            <option value="supply">Supply</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                        Submit Request
                    </button>
                    <button type="button" onclick="closeNewRequestModal()" class="flex-1 bg-white border border-slate-300 text-slate-700 py-2 px-4 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openNewRequestModal() {
        document.getElementById('newRequestModal').classList.remove('hidden');
    }
    
    function closeNewRequestModal() {
        document.getElementById('newRequestModal').classList.add('hidden');
        document.getElementById('newRequestForm').reset();
    }
    
    function submitNewRequest(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        const requestData = {
            item_name: formData.get('item_name'),
            quantity: formData.get('quantity'),
            type: formData.get('request_type')
        };
        
        fetch('/admin/requests/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(requestData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Request submitted successfully!', 'success');
                closeNewRequestModal();
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Failed to submit request', 'error');
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
    
    function updateRequestStatus(requestId, status) {
        if (confirm(`Are you sure you want to ${status} this request?`)) {
            fetch(`/admin/requests/${requestId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(`Request ${status} successfully!`, 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showNotification('Failed to update request status.', 'error');
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