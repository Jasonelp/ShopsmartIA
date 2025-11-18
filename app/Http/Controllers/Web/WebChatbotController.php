<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WebChatbotController extends Controller
{
    private AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * 💬 Chat con IA desde el widget web
     * POST /ai/chat
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        try {
            // Crear historial simple para esta consulta
            $messages = [
                ['role' => 'user', 'content' => $userMessage]
            ];

            // Obtener respuesta de la IA con contexto de productos
            $aiResponse = $this->aiService->chat($messages, true);

            return response()->json([
                'success' => true,
                'reply' => $aiResponse,
            ]);

        } catch (\Exception $e) {
            \Log::error('WebChatbot Error', [
                'message' => $userMessage,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'reply' => 'Lo siento, hubo un problema al procesar tu mensaje. Por favor, intenta de nuevo.',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
