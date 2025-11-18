<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Muestra los pedidos del cliente autenticado
     */
    public function myOrders()
    {
        $orders = Order::with('products')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('web.orders.my-orders', compact('orders'));
    }

    /**
     * Cancela una orden (solo si esta pendiente o confirmado)
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $user = Auth::user();

        // Verificar permisos
        if ($order->user_id !== $user->id) {
            abort(403, 'No autorizado para cancelar esta orden');
        }

        // Solo se puede cancelar si esta pendiente o confirmado
        if (!in_array($order->status, ['pendiente', 'confirmado'])) {
            return redirect()->back()->with('error', 'Solo se pueden cancelar ordenes pendientes o confirmadas');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Devolver stock
            foreach ($order->products as $product) {
                $product->increment('stock', $product->pivot->quantity);
            }

            // Marcar como cancelada con razon
            $order->update([
                'status' => 'cancelado',
                'cancellation_reason' => $validated['cancellation_reason'],
            ]);

            DB::commit();

            return redirect()->route('orders.my-orders')->with('success', 'Orden cancelada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al cancelar la orden');
        }
    }
}
