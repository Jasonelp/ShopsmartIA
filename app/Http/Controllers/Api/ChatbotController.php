<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ChatbotMessage;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    private AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * 💬 CHAT CON IA - Conversación con historial
     * POST /api/v1/ai/chat
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'conversation_id' => 'nullable|integer|exists:conversations,id',
        ]);

        $user = $request->user();
        $userMessage = $request->input('message');
        $conversationId = $request->input('conversation_id');

        // Get or create conversation
        if ($conversationId) {
            $conversation = Conversation::where('id', $conversationId)
                ->where('user_id', $user->id)
                ->firstOrFail();
        } else {
            $conversation = Conversation::create([
                'user_id' => $user->id,
                'title' => substr($userMessage, 0, 50),
            ]);
        }

        // Save user message
        ChatbotMessage::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $userMessage,
        ]);

        // Get conversation history for context
        $history = $conversation->messages()
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($msg) => [
                'role' => $msg->role,
                'content' => $msg->content,
            ])
            ->toArray();

        try {
            // Get AI response
            $aiResponse = $this->aiService->chat($history, true);

            // Save assistant response
            ChatbotMessage::create([
                'conversation_id' => $conversation->id,
                'role' => 'assistant',
                'content' => $aiResponse,
            ]);

            return response()->json([
                'success' => true,
                'data' => [
                    'conversation_id' => $conversation->id,
                    'message' => $aiResponse,
                    'user' => $user->name,
                ],
            ]);
        } catch (\Exception $e) {
            \Log::error('Chatbot Error', [
                'user_id' => $user->id,
                'message' => $userMessage,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error al procesar el mensaje',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * 🔍 ANÁLISIS DE PRODUCTO CON IA
     * GET /api/v1/ai/product/{id}
     */
    public function productAnalysis($id): JsonResponse
    {
        try {
            $product = \App\Models\Product::with('category')->findOrFail($id);

            $prompt = sprintf(
                "Analiza este producto y dame una recomendación profesional:\n\n" .
                "📦 Nombre: %s\n" .
                "💰 Precio: S/ %.2f\n" .
                "🏷️ Categoría: %s\n" .
                "📝 Descripción: %s\n" .
                "📊 Stock: %d unidades\n\n" .
                "Por favor proporciona:\n" .
                "1. Ventajas del producto\n" .
                "2. Público objetivo ideal\n" .
                "3. Recomendación de compra",
                $product->name,
                $product->price,
                $product->category->name ?? 'Sin categoría',
                $product->description ?? 'Sin descripción',
                $product->stock
            );

            $messages = [
                ['role' => 'user', 'content' => $prompt]
            ];

            $analysis = $this->aiService->chat($messages, false);

            return response()->json([
                'success' => true,
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'category' => $product->category->name ?? 'Sin categoría',
                ],
                'analysis' => $analysis,
            ]);

        } catch (\Exception $e) {
            \Log::error('Product Analysis Error', [
                'product_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error al analizar el producto',
                'details' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * 📜 HISTORIAL DE CONVERSACIONES
     * GET /api/v1/ai/conversations
     */
    public function conversations(Request $request): JsonResponse
    {
        $user = $request->user();

        $conversations = Conversation::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn($conv) => [
                'id' => $conv->id,
                'title' => $conv->title,
                'created_at' => $conv->created_at,
                'updated_at' => $conv->updated_at,
            ]);

        return response()->json([
            'success' => true,
            'data' => $conversations,
        ]);
    }

    /**
     * 📖 MENSAJES DE UNA CONVERSACIÓN
     * GET /api/v1/ai/conversations/{conversationId}
     */
    public function history(Request $request, int $conversationId): JsonResponse
    {
        $user = $request->user();

        $conversation = Conversation::where('id', $conversationId)
            ->where('user_id', $user->id)
            ->with('messages')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => [
                'conversation' => [
                    'id' => $conversation->id,
                    'title' => $conversation->title,
                    'created_at' => $conversation->created_at,
                ],
                'messages' => $conversation->messages->map(fn($msg) => [
                    'id' => $msg->id,
                    'role' => $msg->role,
                    'content' => $msg->content,
                    'created_at' => $msg->created_at,
                ]),
            ],
        ]);
    }
}
