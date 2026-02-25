@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Bid Management</h1>
        <p class="text-slate-500 mt-2">Review and manage supplier bids for requests</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 px-4">
        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div>
                <p class="text-sm font-medium text-slate-600">Total Requests with Bids</p>
                <p class="text-2xl font-bold text-slate-900 mt-2">{{ $requestsWithBids->count() }}</p>
                <p class="text-sm text-slate-500 mt-1">Active bidding</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div>
                <p class="text-sm font-medium text-slate-600">Pending Bids</p>
                <p class="text-2xl font-bold text-amber-600 mt-2">{{ $pendingBidsCount }}</p>
                <p class="text-sm text-slate-500 mt-1">Awaiting review</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div>
                <p class="text-sm font-medium text-slate-600">Approved Bids</p>
                <p class="text-2xl font-bold text-green-600 mt-2">{{ $approvedBidsCount }}</p>
                <p class="text-sm text-slate-500 mt-1">Accepted</p>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200 p-6">
            <div>
                <p class="text-sm font-medium text-slate-600">Rejected Bids</p>
                <p class="text-2xl font-bold text-red-600 mt-2">{{ $rejectedBidsCount }}</p>
                <p class="text-sm text-slate-500 mt-1">Declined</p>
            </div>
        </div>
    </div>

    {{-- Requests with Bids Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
        @if($requestsWithBids->count() > 0)
            @foreach($requestsWithBids as $request)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                <div class="p-6">
                    <!-- Request Header -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-700">
                            {{ $request->status }}
                        </span>
                        <span class="text-sm text-gray-500">
                            #REQ00{{ sprintf('%03d', $request->id) }}
                        </span>
                    </div>
                    
                    <!-- Request Details -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $request->item_name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ $request->description ?? 'No description available' }}</p>
                    
                    <!-- Bid Info -->
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Quantity:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $request->quantity }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Total Bids:</span>
                            <span class="text-sm font-medium text-blue-600">{{ $request->bids_count }} bids</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Lowest Bid:</span>
                            <span class="text-sm font-medium text-green-600">
                                @if($request->lowest_bid)
                                    {{ number_format($request->lowest_bid, 2) }}
                                @else
                                    No bids yet
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Posted:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $request->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="space-y-2">
                        <button onclick="viewBids({{ $request->id }})" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                            View All Bids
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-16 h-16 text-gray-300 mx-auto mb-4">
                        <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No requests with bids</h3>
                    <p class="text-gray-500">When suppliers submit bids, they will appear here</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    function viewBids(requestId) {
        window.location.href = `/admin/requests/${requestId}/bids`;
    }
</script>
@endsection