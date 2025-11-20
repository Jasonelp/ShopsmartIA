<?php

use Illuminate\Support\Facades\Route;

// CONTROLADORES WEB (Publicos y Cliente)
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\ChatController;
use App\Http\Controllers\Web\ReportController;
use App\Http\Controllers\Web\ClientDashboardController;
use App\Http\Controllers\Web\WebChatbotController;

// CONTROLADORES ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SalesController as AdminSalesController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;

// CONTROLADORES VENDOR
use App\Http\Controllers\Vendor\DashboardController as VendorDashboardController;
use App\Http\Controllers\Vendor\ProductController as VendorProductController;
use App\Http\Controllers\Vendor\OrderController as VendorOrderController;

// CONTROLADOR COMPARTIDO
use App\Http\Controllers\Shared\ProfileController;

// ====================================
// RUTAS PUBLICAS
// ====================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/productos', [ProductController::class, 'index'])->name('products.public.index');
Route::get('/producto/{id}', [ProductController::class, 'show'])->name('products.public.show');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.public.index');
Route::get('/categoria/{id}', [CategoryController::class, 'show'])->name('categories.public.show');

// CHATBOT IA (público)
Route::post('/ai/chat', [WebChatbotController::class, 'chat'])->name('ai.chat');

// ====================================
// RUTAS AUTENTICADAS (CLIENTE / VENDEDOR / ADMIN)
// ====================================
Route::middleware(['auth', 'verified'])->group(function () {

    // DASHBOARD segun rol
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendedor' => redirect()->route('vendor.dashboard'),
            default => redirect()->route('client.dashboard'),
        };
    })->name('dashboard');

    // PERFIL (Compartido por todos los roles)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CARRITO
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

    // CHECKOUT
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/payment/process', [CheckoutController::class, 'processPayment'])->name('checkout.payment.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

    // MIS PEDIDOS (CLIENTE)
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my-orders');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // REVIEWS
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // CHAT
    Route::get('/chat/{order}', [ChatController::class, 'show'])->name('chat.show');
    Route::get('/chat/{order}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/{order}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread-count', [ChatController::class, 'unreadCount'])->name('chat.unread');

    // REPORTS (crear reportes - usuario)
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

// ====================================
// CLIENTE
// ====================================
Route::middleware(['auth'])->prefix('cliente')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
});

// ====================================
// VENDEDOR
// ====================================
Route::middleware(['auth', 'vendor'])->prefix('vendedor')->name('vendor.')->group(function () {
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/productos', [VendorProductController::class, 'index'])->name('products');
    Route::post('/productos', [VendorProductController::class, 'store'])->name('products.store');
    Route::put('/productos/{id}', [VendorProductController::class, 'update'])->name('products.update');
    Route::delete('/productos/{id}', [VendorProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/pedidos', [VendorOrderController::class, 'index'])->name('orders');
    Route::post('/pedidos/{id}/delivered', [VendorOrderController::class, 'markAsDelivered'])->name('orders.delivered');
    Route::patch('/pedidos/{id}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.status');
});

// ====================================
// ADMINISTRADOR
// ====================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Usuarios
    Route::get('/usuarios', [AdminUserController::class, 'index'])->name('users');
    Route::put('/usuarios/{id}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/usuarios/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Ventas
    Route::get('/ventas', [AdminSalesController::class, 'index'])->name('sales');

    // Analytics
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');

    // CRUDs del Admin - Productos
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [AdminProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // CRUDs del Admin - Categorias
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [AdminCategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // CRUDs del Admin - Ordenes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');

    // Reports Management
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{id}', [AdminReportController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{id}', [AdminReportController::class, 'update'])->name('reports.update');
    Route::post('/users/{id}/suspend', [AdminReportController::class, 'suspendUser'])->name('users.suspend');
    Route::post('/users/{id}/unsuspend', [AdminReportController::class, 'unsuspendUser'])->name('users.unsuspend');

    // Product Management (Deactivate/Reactivate)
    Route::post('/products/{id}/deactivate', [AdminReportController::class, 'deactivateProduct'])->name('products.deactivate');
    Route::post('/products/{id}/reactivate', [AdminReportController::class, 'reactivateProduct'])->name('products.reactivate');
});

require __DIR__ . '/auth.php';
