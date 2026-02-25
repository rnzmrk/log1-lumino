@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.supplier.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-5 w-5">
                    <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Back to Suppliers
            </a>
        </div>
        <h1 class="text-3xl font-bold text-slate-900 mt-4">Supplier Details</h1>
        <p class="text-slate-500 mt-2">View complete supplier information and manage account status</p>
    </div>

    {{-- Status Alert --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4 mx-4">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="px-4 grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Information --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Company Information --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-slate-900">Company Information</h2>
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full 
                        @if($supplier->status === 'active') bg-green-100 text-green-700
                        @elseif($supplier->status === 'pending') bg-amber-100 text-amber-700
                        @else bg-red-100 text-red-700 @endif">
                        @if($supplier->status === 'active') Active
                        @elseif($supplier->status === 'pending') Pending
                        @else Rejected @endif
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Company Name</label>
                        <p class="text-slate-900 font-medium">{{ $supplier->company_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Supplier Type</label>
                        <p class="text-slate-900 font-medium">{{ $supplier->type }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-500 mb-2">Address</label>
                        <p class="text-slate-900">{{ $supplier->address }}</p>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h2 class="text-xl font-semibold text-slate-900 mb-6">Contact Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Full Name</label>
                        <p class="text-slate-900 font-medium">{{ $supplier->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Email Address</label>
                        <p class="text-slate-900 font-medium">{{ $supplier->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Phone Number</label>
                        <p class="text-slate-900 font-medium">{{ $supplier->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Supplier ID</label>
                        <p class="text-slate-900 font-medium">#SUP{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>

            {{-- Rejection Reason (if rejected) --}}
            @if($supplier->status === 'rejected' && $supplier->rejection_reason)
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-red-900 mb-4">Rejection Reason</h2>
                    <p class="text-red-800">{{ $supplier->rejection_reason }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            {{-- Account Status --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Account Status</h3>
                
                @if($supplier->status === 'pending')
                    <div class="space-y-3">
                        <form action="{{ route('admin.supplier.accept', $supplier->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to accept this supplier?');">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                    <path d="M5 13l4 4L19 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Accept Supplier
                            </button>
                        </form>
                        <button onclick="openRejectModal()" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                                <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Reject Supplier
                        </button>
                    </div>
                @elseif($supplier->status === 'active')
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-green-900">Active Account</p>
                                <p class="text-sm text-green-700">This supplier has been approved</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center gap-3">
                            <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-red-900">Rejected Account</p>
                                <p class="text-sm text-red-700">This supplier has been rejected</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Account Details --}}
            <div class="bg-white rounded-lg border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Account Details</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Member Since</span>
                        <span class="text-sm font-medium text-slate-900">{{ $supplier->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-slate-500">Last Updated</span>
                        <span class="text-sm font-medium text-slate-900">{{ $supplier->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Reject Supplier</h3>
            <form action="{{ route('admin.supplier.reject', $supplier->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Please provide a reason for rejection..." required></textarea>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeRejectModal()" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
