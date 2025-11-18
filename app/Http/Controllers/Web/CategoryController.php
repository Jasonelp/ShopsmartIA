<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('web.categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->products()->paginate(12);

        return view('web.categories.show', compact('category', 'products'));
    }
}
