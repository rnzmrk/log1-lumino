<aside class="w-64 bg-gray-900 min-h-screen">
    <!-- Sidebar Header -->
    <div class="p-4 border-b border-gray-800">
        <div class="flex items-center space-x-3">
            <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center">
                <span class="text-lg font-bold text-white">
                    {{ strtoupper(substr(Auth::guard('supplier')->user()->company_name, 0, 1)) }}
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-white">{{ Auth::guard('supplier')->user()->company_name }}</p>
                <p class="text-xs text-gray-400">{{ ucfirst(Auth::guard('supplier')->user()->status) }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="mt-6 px-3">
        <div class="space-y-1">
            <!-- Dashboard -->
            <a href="{{ route('supplier.dashboard') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            
            <!-- Biddings -->
            <a href="{{ route('supplier.biddings') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.biddings') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Biddings
            </a>
            
            <!-- Orders -->
            <a href="{{ route('supplier.orders') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.orders') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Orders
            </a>
            
            <!-- Inbound -->
            <a href="{{ route('supplier.inbound') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.inbound') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Inbound
            </a>
            
            <!-- Returns -->
            <a href="{{ route('supplier.returns') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.returns') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                </svg>
                Returns
            </a>
            
            <!-- Requirements -->
            <a href="{{ route('supplier.requirements') }}" 
               class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('supplier.requirements') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Requirements
            </a>
        </div>
        
        <!-- Secondary Navigation -->
        <div class="mt-8">
            <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
            <div class="mt-2 space-y-1">
                <!-- Profile -->
                <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profile Settings
                </a>
                
                <!-- Reports -->
                <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Reports
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Status Banner -->
    @if(Auth::guard('supplier')->user()->status === 'pending')
        <div class="absolute bottom-0 left-0 right-0 p-4">
            <div class="bg-yellow-600 text-white p-3 rounded-lg">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium">Account Pending</p>
                        <p class="text-xs">Waiting for admin approval</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</aside>