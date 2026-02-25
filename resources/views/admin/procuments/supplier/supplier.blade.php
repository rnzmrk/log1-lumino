@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Supplier Management</h1>
        <p class="text-slate-500 mt-2">Manage supplier information and contact details</p>
    </div>

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
                <option>Accepted</option>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Representative</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Office Supplies Co</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">John Smith</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">john@officesupplies.com</td>
                        <td class="px-6 py-4 text-sm text-slate-600">123 Business Ave, Suite 100, New York, NY 10001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Sarah Johnson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Supplies</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">(555) 123-4567</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium mr-3">Accept</button>
                            <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">TechGear Inc</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Michael Chen</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">mchen@techgear.com</td>
                        <td class="px-6 py-4 text-sm text-slate-600">456 Tech Boulevard, Floor 5, San Francisco, CA 94105</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Emily Davis</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Equipment</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">(555) 234-5678</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium mr-3">Accept</button>
                            <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">PrintMaster Ltd</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Robert Wilson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">robert@printmaster.com</td>
                        <td class="px-6 py-4 text-sm text-slate-600">789 Industrial Park, Chicago, IL 60601</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Lisa Anderson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Supplies</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">(555) 345-6789</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium mr-3">Accept</button>
                            <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP004</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">SafetyFirst Corp</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">David Martinez</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">david@safetyfirst.com</td>
                        <td class="px-6 py-4 text-sm text-slate-600">321 Safety Drive, Los Angeles, CA 90001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Jennifer Taylor</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Materials</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">(555) 456-7890</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-700">Pending</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium mr-3">View</button>
                            <button class="text-green-600 hover:text-green-800 font-medium mr-3">Accept</button>
                            <button class="text-red-600 hover:text-red-800 font-medium">Reject</button>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">#SUP005</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">CablePro Solutions</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">James Brown</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">james@cablepro.com</td>
                        <td class="px-6 py-4 text-sm text-slate-600">567 Electronics Way, Austin, TX 73301</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Amanda White</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">Equipment</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">(555) 567-8901</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Rejected</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button class="text-blue-600 hover:text-blue-800 font-medium">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="bg-slate-50 px-6 py-3 flex items-center justify-between border-t border-slate-200">
            <div class="text-sm text-slate-700">
                Showing <span class="font-medium">1</span> to <span class="font-medium">5</span> of <span class="font-medium">24</span> results
            </div>
            <div class="flex gap-2">
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                <button class="px-3 py-1 text-sm bg-blue-600 text-white rounded-md">1</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">2</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">3</button>
                <button class="px-3 py-1 text-sm border border-slate-300 rounded-md hover:bg-white">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection