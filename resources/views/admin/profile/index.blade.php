@extends('components.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <a href="/admin/profile/edit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                    Edit Profile
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Picture -->
                <div class="md:col-span-1">
                    <div class="text-center">
                        @if(auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                 alt="Profile Picture" 
                                 class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200">
                        @else
                            <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-300 flex items-center justify-center">
                                <i class="fas fa-user text-gray-600 text-4xl"></i>
                            </div>
                        @endif
                        <h3 class="text-xl font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-gray-600">{{ auth()->user()->position }}</p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div class="md:col-span-2">
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Profile Information</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <p class="text-gray-900">{{ auth()->user()->name }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <p class="text-gray-900">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                                <p class="text-gray-900">{{ auth()->user()->position ?? 'Not specified' }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                                <p class="text-gray-900">{{ auth()->user()->department ?? 'Not specified' }}</p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-clock mr-2"></i>
                                Member since: {{ auth()->user()->created_at->format('F j, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Account Actions -->
                    <div class="mt-6 bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Account Actions</h3>
                        <div class="space-y-3">
                            <a href="/admin/profile/edit" class="block w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-center">
                                <i class="fas fa-edit mr-2"></i> Edit Profile
                            </a>
                            <a href="/admin/profile/change-password" class="block w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors text-center">
                                <i class="fas fa-key mr-2"></i> Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection