<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
     $categories = Category::withCount('products')
        ->orderBy('id', 'DESC')
        ->paginate(10); // 🔥 ahora si funciona total(), links(), hasPages()

       return view('admin.categories.index', compact('categories'));
}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoria creada exitosamente.');
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoria actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Categoria eliminada exitosamente.');
    }
}
