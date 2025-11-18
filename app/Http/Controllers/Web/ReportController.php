<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report (user or product)
     */
    public function store(Request $request)
    {
        $type = $request->input('type', 'user');

        if ($type === 'product') {
            return $this->storeProductReport($request);
        }

        return $this->storeUserReport($request);
    }

    /**
     * Store a user report
     */
    protected function storeUserReport(Request $request)
    {
        $validated = $request->validate([
            'reported_id' => 'required|exists:users,id',
            'order_id' => 'nullable|exists:orders,id',
            'reason' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
        ]);

        if ($validated['reported_id'] == Auth::id()) {
            return response()->json(['error' => 'No puedes reportarte a ti mismo'], 400);
        }

        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('reported_id', $validated['reported_id'])
            ->where('order_id', $validated['order_id'])
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return response()->json(['error' => 'Ya has reportado a este usuario por este pedido'], 400);
        }

        Report::create([
            'type' => 'user',
            'reporter_id' => Auth::id(),
            'reported_id' => $validated['reported_id'],
            'order_id' => $validated['order_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reporte enviado correctamente. Un administrador lo revisara pronto.'
        ]);
    }

    /**
     * Store a product report
     */
    protected function storeProductReport(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $existingReport = Report::where('reporter_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return response()->json(['error' => 'Ya has reportado este producto'], 400);
        }

        Report::create([
            'type' => 'product',
            'reporter_id' => Auth::id(),
            'reported_id' => $product->user_id,
            'product_id' => $validated['product_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reporte de producto enviado. Un administrador lo revisara pronto.'
        ]);
    }
}
