<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->take(8)
            ->get();

        $categories = Category::withCount('products')
            ->take(6)
            ->get();

        return view('web.home', compact('featuredProducts', 'categories'));
    }
}
