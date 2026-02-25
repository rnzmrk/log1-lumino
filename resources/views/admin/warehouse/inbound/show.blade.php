@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Inbound Shipment Details</h1>
                <p class="text-slate-500 mt-2">View and update inbound shipment information</p>
            </div>
            <a href="{{ route('warehouse.inbound') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Inbound
            </a>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="mb-4 mx-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 mx-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-4">
        {{-- Inbound Details --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-semibold text-slate-900">Shipment Information</h2>
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full
                            @switch($inbound->status)
                                @case('pending')
                                    bg-blue-100 text-blue-700
                                    @break
                                @case('in_transit')
                                    bg-amber-100 text-amber-700
                                    @break
                                @case('arrived')
                                    bg-green-100 text-green-700
                                    @break
                                @case('received')
                                    bg-slate-100 text-slate-700
                                    @break
                                @default
                                    bg-gray-100 text-gray-700
                            @endswitch
                        ">
                            {{ ucfirst(str_replace('_', ' ', $inbound->status)) }}
                        </span>
                    </div>

                    <form action="{{ route('admin.inbound.update', $inbound->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Inbound ID -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Inbound ID</label>
                                <input type="text" value="#INB{{ str_pad($inbound->id, 3, '0', STR_PAD_LEFT) }}" readonly
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600">
                            </div>

                            <!-- PO ID -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Purchase Order ID</label>
                                <input type="text" value="#PO{{ $inbound->purchaseOrder->id }}" readonly
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg bg-slate-50 text-slate-600">
                            </div>

                            <!-- Storage Location -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Storage Location</label>
                                <select name="storage_location_id"
                                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select storage location...</option>
                                    @if(isset($storageLocations))
                                        @foreach($storageLocations as $location)
                                            <option value="{{ $location->id }}" {{ $inbound->storage_location_id == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('storage_location_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity Received -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Quantity Received</label>
                                <input type="number" name="quantity_received" value="{{ $inbound->quantity_received ?? '' }}" min="1"
                                       placeholder="Enter quantity"
                                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('quantity_received')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Notes</label>
                            <textarea name="notes" rows="4" placeholder="Additional notes about the inbound shipment..."
                                      class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('notes', $inbound->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3 pt-4 border-t">
                            <a href="{{ route('warehouse.inbound') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Update Inbound
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Purchase Order Details --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg border border-slate-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Purchase Order Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-slate-600">PO ID:</span>
                            <p class="font-medium text-slate-900">#PO{{ $inbound->purchaseOrder->id }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Supplier:</span>
                            <p class="font-medium text-slate-900">{{ $inbound->purchaseOrder->supplier }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Price:</span>
                            <p class="font-medium text-slate-900">{{ number_format($inbound->purchaseOrder->price, 2) }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Expected Delivery:</span>
                            <p class="font-medium text-slate-900">{{ $inbound->purchaseOrder->expected_delivery_date ? $inbound->purchaseOrder->expected_delivery_date->format('M d, Y') : 'Not set' }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">PO Status:</span>
                            <p class="font-medium text-slate-900">{{ ucfirst($inbound->purchaseOrder->status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Request Details --}}
            @if($inbound->purchaseOrder->request)
            <div class="bg-white rounded-lg border border-slate-200 mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Request Details</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-slate-600">Request ID:</span>
                            <p class="font-medium text-slate-900">#REQ00{{ sprintf('%03d', $inbound->purchaseOrder->request->id) }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Item Name:</span>
                            <p class="font-medium text-slate-900">{{ $inbound->purchaseOrder->request->item_name }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Quantity:</span>
                            <p class="font-medium text-slate-900">{{ $inbound->purchaseOrder->request->quantity }}</p>
                        </div>
                        
                        <div>
                            <span class="text-sm text-slate-600">Description:</span>
                            <p class="font-medium text-slate-900">{{ $inbound->purchaseOrder->request->description ?? 'No description' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
