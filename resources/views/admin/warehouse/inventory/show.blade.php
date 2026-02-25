@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Inventory Details</h1>
                <p class="text-slate-500 mt-2">View detailed inventory information</p>
            </div>
            <a href="{{ route('warehouse.inventory') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Inventory
            </a>
        </div>
    </div>

    @if($inventory)
        {{-- Inventory Details Card --}}
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mb-6">
            <div class="p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900">#INV{{ str_pad($inventory->id, 3, '0', STR_PAD_LEFT) }}</h2>
                        <p class="text-slate-500 mt-1">Inventory Item Details</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @php
                            $quantity = $inventory->quantity ?? 0;
                            if ($quantity == 0) {
                                $statusClass = 'bg-red-100 text-red-700';
                                $statusText = 'Out of Stock';
                            } elseif ($quantity <= 20) {
                                $statusClass = 'bg-amber-100 text-amber-700';
                                $statusText = 'Low Stock';
                            } else {
                                $statusClass = 'bg-green-100 text-green-700';
                                $statusText = 'In Stock';
                            }
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Item Information --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Item Information</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Item Name</label>
                                <p class="text-slate-900">{{ $inventory->inbound->purchaseOrder->request->item_name ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Type</label>
                                <p class="text-slate-900">{{ ucfirst($inventory->inbound->purchaseOrder->request->type ?? 'N/A') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Description</label>
                                <p class="text-slate-900">{{ $inventory->inbound->purchaseOrder->request->description ?? 'No description available' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Quantity & Price --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Quantity & Price</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Current Quantity</label>
                                <p class="text-2xl font-bold text-slate-900">{{ $inventory->quantity ?? 0 }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Price per Unit</label>
                                <p class="text-slate-900">{{ number_format($inventory->inbound->purchaseOrder->price ?? 0, 2) }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Total Value</label>
                                <p class="text-slate-900">{{ number_format(($inventory->quantity ?? 0) * ($inventory->inbound->purchaseOrder->price ?? 0), 2) }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Location & Supplier --}}
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-slate-900 border-b pb-2">Location & Supplier</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-slate-600">Storage Location</label>
                                <p class="text-slate-900">{{ $inventory->inbound->storageLocation->name ?? ($inventory->inbound->location ?? 'N/A') }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Supplier</label>
                                <p class="text-slate-900">
                                    @if(is_object($inventory->inbound->purchaseOrder->supplier))
                                        {{ $inventory->inbound->purchaseOrder->supplier->company_name ?? 'N/A' }}
                                    @else
                                        {{ $inventory->inbound->purchaseOrder->supplier ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-slate-600">Date Added</label>
                                <p class="text-slate-900">{{ $inventory->inbound->created_at ? $inventory->inbound->created_at->format('M d, Y') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Information --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Purchase Order Information --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Purchase Order Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">PO ID:</span>
                            <span class="text-slate-900">#PO{{ $inventory->inbound->purchaseOrder->id }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Original Quantity:</span>
                            <span class="text-slate-900">{{ $inventory->inbound->purchaseOrder->request->quantity ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Quantity Received:</span>
                            <span class="text-slate-900">{{ $inventory->inbound->quantity_received ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Unit Price:</span>
                            <span class="text-slate-900">{{ number_format($inventory->inbound->purchaseOrder->price ?? 0, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">PO Status:</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                Approved
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inbound Shipment Information --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Inbound Shipment Information</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Inbound ID:</span>
                            <span class="text-slate-900">#INB{{ str_pad($inventory->inbound->id, 3, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Status:</span>
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-700">
                                {{ ucfirst($inventory->inbound->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-slate-600">Received Date:</span>
                            <span class="text-slate-900">{{ $inventory->inbound->created_at ? $inventory->inbound->created_at->format('M d, Y') : 'N/A' }}</span>
                        </div>
                        
                        @if($inventory->inbound->notes)
                        <div>
                            <span class="text-sm font-medium text-slate-600">Notes:</span>
                            <p class="text-slate-900 mt-1">{{ $inventory->inbound->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 flex gap-3">
            <a href="{{ route('warehouse.outbound') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Create Outbound Shipment
            </a>
            
            <a href="{{ route('warehouse.return') }}" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                    <path d="M9 15L3 9m0 0l6-6m-6 6h12a2 2 0 012 2v3a2 2 0 01-2 2H6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Create Return
            </a>
        </div>

    @else
        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
            <div class="p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mx-auto mb-4">
                    <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="text-lg font-medium text-slate-600 mb-2">Inventory Item Not Found</h3>
                <p class="text-slate-500 mb-4">The inventory item you're looking for doesn't exist or has been removed.</p>
                <a href="{{ route('warehouse.inventory') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Back to Inventory
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
