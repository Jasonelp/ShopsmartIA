<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::all();

        return view('vendor.products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string|max:500',
        ]);

        $validated['user_id'] = Auth::id();

        Product::create($validated);

        return redirect()->route('vendor.products')->with('success', 'Producto creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|string|max:500',
        ]);

        $product->update($validated);

        return redirect()->route('vendor.products')->with('success', 'Producto actualizado');
    }

    public function destroy($id)
    {
        $product = Product::where('user_id', Auth::id())->findOrFail($id);
        $product->delete();

        return redirect()->route('vendor.products')->with('success', 'Producto eliminado');
    }
}
