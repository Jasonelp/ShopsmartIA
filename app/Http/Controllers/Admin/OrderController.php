<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'products')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'products')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pendiente,confirmado,enviado,entregado,cancelado',
        ]);

        $order = Order::findOrFail($id);

        // Validar que no se retroceda el estado
        $estadosOrdenados = ['pendiente', 'confirmado', 'enviado', 'entregado'];
        $estadoActualIndex = array_search($order->status, $estadosOrdenados);
        $nuevoEstadoIndex = array_search($validated['status'], $estadosOrdenados);

        if ($nuevoEstadoIndex < $estadoActualIndex && $validated['status'] !== 'cancelado') {
            return redirect()->back()->with('error', 'No se puede retroceder el estado de la orden');
        }

        $order->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Estado actualizado exitosamente');
    }
}
