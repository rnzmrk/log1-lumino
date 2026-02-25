<aside class="h-full w-64 bg-white border-r border-slate-200 flex flex-col" id="sidebar">
    {{-- Logo --}}
    <div class="h-16 flex items-center justify-center border-b border-slate-200">
        <img src="{{ asset('images/newlogo.svg') }}" alt="Logo" class="h-10 w-auto">
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6 text-sm">
        {{-- Dashboard --}}
        <div>
            <a href="{{ route('dashboard') }}" 
               data-item="dashboard"
               class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                        <path d="M3 10.5L12 3l9 7.5V21a.75.75 0 01-.75.75H14.25a.75.75 0 01-.75-.75v-4.5h-3v4.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 21v-10.5z"
                              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        {{-- Section title --}}
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-widest">
            Operations
        </div>

        {{-- Warehouse --}}
        <div class="space-y-1">
            <button type="button" 
                    data-section="warehouse"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M3 9.75L12 4.5l9 5.25V19.5a.75.75 0 01-.75.75h-15A.75.75 0 013 19.5V9.75z"
                                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9 21h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                    </span>
                    <span class="font-medium">Warehouse</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="warehouse">
                <a href="{{ route('warehouse.inbound') }}" 
                   data-item="warehouse-inbound"
                   data-section="warehouse"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Inbound
                </a>
                <a href="{{ route('warehouse.inventory') }}" 
                   data-item="warehouse-inventory"
                   data-section="warehouse"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Inventory
                </a>
                <a href="{{ route('warehouse.outbound') }}" 
                   data-item="warehouse-outbound"
                   data-section="warehouse"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Outbound
                </a>
                <a href="{{ route('warehouse.return') }}" 
                   data-item="warehouse-returns"
                   data-section="warehouse"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Returns
                </a>
            </div>
        </div>

        {{-- Procurement --}}
        <div class="space-y-1">
            <button type="button" 
                    data-section="procurement"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M3.75 5.25h2.25L7.5 15.75h11.25" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="9" cy="18" r="1.25" fill="currentColor" />
                            <circle cx="17" cy="18" r="1.25" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="font-medium">Procurement</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="procurement">
                <a href="{{ route('procurement.request') }}" 
                   data-item="procurement-request"
                   data-section="procurement"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Request
                </a>
                <a href="{{ route('procurement.po') }}" 
                   data-item="procurement-po"
                   data-section="procurement"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Purchase Order
                </a>
                <a href="{{ route('procurement.supplier') }}" 
                   data-item="procurement-supplier"
                   data-section="procurement"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Supplier
                </a>
            </div>
        </div>

        {{-- Asset --}}
        <div class="space-y-1">
            <button type="button" 
                    data-section="asset"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M15.232 5.232a3 3 0 01-3.536 3.536L6.75 13.714V17.25h3.536l4.946-4.946a3 3 0 003.536-3.536L15.75 5.25l-.518-.018z"
                                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="font-medium">Asset</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="asset">
                <a href="{{ route('assets.request') }}" 
                   data-item="asset-request"
                   data-section="asset"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Asset Request
                </a>
                <a href="{{ route('assets.list') }}" 
                   data-item="asset-list"
                   data-section="asset"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Assets List
                </a>
                <a href="{{ route('assets.maintenance') }}" 
                   data-item="asset-maintenance"
                   data-section="asset"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Asset Maintenance
                </a>
            </div>
        </div>

        {{-- Project Logistics --}}
        <div class="space-y-1">
            <button type="button" 
                    data-section="logistics"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M3.75 7.5h9v9h-9V7.5zM12.75 9h3.75l3 3.75v3.75h-6.75V9z"
                                  stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <circle cx="7.5" cy="17.25" r="1.25" fill="currentColor" />
                            <circle cx="16.5" cy="17.25" r="1.25" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="font-medium">Project Logistics</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="logistics">
                <a href="{{ route('logistics.vehicles') }}" 
                   data-item="logistics-list"
                   data-section="logistics"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   List of Vehicle
                </a>
                <a href="{{ route('logistics.tracking') }}" 
                   data-item="logistics-tracking"
                   data-section="logistics"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Vehicle Tracking
                </a>
                <a href="{{ route('logistics.maintenance') }}" 
                   data-item="logistics-maintenance"
                   data-section="logistics"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Vehicle Maintenance
                </a>
            </div>
        </div>

        {{-- Documents --}}
        <div class="space-y-1">
            <button type="button" 
                    data-section="documents"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M9.75 3.75h4.5L18.75 8.25v11.25H9.75V3.75z" stroke="currentColor"
                                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.75 8.25h4.5V3.75" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="font-medium">Documents</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="documents">
                <a href="{{ route('documents.reports') }}" 
                   data-item="documents-reports"
                   data-section="documents"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Reports
                </a>
            </div>
        </div>
        <hr class="border-slate-200 my-4">
        
        {{-- Others --}}
        <div class="space-y-1"> 
            <button type="button" 
                    data-section="others"
                    class="sidebar-section-toggle w-full flex items-center justify-between rounded-lg px-3 py-2 transition-colors text-slate-700 hover:bg-slate-100 hover:text-blue-600">
                <span class="flex items-center gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="h-4 w-4">
                            <path d="M9.75 3.75h4.5L18.75 8.25v11.25H9.75V3.75z" stroke="currentColor"
                                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M9.75 8.25h4.5V3.75" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="font-medium">Others</span>
                </span>
                <span class="text-xs text-slate-400 transition-transform sidebar-chevron">▾</span>
            </button>
            <div class="sidebar-section-content ml-11 space-y-1 text-slate-600 hidden" data-section="others">
                <a href="#" 
                   data-item="supplier-list"
                   data-section="others"
                   class="sidebar-link block py-2 px-3 transition-all duration-200 border-l-2 border-transparent hover:text-blue-600 hover:bg-slate-50 hover:border-l-2 hover:border-blue-300">
                   Supplier Account List
                </a>
            </div>
        </div>
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = {
        openSection: null,
        activeItem: null,
        sectionItems: {
            'warehouse': ['warehouse-inbound', 'warehouse-inventory', 'warehouse-outbound', 'warehouse-returns'],
            'procurement': ['procurement-request', 'procurement-po', 'procurement-supplier'],
            'asset': ['asset-request', 'asset-list', 'asset-maintenance'],
            'logistics': ['logistics-list', 'logistics-tracking', 'logistics-maintenance'],
            'documents': ['documents-reports'],
            'supplier-accounts': ['supplier-list', 'supplier-profiles', 'supplier-contracts', 'supplier-payments']
        },

        init() {
            this.setupEventListeners();
            this.updateOpenSection();
            this.setActiveItemFromCurrentPage();
        },

        setupEventListeners() {
            // Section toggle buttons
            document.querySelectorAll('.sidebar-section-toggle').forEach(button => {
                button.addEventListener('click', (e) => {
                    const section = e.currentTarget.dataset.section;
                    this.toggleSection(section);
                });
            });

            // Navigation links
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    const item = e.currentTarget.dataset.item;
                    const section = e.currentTarget.dataset.section;
                    this.setActiveItem(item, section);
                });
            });
        },

        toggleSection(section) {
            if (this.openSection === section) {
                // Only close if this section doesn't have active items
                const hasActiveItems = this.sectionItems[section].includes(this.activeItem);
                if (!hasActiveItems) {
                    this.closeSection(section);
                }
            } else {
                this.openSection = section;
                this.showSection(section);
            }
        },

        showSection(section) {
            // Hide all sections
            document.querySelectorAll('.sidebar-section-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Reset all chevrons
            document.querySelectorAll('.sidebar-chevron').forEach(chevron => {
                chevron.classList.remove('rotate-180');
            });
            
            // Reset all section buttons
            document.querySelectorAll('.sidebar-section-toggle').forEach(button => {
                button.classList.remove('bg-slate-100', 'text-blue-600');
            });

            // Show selected section
            const sectionContent = document.querySelector(`.sidebar-section-content[data-section="${section}"]`);
            const sectionButton = document.querySelector(`.sidebar-section-toggle[data-section="${section}"]`);
            const chevron = sectionButton?.querySelector('.sidebar-chevron');

            if (sectionContent) {
                sectionContent.classList.remove('hidden');
            }
            if (sectionButton) {
                sectionButton.classList.add('bg-slate-100', 'text-blue-600');
            }
            if (chevron) {
                chevron.classList.add('rotate-180');
            }
        },

        closeSection(section) {
            const sectionContent = document.querySelector(`.sidebar-section-content[data-section="${section}"]`);
            const sectionButton = document.querySelector(`.sidebar-section-toggle[data-section="${section}"]`);
            const chevron = sectionButton?.querySelector('.sidebar-chevron');

            if (sectionContent) {
                sectionContent.classList.add('hidden');
            }
            if (sectionButton) {
                sectionButton.classList.remove('bg-slate-100', 'text-blue-600');
            }
            if (chevron) {
                chevron.classList.remove('rotate-180');
            }
            
            this.openSection = null;
        },

        setActiveItem(item, section) {
            // Clear all active states
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.classList.remove('text-blue-600', 'font-medium', 'bg-blue-50', 'border-l-2', 'border-blue-600');
                link.classList.add('border-transparent');
            });

            // Clear dashboard active state
            document.querySelector('[data-item="dashboard"]')?.classList.remove('bg-blue-50', 'text-blue-600');

            // Set new active item
            this.activeItem = item;
            const activeLink = document.querySelector(`[data-item="${item}"]`);
            
            if (activeLink) {
                activeLink.classList.add('text-blue-600', 'font-medium', 'bg-blue-50', 'border-l-2', 'border-blue-600');
                activeLink.classList.remove('border-transparent');
            }

            // Open the section
            if (section) {
                this.openSection = section;
                this.showSection(section);
            }
        },

        updateOpenSection() {
            if (this.activeItem) {
                for (const [section, items] of Object.entries(this.sectionItems)) {
                    if (items.includes(this.activeItem)) {
                        this.openSection = section;
                        this.showSection(section);
                        break;
                    }
                }
            }
        },

        setActiveItemFromCurrentPage() {
            // Get current page path and determine active item
            const currentPath = window.location.pathname;
            
            // Map paths to active items
            const pathToItem = {
                '/warehouse/inbound': 'warehouse-inbound',
                '/warehouse/inventory': 'warehouse-inventory',
                '/warehouse/outbound': 'warehouse-outbound',
                '/warehouse/return': 'warehouse-returns',
                '/procurement/request': 'procurement-request',
                '/procurement/po': 'procurement-po',
                '/procurement/supplier': 'procurement-supplier',
                '/assets/request': 'asset-request',
                '/assets/list': 'asset-list',
                '/assets/maintenance': 'asset-maintenance',
                '/logistics/vehicles': 'logistics-list',
                '/logistics/tracking': 'logistics-tracking',
                '/logistics/maintenance': 'logistics-maintenance',
                '/documents/reports': 'documents-reports',
                '/dashboard': 'dashboard'
            };

            const activeItem = pathToItem[currentPath];
            if (activeItem) {
                if (activeItem === 'dashboard') {
                    this.setActiveItem('dashboard', null);
                    document.querySelector('[data-item="dashboard"]').classList.add('bg-blue-50', 'text-blue-600');
                } else {
                    // Find which section this item belongs to
                    for (const [section, items] of Object.entries(this.sectionItems)) {
                        if (items.includes(activeItem)) {
                            this.setActiveItem(activeItem, section);
                            break;
                        }
                    }
                }
            }
        }
    };

    sidebar.init();
});
</script>
