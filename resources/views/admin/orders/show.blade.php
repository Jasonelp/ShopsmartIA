@extends('admin.layouts.admin')

@section('title', 'Detalle de Orden #' . $order->id)

@section('header')
    <div class="flex items-center justify-between">
        <span>Orden #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
            Volver a ordenes
        </a>
    </div>
@endsection

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informacion de la Orden -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Informacion de la Orden</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cliente</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <div class="font-semibold">{{ $order->user->name }}</div>
                                <div class="text-gray-500">{{ $order->user->email }}</div>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Fecha de Orden</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1">
                                @php
                                    $statusColors = [
                                        'pendiente' => 'bg-yellow-100 text-yellow-800',
                                        'confirmado' => 'bg-blue-100 text-blue-800',
                                        'enviado' => 'bg-purple-100 text-purple-800',
                                        'entregado' => 'bg-green-100 text-green-800',
                                        'cancelado' => 'bg-red-100 text-red-800',
                                    ];
                                    $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900">S/ {{ number_format($order->total, 2) }}</dd>
                        </div>
                    </dl>

                    @if($order->shipping_address)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Direccion de Envio</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                        </div>
                    @endif

                    @if($order->notes)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Notas</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $order->notes }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Productos -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Productos Ordenados</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Producto
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Precio Unit.
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->products as $product)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 rounded bg-gray-100 flex items-center justify-center">
                                                @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 rounded object-cover">
                                                @else
                                                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        S/ {{ number_format($product->pivot->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                        S/ {{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-sm font-medium text-gray-900 text-right">
                                    Total:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900 text-right">
                                    S/ {{ number_format($order->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Columna Lateral -->
        <div class="space-y-6">
            <!-- Cambiar Estado -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Cambiar Estado</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Nuevo Estado</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="pendiente" {{ $order->status === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ $order->status === 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="enviado" {{ $order->status === 'enviado' ? 'selected' : '' }}>Enviado</option>
                                    <option value="entregado" {{ $order->status === 'entregado' ? 'selected' : '' }}>Entregado</option>
                                    <option value="cancelado" {{ $order->status === 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                            </div>

                            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Actualizar Estado
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Resumen -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Resumen</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <dl class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-500">Productos</dt>
                            <dd class="font-medium text-gray-900">{{ $order->products->count() }}</dd>
                        </div>
                        <div class="flex justify-between text-sm">
                            <dt class="text-gray-500">Items Totales</dt>
                            <dd class="font-medium text-gray-900">{{ $order->products->sum('pivot.quantity') }}</dd>
                        </div>
                        <div class="flex justify-between text-sm pt-3 border-t border-gray-200">
                            <dt class="font-medium text-gray-900">Total</dt>
                            <dd class="font-bold text-gray-900">S/ {{ number_format($order->total, 2) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
