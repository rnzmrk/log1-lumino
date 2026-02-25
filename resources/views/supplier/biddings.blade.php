@extends('components.supplier')

@section('content')
<div class="p-6">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Available Bids</h1>
        <p class="text-gray-600">Browse and apply for available supply requests</p>
    </div>

    <!-- Available Requests Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @php
            $requests = \App\Models\Request::where('status', 'for_bid')->where('type', 'supply')->get();
        @endphp
        
        @if($requests->count() > 0)
            @foreach($requests as $request)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <!-- Request Header -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                            For Bid
                        </span>
                        <span class="text-sm text-gray-500">
                            #REQ00{{ sprintf('%03d', $request->id) }}
                        </span>
                    </div>
                    
                    <!-- Request Details -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $request->item_name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $request->description ?? 'No description available' }}</p>
                    
                    <!-- Request Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Quantity:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $request->quantity }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Type:</span>
                            <span class="text-sm font-medium text-gray-900">{{ ucfirst($request->type) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Posted:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Apply for Bid Button -->
                    <button onclick="openBidModal({{ $request->id }}, '{{ $request->item_name }}', {{ $request->quantity }})" 
                            class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Apply for Bid
                    </button>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-16 h-16 text-gray-300 mx-auto mb-4">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No available bids</h3>
                    <p class="text-gray-500">Check back later for new bidding opportunities</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Bid Application Modal -->
<div id="bidModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Apply for Bid</h2>
                <button onclick="closeBidModal()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-6 h-6">
                        <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <form id="bidApplicationForm" onsubmit="submitBid(event)">
                @csrf
                <input type="hidden" id="requestId" name="request_id">
                
                <div class="space-y-4">
                    <!-- Request Info -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-600">Request:</p>
                        <p id="requestInfo" class="font-medium text-gray-900"></p>
                    </div>
                    
                    <!-- Supplier Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Your Name/Company</label>
                        <input type="text" id="supplierName" name="supplier_name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your name or company name"
                               value="{{ auth('supplier')->user()->company_name ?? auth('supplier')->user()->name ?? '' }}"
                               readonly>
                        <p class="text-xs text-gray-500 mt-1">Auto-filled from your profile</p>
                    </div>
                    
                    <!-- Bid Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bid Amount</label>
                        <input type="number" id="bidAmount" name="bid_amount" step="0.01" min="0" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your bid amount">
                    </div>
                    
                    <!-- Currency -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                        <select id="currency" name="currency" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="PHP">PHP</option>
                        </select>
                    </div>
                    
                    <!-- Proposal/Notes -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Proposal/Notes</label>
                        <textarea id="proposal" name="proposal" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Brief description of your proposal..."></textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeBidModal()" 
                                class="flex-1 bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Submit Bid
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openBidModal(requestId, itemName, quantity) {
        document.getElementById('requestId').value = requestId;
        document.getElementById('requestInfo').textContent = `#${String(requestId).padStart(3, '0')} - ${itemName} (${quantity} units)`;
        document.getElementById('bidModal').classList.remove('hidden');
    }

    function closeBidModal() {
        document.getElementById('bidModal').classList.add('hidden');
        document.getElementById('bidApplicationForm').reset();
    }

    async function submitBid(event) {
        event.preventDefault();
        
        const formData = new FormData(document.getElementById('bidApplicationForm'));
        const bidData = {
            request_id: formData.get('request_id'),
            supplier_name: formData.get('supplier_name'),
            bid_amount: formData.get('bid_amount'),
            currency: formData.get('currency'),
            proposal: formData.get('proposal')
        };

        try {
            const response = await fetch('/supplier/bids', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(bidData)
            });

            const data = await response.json();

            if (data.success) {
                const message = data.message.includes('updated') ? 'Bid updated successfully!' : 'Bid submitted successfully!';
                showNotification(message, 'success');
                closeBidModal();
                // Optionally reload page to show updated status
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Failed to submit bid. Please try again.', 'error');
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
    document.getElementById('bidModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeBidModal();
        }
    });
</script>
@endsection
