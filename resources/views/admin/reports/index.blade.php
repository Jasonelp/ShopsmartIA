@extends('admin.layouts.admin')

@section('title', 'Reportes')

@section('header', 'Gestion de Reportes')

@section('content')
    <!-- Filtros -->
    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.reports.index') }}"
           class="inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium {{ request('type') === null ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            Todos
            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ request('type') === null ? 'bg-indigo-700' : 'bg-gray-200 text-gray-800' }}">
                {{ $reports->total() }}
            </span>
        </a>
        <a href="{{ route('admin.reports.index', ['type' => 'user']) }}"
           class="inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium {{ request('type') === 'user' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            Usuarios
            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ request('type') === 'user' ? 'bg-indigo-700' : 'bg-gray-200 text-gray-800' }}">
                {{ $pendingUserReports ?? 0 }}
            </span>
        </a>
        <a href="{{ route('admin.reports.index', ['type' => 'product']) }}"
           class="inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium {{ request('type') === 'product' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            Productos
            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ request('type') === 'product' ? 'bg-indigo-700' : 'bg-gray-200 text-gray-800' }}">
                {{ $pendingProductReports ?? 0 }}
            </span>
        </a>
        <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}"
           class="inline-flex items-center px-4 py-2 border rounded-md text-sm font-medium {{ request('status') === 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
            Pendientes
            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ request('status') === 'pending' ? 'bg-yellow-600' : 'bg-gray-200 text-gray-800' }}">
                {{ $pendingCount ?? 0 }}
            </span>
        </a>
    </div>

    <!-- Tabla de Reportes -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reportador
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Reportado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Razon
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono font-medium text-gray-900">#{{ $report->id }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($report->type === 'product')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Producto
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Usuario
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $report->reporter->name ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500">{{ $report->reporter->email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($report->type === 'product' && $report->product)
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($report->product->name, 30) }}
                                        @if(!$report->product->is_active)
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                RETIRADO
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">Por: {{ $report->product->user->name ?? 'N/A' }}</div>
                                @else
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $report->reported->name ?? 'N/A' }}
                                        @if($report->reported && $report->reported->isSuspended())
                                            <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                SUSPENDIDO
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $report->reported->email ?? '' }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $report->reason }}</div>
                                @if($report->order_id)
                                    <div class="text-xs text-gray-500">Orden #{{ $report->order_id }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'reviewed' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-green-100 text-green-800',
                                        'dismissed' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $colorClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.reports.show', $report->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No hay reportes</h3>
                                <p class="mt-1 text-sm text-gray-500">No se encontraron reportes con los filtros aplicados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginacion -->
        @if($reports->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $reports->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
@endsection
