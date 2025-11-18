<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'reviews'])
            ->where('stock', '>', 0)
            ->withCount([
                'orders as total_sold' => function ($query) {
                    $query->select(\DB::raw('COALESCE(SUM(order_product.quantity), 0)'));
                }
            ])
            ->withAvg('reviews', 'rating');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Por defecto ordenar por mas vendidos
        $sortBy = $request->get('sort', 'best_sellers');
        $sortOrder = $request->get('order', 'desc');

        if ($sortBy === 'best_sellers') {
            $query->orderBy('total_sold', 'desc');
        } elseif (in_array($sortBy, ['name', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('web.products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        $reviews = collect();
        $reviewsCount = 0;
        $averageRating = 0;
        $canReview = false;

        if (Schema::hasTable('reviews')) {
            $reviews = $product->reviews()->with('user')->latest()->get();
            $reviewsCount = $reviews->count();
            $averageRating = $reviewsCount > 0 ? round($reviews->avg('rating'), 1) : 0;

            if (auth()->check()) {
                $canReview = auth()->user()->orders()
                    ->whereHas('products', function ($q) use ($product) {
                        $q->where('product_id', $product->id);
                    })
                    ->exists()
                    &&
                    !$product->reviews()->where('user_id', auth()->id())->exists();
            }
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('web.products.show', compact(
            'product',
            'reviews',
            'reviewsCount',
            'averageRating',
            'canReview',
            'relatedProducts'
        ));
    }
}
