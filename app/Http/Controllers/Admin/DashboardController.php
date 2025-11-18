<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ================================
        // ESTADÍSTICAS GENERALES
        // ================================
        $stats = [
            'total_users'       => User::count(),
            'total_clients'     => User::where('role', 'cliente')->count(),
            'total_vendors'     => User::where('role', 'vendedor')->count(),
            'total_admins'      => User::where('role', 'admin')->count(),

            'total_products'    => Product::count(),
            'active_products'   => Product::where('is_active', true)->count(),

            'total_orders'      => Order::count(),
            'total_categories'  => Category::count(),

            // 👇 Cambiado: antes usabas "pending"
            'pending_reports'   => Report::where('status', 'pendiente')->count(),
        ];

        // ================================
        // CONTEO DE ÓRDENES POR ESTADO (1 sola consulta)
        // ================================
        $orderStatusCounts = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        $stats['pending_orders']   = $orderStatusCounts['pendiente']  ?? 0;
        $stats['confirmed_orders'] = $orderStatusCounts['confirmado'] ?? 0;
        $stats['shipped_orders']   = $orderStatusCounts['enviado']    ?? 0;
        $stats['delivered_orders'] = $orderStatusCounts['entregado']  ?? 0;
        $stats['cancelled_orders'] = $orderStatusCounts['cancelado']  ?? 0;

        // ================================
        // VENTAS
        // ================================
        $stats['total_sales'] = Order::where('status', '!=', 'cancelado')->sum('total');

        $stats['monthly_sales'] = Order::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        $stats['today_sales'] = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelado')
            ->sum('total');

        $stats['today_orders'] = Order::whereDate('created_at', today())->count();

        // ================================
        // ORDENES RECIENTES
        // ================================
        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ================================
        // USUARIOS RECIENTES
        // ================================
        $recent_users = User::latest()
            ->take(5)
            ->get();

        // ================================
        // TOP PRODUCTOS MÁS VENDIDOS
        // ================================
        $topProducts = DB::table('products')
            ->select('products.id', 'products.name', 'products.price')
            ->selectRaw('SUM(order_product.quantity) as total_sold')
            ->selectRaw('SUM(order_product.quantity * order_product.price) as total_revenue')
            ->join('order_product', 'products.id', '=', 'order_product.product_id')
            ->join('orders', 'orders.id', '=', 'order_product.order_id')
            ->where('orders.status', '!=', 'cancelado')
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // ================================
        // STOCK
        // ================================
        $outOfStock = Product::where('stock', 0)->take(5)->get();
        $lowStock   = Product::whereBetween('stock', [1, 5])->take(5)->get();

        // ================================
        // VENTAS ÚLTIMOS 7 DÍAS
        // ================================
        $salesLast7Days = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->where('status', '!=', 'cancelado')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // COMPLETAR DÍAS SIN VENTAS
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = ucfirst(now()->subDays($i)->locale('es')->isoFormat('ddd'));

            $chartData[] = [
                'date'   => $date,
                'day'    => $dayName,
                'total'  => $salesLast7Days[$date]->total ?? 0,
                'orders' => $salesLast7Days[$date]->orders_count ?? 0,
            ];
        }

        // ================================
        // DISTRIBUCIÓN FINAL PARA LA VISTA
        // ================================
        $ordersByStatus = [
            'pendiente'  => $stats['pending_orders'],
            'confirmado' => $stats['confirmed_orders'],
            'enviado'    => $stats['shipped_orders'],
            'entregado'  => $stats['delivered_orders'],
            'cancelado'  => $stats['cancelled_orders'],
        ];

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'recent_users',
            'topProducts',
            'outOfStock',
            'lowStock',
            'chartData',
            'ordersByStatus'
        ));
    }
}
