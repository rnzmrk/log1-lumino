@extends('components.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
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

            <form action="/admin/profile/update" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Profile Picture -->
                    <div class="md:col-span-1">
                        <div class="text-center">
                            @if(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                     alt="Profile Picture" 
                                     id="current-profile-pic"
                                     class="w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200">
                            @else
                                <div class="w-32 h-32 rounded-full mx-auto mb-4 bg-gray-300 flex items-center justify-center">
                                    <i class="fas fa-user text-gray-600 text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">
                                    Profile Picture
                                </label>
                                <input type="file" 
                                       id="profile_picture" 
                                       name="profile_picture" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                       onchange="previewImage(event)">
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG, GIF up to 2MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Personal Information</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ auth()->user()->name }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           required>
                                </div>
                                
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ auth()->user()->email }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           required>
                                </div>
                                
                                <div>
                                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">
                                        Position
                                    </label>
                                    <input type="text" 
                                           id="position" 
                                           name="position" 
                                           value="{{ auth()->user()->position ?? '' }}"
                                           placeholder="e.g. Manager, Developer, etc."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="department" class="block text-sm font-medium text-gray-700 mb-1">
                                        Department
                                    </label>
                                    <input type="text" 
                                           id="department" 
                                           name="department" 
                                           value="{{ auth()->user()->department ?? '' }}"
                                           placeholder="e.g. IT, HR, Finance, etc."
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Password Section -->
                        <div class="mt-6 bg-yellow-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password (Optional)</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password
                                    </label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password
                                    </label>
                                    <input type="password" 
                                           id="new_password" 
                                           name="new_password"
                                           minlength="8"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirm New Password
                                    </label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           minlength="8"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="/admin/profile" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentPic = document.getElementById('current-profile-pic');
            if (currentPic.tagName === 'IMG') {
                currentPic.src = e.target.result;
            } else {
                // Replace the placeholder div with an img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.id = 'current-profile-pic';
                img.className = 'w-32 h-32 rounded-full mx-auto mb-4 object-cover border-4 border-gray-200';
                img.alt = 'Profile Picture';
                currentPic.parentNode.replaceChild(img, currentPic);
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection