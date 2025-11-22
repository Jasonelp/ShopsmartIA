@extends('admin.layouts.admin')

@section('title', 'Reporte #' . $report->id)

@section('header')
    <div class="flex items-center justify-between">
        <span>Reporte #{{ $report->id }}</span>
        <a href="{{ route('admin.reports.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
            Volver a reportes
        </a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles del Reporte -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informacion del Reporte</h3>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'reviewed' => 'bg-blue-100 text-blue-800',
                            'resolved' => 'bg-green-100 text-green-800',
                            'dismissed' => 'bg-gray-100 text-gray-800',
                        ];
                        $colorClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $colorClass }}">
                        {{ ucfirst($report->status) }}
                    </span>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de Reporte</dt>
                            <dd class="mt-1">
                                @if($report->type === 'product')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        Producto
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Usuario
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $report->created_at->format('d/m/Y H:i') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Reportador</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="font-semibold">{{ $report->reporter->name ?? 'N/A' }}</div>
                                <div class="text-gray-500">{{ $report->reporter->email ?? '' }}</div>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Reportado</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if($report->type === 'product' && $report->product)
                                    <div class="font-semibold">{{ $report->product->name }}</div>
                                    <div class="text-gray-500">Vendedor: {{ $report->product->user->name ?? 'N/A' }}</div>
                                    @if(!$report->product->is_active)
                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            PRODUCTO RETIRADO
                                        </span>
                                    @endif
                                @else
                                    <div class="font-semibold">{{ $report->reported->name ?? 'N/A' }}</div>
                                    <div class="text-gray-500">{{ $report->reported->email ?? '' }}</div>
                                    @if($report->reported && $report->reported->isSuspended())
                                        <span class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                            USUARIO SUSPENDIDO
                                        </span>
                                    @endif
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Razon del Reporte</dt>
                        <dd class="mt-2 text-sm text-gray-900">{{ $report->reason }}</dd>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <dt class="text-sm font-medium text-gray-500">Descripcion</dt>
                        <dd class="mt-2 text-sm text-gray-900 bg-gray-50 rounded-lg p-4">{{ $report->description ?? 'Sin descripcion' }}</dd>
                    </div>

                    @if($report->order)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Orden Relacionada</dt>
                            <dd class="mt-2">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-blue-900">Orden #{{ $report->order->id }}</p>
                                            <p class="text-sm text-blue-700">Total: S/ {{ number_format($report->order->total, 2) }}</p>
                                            <p class="text-sm text-blue-700">Estado: {{ ucfirst($report->order->status) }}</p>
                                        </div>
                                        <a href="{{ route('admin.orders.show', $report->order->id) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                            Ver orden
                                        </a>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    @endif

                    @if($report->reviewed_at)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Revisado</dt>
                            <dd class="mt-2 text-sm text-gray-900">
                                {{ $report->reviewed_at->format('d/m/Y H:i') }} por {{ $report->reviewer->name ?? 'Admin' }}
                            </dd>
                        </div>
                    @endif

                    @if($report->admin_notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Notas del Administrador</dt>
                            <dd class="mt-2 text-sm text-gray-900 bg-gray-50 rounded-lg p-4">{{ $report->admin_notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actualizar Estado -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Actualizar Estado del Reporte</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>Revisado</option>
                                    <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Resuelto</option>
                                    <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>Descartado</option>
                                </select>
                            </div>

                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700">Notas del Administrador</label>
                                <textarea name="admin_notes" id="admin_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Agregar notas internas...">{{ $report->admin_notes }}</textarea>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Columna Lateral -->
        <div class="space-y-6">
            <!-- Acciones -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Acciones</h3>
                </div>
                <div class="px-4 py-5 sm:p-6 space-y-3">
                    @if($report->type === 'user' && $report->reported)
                        @if($report->reported->isSuspended())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <p class="text-sm font-medium text-red-800">Usuario Suspendido</p>
                                <p class="text-xs text-red-600 mt-1">{{ $report->reported->suspension_reason }}</p>
                                <p class="text-xs text-red-500">Desde: {{ $report->reported->suspended_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <form action="{{ route('admin.users.unsuspend', $report->reported_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Levantar Suspension
                                </button>
                            </form>
                        @elseif($report->reported->role !== 'admin')
                            <form action="{{ route('admin.users.suspend', $report->reported_id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="suspension_reason" class="block text-sm font-medium text-gray-700">Motivo de Suspension</label>
                                    <textarea name="suspension_reason" id="suspension_reason" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="Describa el motivo..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Suspender Usuario
                                </button>
                            </form>
                        @else
                            <p class="text-sm text-gray-500">No se puede suspender a un administrador</p>
                        @endif
                    @elseif($report->type === 'product' && $report->product)
                        @if($report->product->is_active)
                            <form action="{{ route('admin.products.deactivate', $report->product->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="deactivation_reason" class="block text-sm font-medium text-gray-700">Motivo del Retiro</label>
                                    <textarea name="deactivation_reason" id="deactivation_reason" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="Describa el motivo..."></textarea>
                                </div>
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Retirar Producto
                                </button>
                            </form>
                        @else
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                                <p class="text-sm font-medium text-red-800">Producto Retirado</p>
                            </div>
                            <form action="{{ route('admin.products.reactivate', $report->product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Reactivar Producto
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Historial de Reportes Previos -->
            @if($previousReports->count() > 0)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Reportes Previos</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $previousReports->count() }} reporte(s) anteriores</p>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <ul class="space-y-3">
                            @foreach($previousReports as $prev)
                                <li class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $prev->reason }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Por {{ $prev->reporter->name ?? 'N/A' }}</p>
                                            <p class="text-xs text-gray-400">{{ $prev->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'reviewed' => 'bg-blue-100 text-blue-800',
                                                'resolved' => 'bg-green-100 text-green-800',
                                                'dismissed' => 'bg-gray-100 text-gray-800',
                                            ];
                                            $colorClass = $statusColors[$prev->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                            {{ ucfirst($prev->status) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
