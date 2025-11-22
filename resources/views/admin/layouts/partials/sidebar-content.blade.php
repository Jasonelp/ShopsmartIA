<div class="flex flex-1 flex-col overflow-y-auto">
    <!-- Logo -->
    <div class="flex h-16 shrink-0 items-center px-4 border-b border-indigo-800">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
            <div class="h-8 w-8 rounded-lg bg-white flex items-center justify-center">
                <svg class="h-5 w-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.504 1.132a1 1 0 01.992 0l1.75 1a1 1 0 11-.992 1.736L10 3.152l-1.254.716a1 1 0 11-.992-1.736l1.75-1zM5.618 4.504a1 1 0 01-.372 1.364L5.016 6l.23.132a1 1 0 11-.992 1.736L4 7.723V8a1 1 0 01-2 0V6a.996.996 0 01.52-.878l1.734-.99a1 1 0 011.364.372zm8.764 0a1 1 0 011.364-.372l1.733.99A1.002 1.002 0 0118 6v2a1 1 0 11-2 0v-.277l-.254.145a1 1 0 11-.992-1.736l.23-.132-.23-.132a1 1 0 01-.372-1.364zm-7 4a1 1 0 011.364-.372L10 8.848l1.254-.716a1 1 0 11.992 1.736L11 10.58V12a1 1 0 11-2 0v-1.42l-1.246-.712a1 1 0 01-.372-1.364zM3 11a1 1 0 011 1v1.42l1.246.712a1 1 0 11-.992 1.736l-1.75-1A1 1 0 012 14v-2a1 1 0 011-1zm14 0a1 1 0 011 1v2a1 1 0 01-.504.868l-1.75 1a1 1 0 11-.992-1.736L16 13.42V12a1 1 0 011-1zm-9.618 5.504a1 1 0 011.364-.372l.254.145V16a1 1 0 112 0v.277l.254-.145a1 1 0 11.992 1.736l-1.735.992a.995.995 0 01-1.022 0l-1.735-.992a1 1 0 01-.372-1.364z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-white font-bold text-lg">ShopSmart</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-1 px-2 py-4">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>

        <!-- Divider -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Gestion</p>
        </div>

        <!-- Products -->
        <a href="{{ route('admin.products.index') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
            Productos
        </a>

        <!-- Categories -->
        <a href="{{ route('admin.categories.index') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
            Categorias
        </a>

        <!-- Orders -->
        <a href="{{ route('admin.orders.index') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            Ordenes
            @php
                $pendingOrders = \App\Models\Order::where('status', 'pendiente')->count();
            @endphp
            @if($pendingOrders > 0)
                <span class="ml-auto inline-flex items-center rounded-full bg-yellow-400 px-2 py-0.5 text-xs font-medium text-yellow-800">
                    {{ $pendingOrders }}
                </span>
            @endif
        </a>

        <!-- Divider -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Usuarios</p>
        </div>

        <!-- Users -->
        <a href="{{ route('admin.users') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users') || request()->routeIs('admin.users.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            Usuarios
        </a>

        <!-- Reports -->
        <a href="{{ route('admin.reports.index') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reports.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            Reportes
            @php
                $pendingReportsCount = \App\Models\Report::where('status', 'pending')->count();
            @endphp
            @if($pendingReportsCount > 0)
                <span class="ml-auto inline-flex items-center rounded-full bg-red-500 px-2 py-0.5 text-xs font-medium text-white">
                    {{ $pendingReportsCount }}
                </span>
            @endif
        </a>

        <!-- Divider -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Finanzas</p>
        </div>

        <!-- Sales -->
        <a href="{{ route('admin.sales') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.sales') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Ventas
        </a>

        <!-- Analytics -->
        <a href="{{ route('admin.analytics') }}"
           class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.analytics') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}">
            <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
            </svg>
            Analytics
        </a>
    </nav>

    <!-- User Info -->
    <div class="flex shrink-0 border-t border-indigo-800 p-4">
        <div class="flex items-center">
            <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-indigo-300">Administrador</p>
            </div>
        </div>
    </div>
</div>
