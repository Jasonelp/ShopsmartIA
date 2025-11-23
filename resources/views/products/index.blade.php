@extends('layouts.public')

@section('title', 'Productos')

@section('content')
<div class="max-w-7xl mx-auto py-12 px-4 lg:px-0">
    
    <h1 class="text-3xl font-bold mb-6 text-gray-900">Productos Disponibles</h1>

    @if($products->isEmpty())
        <div class="text-center py-20">
            <h2 class="text-xl text-gray-600">No hay productos disponibles en este momento.</h2>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($products as $product)

            @php  
                $defaultImages = [
                    'Smartphones'  => 'https://i.imgur.com/VxbJX7p.jpeg',
                    'Computadoras' => 'https://i.imgur.com/2z8gR7f.jpeg',
                    'Cámaras'      => 'https://i.imgur.com/8W1zx7k.jpeg',
                    'Relojes'      => 'https://i.imgur.com/z8RB3aN.jpeg',
                    'Auriculares'  => 'https://i.imgur.com/Cp7iSmq.jpeg',
                    'Tablets'      => 'https://i.imgur.com/N3MksgM.jpeg',
                    'default'      => 'https://via.placeholder.com/600x600.png?text=Producto'
                ];

                $categoryName = $product->category->name ?? 'default';
                $img = $defaultImages[$categoryName] ?? $defaultImages['default'];
            @endphp

            <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 border border-gray-100">

                <img 
                    src="{{ $img }}" 
                    alt="{{ $product->name }}"
                    class="w-full h-48 object-cover rounded-lg mb-4"
                />

                <h3 class="font-semibold text-lg text-gray-900">
                    {{ $product->name }}
                </h3>

                <p class="text-gray-700 text-sm mt-1">
                    {{ Str::limit($product->description, 80) }}
                </p>

                <p class="text-green-600 font-bold text-xl mt-3">
                    S/ {{ number_format($product->price, 2) }}
                </p>

                <p class="text-gray-500 text-sm mt-1">
                    Stock: {{ $product->stock }}
                </p>

                <a 
                    href="{{ route('products.show', $product->id) }}"
                    class="mt-4 block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg text-center transition"
                >
                    Ver Detalles
                </a>

            </div>

        @endforeach

    </div>
</div>
@endsection
