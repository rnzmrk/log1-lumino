@extends('components.app')

@section('content')
<div class="w-full">
    {{-- Header --}}
    <div class="mb-6 px-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('logistics.vehicles') }}" class="text-slate-600 hover:text-slate-900">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                    <path d="M15 19l-7-7 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Add Vehicle</h1>
                <p class="text-slate-500 mt-2">Add a new vehicle to the fleet</p>
            </div>
        </div>
    </div>

    {{-- Add Vehicle Form --}}
    <div class="bg-white rounded-lg border border-slate-200 mx-4 max-w-4xl">
        <form method="POST" action="{{ route('logistics.vehicles.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Plate Number --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Plate Number</label>
                    <input type="text" name="plate_number" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., ABC-1234">
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Vehicle Type</label>
                    <select name="type" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select vehicle type...</option>
                        <option value="SUV">SUV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Truck">Truck</option>
                        <option value="Van">Van</option>
                        <option value="4 Seater">4 Seater</option>
                        <option value="6 Seater">6 Seater</option>
                        <option value="Motorcycle">Motorcycle</option>
                    </select>
                </div>

                {{-- Year --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Year</label>
                    <input type="number" name="year" min="1900" max="{{ date('Y') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., 2023">
                </div>

                {{-- Brand --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Brand</label>
                    <input type="text" name="brand" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., Toyota, Honda, Ford">
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Color</label>
                    <input type="text" name="color" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., White, Black, Blue">
                </div>

                {{-- Capacity --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Capacity</label>
                    <input type="number" name="capacity" min="1"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., 5">
                </div>

                {{-- Driver --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Driver</label>
                    <input type="text" name="driver" 
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="e.g., John Smith (Optional)">
                </div>


            {{-- Form Actions --}}
            <div class="flex gap-3 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('logistics.vehicles') }}" class="px-6 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Add Vehicle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Form submission with loading state
    document.querySelector('form').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding Vehicle...';
        
        // Re-enable button if submission fails (after 5 seconds as fallback)
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }, 5000);
    });
</script>
@endsection
