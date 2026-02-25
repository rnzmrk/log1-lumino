<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <h1 class="text-xl font-bold text-blue-600">Lumino Logistics</h1>
                </div>
                <div class="ml-6 flex items-center">
                    <span class="text-sm text-gray-500">Supplier Portal</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.07 2.93L3 10l7.07 7.07M20 10H3"/>
                    </svg>
                    <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::guard('supplier')->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::guard('supplier')->user()->company_name }}</p>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <span class="text-sm font-medium text-blue-600">
                            {{ strtoupper(substr(Auth::guard('supplier')->user()->name, 0, 1)) }}
                        </span>
                    </div>
                </div>
                
                <!-- Logout -->
                <form action="{{ route('supplier.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>