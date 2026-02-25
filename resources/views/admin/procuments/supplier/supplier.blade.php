@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Supplier Management</h1>
        <p class="text-slate-500 mt-2">Manage supplier information and contact details</p>
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

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Add Supplier
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3 12h18m-9-9v18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Import
        </button>
        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                <circle cx="17" cy="18" r="1.25" fill="currentColor" />
            </svg>
            Export
        </button>
    </div>

    {{-- Search and Filters --}}
    <div class="mb-6 bg-white rounded-lg border border-slate-200 p-4 mx-4">
        <div class="flex gap-4">
            <div class="flex-1">
                <input type="text" placeholder="Search by supplier name, contact, or email..." class="w-full px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Types</option>
                <option>Supplies</option>
                <option>Equipment</option>
                <option>Materials</option>
                <option>Services</option>
            </select>
            <select class="px-4 py-2 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option>All Status</option>
                <option>Pending</option>
                <option>Active</option>
                <option>Rejected</option>
            </select>
        </div>
    </div>

    {{-- Supplier Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden mx-4">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Supplier ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Company Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Full Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @if($suppliers->count() > 0)
                        @foreach($suppliers as $supplier)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $supplier->company_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $supplier->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $supplier->email }}</td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ $supplier->address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $supplier->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $supplier->type }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $supplier->phone ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full 
                                        @if($supplier->status === 'active') bg-green-100 text-green-700
                                        @elseif($supplier->status === 'pending') bg-amber-100 text-amber-700
                                        @else bg-red-100 text-red-700 @endif">
                                        @if($supplier->status === 'active') Active
                                        @elseif($supplier->status === 'pending') Pending
                                        @else Rejected @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('admin.supplier.show', $supplier->id) }}" class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</a>
                                    @if($supplier->status === 'pending')
                                        <form action="{{ route('admin.supplier.accept', $supplier->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to accept this supplier?');">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-medium mr-3">Accept</button>
                                        </form>
                                        <button onclick="rejectSupplier({{ $supplier->id }})" class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No suppliers found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by adding a new supplier.</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">{{ $suppliers->count() }}</span> of <span class="font-medium">{{ $suppliers->count() }}</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white" disabled>Next</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Reject Supplier</h3>
            <form id="rejectForm" action="" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="supplier_id" id="supplier_id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Please provide a reason for rejection..."></textarea>
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
// Accept supplier
function acceptSupplier(id) {
    console.log('Accepting supplier:', id);
    if (confirm('Are you sure you want to accept this supplier?')) {
        try {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/supplier/accept/${id}`;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token meta tag not found');
                alert('Error: Security token not found. Please refresh the page.');
                return;
            }
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            
            console.log('Submitting form:', form.action);
            form.submit();
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('Error: Could not submit the request. Please try again.');
        }
    }
}

// Reject supplier
function rejectSupplier(id) {
    document.getElementById('supplier_id').value = id;
    document.getElementById('rejectForm').action = `/admin/supplier/reject/${id}`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection