@extends('admin.layouts.admin')

@section('title', 'Crear Producto')
@section('header', 'Crear Nuevo Producto')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Crear</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Form -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="px-4 py-6 sm:p-8">
            @csrf

            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <!-- Name -->
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">
                        Nombre del Producto <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('name') ring-red-500 @enderror">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="sm:col-span-2">
                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900">
                        Categoria <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <select name="category_id"
                                id="category_id"
                                required
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('category_id') ring-red-500 @enderror">
                            <option value="">Seleccionar categoria...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="sm:col-span-6">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">
                        Descripcion
                    </label>
                    <div class="mt-2">
                        <textarea name="description"
                                  id="description"
                                  rows="4"
                                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('description') ring-red-500 @enderror">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div class="sm:col-span-2">
                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">
                        Precio (S/) <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                            <span class="flex select-none items-center pl-3 text-gray-500 sm:text-sm">S/</span>
                            <input type="number"
                                   name="price"
                                   id="price"
                                   value="{{ old('price') }}"
                                   step="0.01"
                                   min="0"
                                   required
                                   class="block flex-1 border-0 bg-transparent py-1.5 pl-2 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6 @error('price') ring-red-500 @enderror">
                        </div>
                    </div>
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div class="sm:col-span-2">
                    <label for="stock" class="block text-sm font-medium leading-6 text-gray-900">
                        Stock <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-2">
                        <input type="number"
                               name="stock"
                               id="stock"
                               value="{{ old('stock', 0) }}"
                               min="0"
                               required
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('stock') ring-red-500 @enderror">
                    </div>
                    @error('stock')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="sm:col-span-2">
                    <label for="is_active" class="block text-sm font-medium leading-6 text-gray-900">
                        Estado
                    </label>
                    <div class="mt-2">
                        <select name="is_active"
                                id="is_active"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                </div>

                <!-- Image URL -->
                <div class="sm:col-span-3">
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-900">
                        URL de Imagen
                    </label>
                    <div class="mt-2">
                        <input type="url"
                               name="image"
                               id="image"
                               value="{{ old('image') }}"
                               placeholder="https://ejemplo.com/imagen.jpg"
                               class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 @error('image') ring-red-500 @enderror">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Ingresa la URL completa de la imagen</p>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image File Upload -->
                <div class="sm:col-span-3">
                    <label for="image_file" class="block text-sm font-medium leading-6 text-gray-900">
                        O Subir Imagen
                    </label>
                    <div class="mt-2">
                        <input type="file"
                               name="image_file"
                               id="image_file"
                               accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none @error('image_file') border-red-500 @enderror">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">JPG, PNG, GIF, WebP (max 2MB)</p>
                    @error('image_file')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.products.index') }}"
                   class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                    Cancelar
                </a>
                <button type="submit"
                        class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Crear Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
