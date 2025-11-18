<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'products'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Ventas totales (excluyendo canceladas)
        $total_sales = Order::where('status', '!=', 'cancelado')->sum('total');
        
        // Ventas del mes actual
        $monthly_sales = Order::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->where('status', '!=', 'cancelado')
            ->sum('total');
        
        // Ventas del día
        $daily_sales = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        // Ventas de los últimos 7 días
        $last_7_days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $total = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelado')
                ->sum('total');
            
            $last_7_days[] = [
                'date' => $date->toDateString(),
                'total' => $total ?? 0,
            ];
        }

        return view('admin.sales.index', compact(
            'orders', 
            'total_sales', 
            'monthly_sales',
            'daily_sales',
            'last_7_days'
        ));
    }
}
