@extends('components.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Create Storage Location</h1>
        <p class="text-slate-500 mt-2">Add a new storage location to your warehouse</p>
    </div>

    {{-- Breadcrumb --}}
    <div class="mb-6 px-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('warehouse.storage') }}" class="text-slate-700 hover:text-blue-600">
                        Storage Locations
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-slate-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-slate-500 md:ml-2">Create</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-lg border border-slate-200 p-6 mx-4">
        <form action="{{ route('warehouse.storage.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Name -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Name *</label>
                <input type="text" name="name" required
                       placeholder="e.g., Warehouse A-1, Section B, Rack 3"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

        

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('warehouse.storage') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Create Storage Location
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
