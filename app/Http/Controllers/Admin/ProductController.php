<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoria.',
            'image.url' => 'La URL de imagen debe ser una URL válida.',
        ]);

        // Manejar imagen: priorizar archivo subido sobre URL
        if ($request->hasFile('image_file')) {
            $validated['image'] = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image')) {
            // Si es una URL, guardarla directamente
            $validated['image'] = $request->input('image');
        }

        // Remover image_file del array validated
        unset($validated['image_file']);

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|url',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'category_id.required' => 'Debes seleccionar una categoria.',
            'image.url' => 'La URL de imagen debe ser una URL válida.',
        ]);

        $product = Product::findOrFail($id);

        // Manejar imagen: priorizar archivo subido sobre URL
        if ($request->hasFile('image_file')) {
            // Eliminar imagen anterior si existe y es local
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image_file')->store('products', 'public');
        } elseif ($request->filled('image')) {
            // Si es una URL, guardarla directamente
            // Eliminar imagen anterior si existe y es local
            if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->input('image');
        }

        // Remover image_file del array validated
        unset($validated['image_file']);

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->orders()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'No se puede eliminar: producto esta en ordenes.');
        }

        // Solo eliminar si es imagen local
        if ($product->image && !filter_var($product->image, FILTER_VALIDATE_URL) && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
