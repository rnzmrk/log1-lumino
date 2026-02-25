@extends('components.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <h1 class="text-3xl font-bold text-slate-900">Storage Locations</h1>
        <p class="text-slate-500 mt-2">Manage warehouse storage locations and capacity tracking</p>
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex gap-3 px-4">
        <a href="/warehouse/storage/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                <path d="M12 4v16m8-8H4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            New Storage Location
        </a>
    </div>

    {{-- Storage Locations Table --}}
    <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
        <table class="w-full">
            <thead class="bg-white border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium text-slate-700">Name</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($storageLocations as $storage)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $storage->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-12 w-12 text-slate-300 mb-3">
                                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <p class="text-lg font-medium text-slate-600">No storage locations found</p>
                                <p class="text-sm text-slate-500 mt-1">Create your first storage location to get started</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection