@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Ventas del Dia -->
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6">
            <dt>
                <div class="absolute rounded-md bg-green-500 p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Ventas Hoy</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">S/ {{ number_format($stats['today_sales'], 2) }}</p>
                <p class="ml-2 text-sm text-gray-500">({{ $stats['today_orders'] }} ordenes)</p>
            </dd>
        </div>

        <!-- Ventas del Mes -->
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6">
            <dt>
                <div class="absolute rounded-md bg-indigo-500 p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Ventas del Mes</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">S/ {{ number_format($stats['monthly_sales'], 2) }}</p>
            </dd>
        </div>

        <!-- Total Ordenes -->
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6">
            <dt>
                <div class="absolute rounded-md bg-yellow-500 p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Ordenes</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                @if($stats['pending_orders'] > 0)
                    <span class="ml-2 inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                        {{ $stats['pending_orders'] }} pendientes
                    </span>
                @endif
            </dd>
        </div>

        <!-- Total Usuarios -->
        <div class="relative overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:px-6">
            <dt>
                <div class="absolute rounded-md bg-purple-500 p-3">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Usuarios</p>
            </dt>
            <dd class="ml-16 flex items-baseline">
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
            </dd>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500">Productos</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_products'] }}</dd>
            <dd class="mt-1 text-sm text-gray-500">{{ $stats['active_products'] }} activos</dd>
        </div>
        <div class="rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500">Categorias</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_categories'] }}</dd>
        </div>
        <div class="rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500">Vendedores</dt>
            <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_vendors'] }}</dd>
        </div>
        <div class="rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="text-sm font-medium text-gray-500">Reportes Pendientes</dt>
            <dd class="mt-1 text-3xl font-semibold {{ $stats['pending_reports'] > 0 ? 'text-red-600' : 'text-gray-900' }}">
                {{ $stats['pending_reports'] }}
            </dd>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Sales Chart -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Ventas Ultimos 7 Dias</h3>
            </div>
            <div class="p-4">
                <div class="flex items-end justify-between h-64 gap-2">
                    @php
                        $maxTotal = max(array_column($chartData, 'total'));
                        $maxTotal = $maxTotal > 0 ? $maxTotal : 1;
                    @endphp
                    @foreach($chartData as $data)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-full flex flex-col items-center justify-end h-48">
                                @php
                                    $height = ($data['total'] / $maxTotal) * 100;
                                @endphp
                                <div class="w-full max-w-[40px] bg-indigo-500 rounded-t transition-all duration-300 hover:bg-indigo-600"
                                     style="height: {{ max($height, 2) }}%"
                                     title="S/ {{ number_format($data['total'], 2) }}">
                                </div>
                            </div>
                            <span class="mt-2 text-xs text-gray-500">{{ $data['day'] }}</span>
                            <span class="text-xs font-medium text-gray-700">S/ {{ number_format($data['total'], 0) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Orders by Status -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Estado de Ordenes</h3>
            </div>
            <div class="p-4">
                <div class="space-y-4">
                    @php
                        $totalOrders = array_sum($ordersByStatus);
                        $statusColors = [
                            'pendiente' => 'bg-yellow-500',
                            'confirmado' => 'bg-blue-500',
                            'enviado' => 'bg-purple-500',
                            'entregado' => 'bg-green-500',
                            'cancelado' => 'bg-red-500',
                        ];
                        $statusLabels = [
                            'pendiente' => 'Pendientes',
                            'confirmado' => 'Confirmados',
                            'enviado' => 'Enviados',
                            'entregado' => 'Entregados',
                            'cancelado' => 'Cancelados',
                        ];
                    @endphp
                    @foreach($ordersByStatus as $status => $count)
                        @php
                            $percentage = $totalOrders > 0 ? ($count / $totalOrders) * 100 : 0;
                        @endphp
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $statusLabels[$status] }}</span>
                                <span class="text-gray-500">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="{{ $statusColors[$status] }} h-2.5 rounded-full transition-all duration-300"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Orders -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Ordenes Recientes</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Ver todas</a>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    {{ $order->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    S/ {{ number_format($order->total, 2) }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'confirmado' => 'bg-blue-100 text-blue-800',
                                            'enviado' => 'bg-purple-100 text-purple-800',
                                            'entregado' => 'bg-green-100 text-green-800',
                                            'cancelado' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">No hay ordenes recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Usuarios Recientes</h3>
                <a href="{{ route('admin.users') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Ver todos</a>
            </div>
            <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                <span class="text-indigo-600 font-medium text-sm">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $roleClasses = [
                                            'admin' => 'bg-red-100 text-red-800',
                                            'vendedor' => 'bg-purple-100 text-purple-800',
                                            'cliente' => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleClasses[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">No hay usuarios recientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Products Row -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Top Products -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Top Productos</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($topProducts as $product)
                    <li class="px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $product->total_sold }} vendidos</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-green-600">S/ {{ number_format($product->total_revenue, 2) }}</p>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-gray-500">Sin datos de ventas</li>
                @endforelse
            </ul>
        </div>

        <!-- Out of Stock -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Sin Stock</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($outOfStock as $product)
                    <li class="px-4 py-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                Agotado
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-gray-500">Todos los productos tienen stock</li>
                @endforelse
            </ul>
        </div>

        <!-- Low Stock -->
        <div class="rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Stock Bajo</h3>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($lowStock as $product)
                    <li class="px-4 py-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $product->stock }} uds
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-8 text-center text-gray-500">Sin productos con bajo stock</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
