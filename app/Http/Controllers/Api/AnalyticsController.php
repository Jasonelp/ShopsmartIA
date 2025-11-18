<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * 📊 Dashboard general de analytics
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');

        return response()->json([
            'success' => true,
            'data' => [
                'total_users' => $totalUsers,
                'total_products' => $totalProducts,
                'total_orders' => $totalOrders,
                'total_revenue' => $totalRevenue,
            ],
        ]);
    }

    /**
     * 💰 Analytics de ventas
     */
    public function sales()
    {
        $salesByMonth = Order::where('status', 'completed')
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get();

        $salesByStatus = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'sales_by_month' => $salesByMonth,
                'sales_by_status' => $salesByStatus,
            ],
        ]);
    }

    /**
     * 📦 Analytics de productos
     */
    public function products()
    {
        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->limit(10)
            ->get();

        $productsByCategory = Product::select('category_id', DB::raw('COUNT(*) as count'))
            ->groupBy('category_id')
            ->with('category:id,name')
            ->get();

        $lowStock = Product::where('stock', '<', 10)
            ->where('is_active', true)
            ->select('id', 'name', 'stock', 'price')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'top_products' => $topProducts,
                'products_by_category' => $productsByCategory,
                'low_stock_products' => $lowStock,
            ],
        ]);
    }
}