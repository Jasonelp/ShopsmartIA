<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $my_products = Product::where('user_id', $user->id)->latest()->get();

        $my_orders = Order::whereHas('products', function ($q) use ($user) {
            $q->where('products.user_id', $user->id);
        })->with('user')->latest()->take(10)->get();

        $stats = [
            'my_products' => $my_products->count(),
            'pending_orders' => Order::whereHas('products', function ($q) use ($user) {
                $q->where('products.user_id', $user->id);
            })->where('status', 'pendiente')->count(),
        ];

        return view('vendor.dashboard', compact('stats', 'my_products', 'my_orders'));
    }
}
