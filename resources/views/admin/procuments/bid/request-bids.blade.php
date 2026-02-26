@extends('components.app')

@push('meta')
<meta name="reload" content="disabled">
<meta name="websocket" content="disabled">
@endpush

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Bids for Request #REQ00{{ sprintf('%03d', $request->id) }}</h1>
                <p class="text-slate-500 mt-2">{{ $request->item_name }} - {{ $request->quantity }} units</p>
            </div>
            <a href="/admin/bids" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                ← Back to All Requests
            </a>
        </div>
    </div>

    <!-- Bids Table -->
    <div class="bg-white rounded-lg shadow-md mx-4">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900">All Bids ({{ $request->bids->count() }})</h2>
                <div class="flex space-x-2">
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">
                        {{ $request->bids->where('status', 'pending')->count() + $request->bids->where('status', 'submitted')->count() }} Pending
                    </span>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                        {{ $request->bids->where('status', 'accepted')->count() }} Accepted
                    </span>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                        {{ $request->bids->where('status', 'rejected')->count() }} Rejected
                    </span>
                </div>
            </div>

            @if($request->bids->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Supplier
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bid Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Currency
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Proposal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bid Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($request->bids as $bid)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $bid->supplier_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ number_format($bid->bid_amount, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $bid->currency }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $bid->proposal ?? 'No proposal' }}">
                                    {{ $bid->proposal ?? 'No proposal' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $bid->bid_date }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($bid->status === 'submitted' || $bid->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                @elseif($bid->status === 'accepted')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @elseif($bid->status === 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($bid->status === 'submitted' || $bid->status === 'pending')
                                    <button onclick="updateBidStatus({{ $bid->id }}, 'accepted')" 
                                            class="text-green-600 hover:text-green-900 mr-3">
                                        Approve
                                    </button>
                                    <button onclick="updateBidStatus({{ $bid->id }}, 'rejected')" 
                                            class="text-red-600 hover:text-red-900">
                                        Reject
                                    </button>
                                @else
                                    <span class="text-gray-400">No actions</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-12 h-12 text-gray-300 mx-auto mb-4">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No bids yet</h3>
                <p class="text-gray-500">Suppliers haven't submitted any bids for this request</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function updateBidStatus(bidId, status) {
        if (!confirm(`Are you sure you want to ${status} this bid?`)) {
            return;
        }

        fetch(`/admin/bids/${bidId}/status`, {
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
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification('Failed to update bid status', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'error');
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
</script>

@push('scripts')
<script>
// Block WebSocket connections to prevent errors
(function() {
    const originalWebSocket = window.WebSocket;
    window.WebSocket = function(url, protocols) {
        if (url.includes('ws://') || url.includes('wss://')) {
            console.log('WebSocket connection blocked:', url);
            // Return a dummy WebSocket that doesn't actually connect
            return {
                readyState: 3, // CLOSED
                close: function() {},
                send: function() {},
                addEventListener: function() {},
                removeEventListener: function() {}
            };
        }
        return new originalWebSocket(url, protocols);
    };
})();
</script>
@endpush
@endsection
