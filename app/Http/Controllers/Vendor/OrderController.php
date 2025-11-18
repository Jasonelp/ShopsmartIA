<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::whereHas('products', function ($q) {
            $q->where('products.user_id', Auth::id());
        })->with(['user', 'products'])->latest()->paginate(10);

        return view('vendor.orders.index', compact('orders'));
    }

    /**
     * Mark an order as delivered
     */
    public function markAsDelivered($id)
    {
        $order = Order::whereHas('products', function ($q) {
            $q->where('products.user_id', Auth::id());
        })->findOrFail($id);

        // Only allow marking as delivered if status is 'enviado'
        if (!in_array($order->status, ['enviado', 'confirmado', 'pendiente'])) {
            return redirect()->back()->with('error', 'Este pedido no puede ser marcado como entregado');
        }

        $order->update(['status' => 'entregado']);

        return redirect()->back()->with('success', 'Pedido marcado como entregado! El cliente ha sido notificado.');
    }

    /**
     * Update order status (for vendor)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmado,enviado,entregado'
        ]);

        $order = Order::whereHas('products', function ($q) {
            $q->where('products.user_id', Auth::id());
        })->findOrFail($id);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado del pedido actualizado');
    }
}
