<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ClientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $stats = [
            'total_orders' => Order::where('user_id', $user->id)->count(),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 'pendiente')->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 'entregado')->count(),
        ];

        return view('web.client.dashboard', compact('orders', 'stats'));
    }
}
