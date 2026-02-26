@extends('components.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Change Password</h1>
                <a href="/admin/profile" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                    ← Back to Profile
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/admin/profile/update-password" method="POST">
                @csrf
                <div class="max-w-md mx-auto">
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Security Notice</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Choose a strong password that you don't use for other websites.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="current_password" 
                                   name="current_password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password"
                                   minlength="8"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation"
                                   minlength="8"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="/admin/profile" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-key mr-2"></i> Change Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
