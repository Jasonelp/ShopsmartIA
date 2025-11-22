@extends('admin.layouts.admin')

@section('title', 'Detalle del Producto')
@section('header', 'Detalle del Producto')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Productos
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Actions -->
    <div class="flex justify-end gap-x-3">
        <a href="{{ route('admin.products.edit', $product->id) }}"
           class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
            <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Editar
        </a>
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Estas seguro de eliminar este producto?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
            </button>
        </form>
    </div>

    <!-- Product Details -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-4 py-6 sm:p-8">
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-2">
                <!-- Image -->
                <div>
                    @if($product->image)
                        <img src="{{ $product->image_url }}"
                             alt="{{ $product->name }}"
                             class="w-full h-96 object-cover rounded-lg border border-gray-300">
                    @else
                        <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <p class="mt-2 text-sm text-gray-500">ID: {{ $product->id }}</p>
                    </div>

                    <!-- Price -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Precio</dt>
                        <dd class="mt-1 text-4xl font-bold text-indigo-600">
                            S/ {{ number_format($product->price, 2) }}
                        </dd>
                    </div>

                    <!-- Stats Grid -->
                    <dl class="grid grid-cols-2 gap-4">
                        <div class="rounded-lg bg-gray-50 px-4 py-4 border border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Stock</dt>
                            <dd class="mt-1 text-2xl font-semibold text-gray-900">{{ $product->stock }} unidades</dd>
                        </div>
                        <div class="rounded-lg bg-gray-50 px-4 py-4 border border-gray-200">
                            <dt class="text-sm font-medium text-gray-500">Estado</dt>
                            <dd class="mt-1">
                                @if($product->is_active ?? true)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </dd>
                        </div>
                    </dl>

                    <!-- Category -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Categoria</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                {{ $product->category->name ?? 'Sin categoria' }}
                            </span>
                        </dd>
                    </div>

                    <!-- Description -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Descripcion</dt>
                        <dd class="mt-2 text-sm text-gray-900">
                            {{ $product->description ?? 'Sin descripcion' }}
                        </dd>
                    </div>

                    <!-- Dates -->
                    <div class="border-t border-gray-200 pt-4">
                        <dl class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-500">Creado:</dt>
                                <dd class="font-medium text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-500">Ultima actualizacion:</dt>
                                <dd class="font-medium text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info -->
    @if($product->user)
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Informacion del Vendedor</h3>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $product->user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $product->user->email }}</dd>
                </div>
            </dl>
        </div>
    </div>
    @endif
</div>
@endsection
