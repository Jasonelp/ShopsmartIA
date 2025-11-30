<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;

class AiService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://openrouter.ai/api/v1';

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.api_key', env('OPENROUTER_API_KEY', ''));
        $this->model = config('services.openrouter.model', env('AI_MODEL', 'google/gemini-2.0-flash-exp:free'));
    }

    /**
     * 💬 Envía un mensaje al modelo de IA con reintentos automáticos
     */
    public function chat(array $messages, bool $includeProducts = true): string
    {
        $systemPrompt = $this->buildSystemPrompt($includeProducts);

        $formattedMessages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($messages as $message) {
            $formattedMessages[] = [
                'role' => $message['role'],
                'content' => $message['content'],
            ];
        }

        // 🔄 REINTENTOS AUTOMÁTICOS (máximo 3 intentos)
        $maxRetries = 3;
        $attempt = 0;

        while ($attempt < $maxRetries) {
            try {
                $response = Http::timeout(30)
                    ->withoutVerifying() // Fix para SSL en Windows local
                    ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => config('app.url', 'http://localhost'),
                    'X-Title' => 'ShopSmart IA',
                ])->post($this->baseUrl . '/chat/completions', [
                    'model' => $this->model,
                    'messages' => $formattedMessages,
                    'max_tokens' => 1000,
                    'temperature' => 0.7,
                ]);

                // ✅ Si la respuesta es exitosa, retornar
                if ($response->successful()) {
                    $data = $response->json();
                    return $data['choices'][0]['message']['content'] ?? 'No se pudo generar una respuesta.';
                }

                // ⚠️ Si hay rate limit (429), esperar y reintentar
                if ($response->status() === 429) {
                    $attempt++;
                    \Log::warning('Rate limit detectado en OpenRouter', [
                        'intento' => $attempt,
                        'max_intentos' => $maxRetries,
                    ]);

                    if ($attempt < $maxRetries) {
                        sleep(2); // Esperar 2 segundos antes de reintentar
                        continue;
                    }
                }

                // ❌ Otro tipo de error
                \Log::error('OpenRouter API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'intento' => $attempt + 1,
                ]);

                throw new \Exception('Error al comunicarse con OpenRouter: ' . $response->body());

            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // 🔌 Error de conexión, reintentar
                $attempt++;
                \Log::warning('Error de conexión con OpenRouter', [
                    'intento' => $attempt,
                    'error' => $e->getMessage(),
                ]);

                if ($attempt >= $maxRetries) {
                    throw new \Exception('No se pudo conectar con OpenRouter después de ' . $maxRetries . ' intentos: ' . $e->getMessage());
                }

                sleep(2); // Esperar antes de reintentar

            } catch (\Exception $e) {
                // ❌ Otro tipo de excepción
                $attempt++;

                if ($attempt >= $maxRetries) {
                    \Log::error('OpenRouter API Error después de ' . $maxRetries . ' intentos', [
                        'error' => $e->getMessage(),
                    ]);
                    throw $e;
                }

                sleep(2); // Esperar antes de reintentar
            }
        }

        throw new \Exception('No se pudo obtener respuesta de la IA después de ' . $maxRetries . ' intentos');
    }

    /**
     * 📝 Construye el prompt del sistema con contexto de productos
     */
    private function buildSystemPrompt(bool $includeProducts): string
    {
        $prompt = <<<PROMPT
Eres el asistente virtual de ShopSmart IA, una tienda en línea de tecnología.

🎯 TU OBJETIVO:
- Ayudar a los usuarios a encontrar productos perfectos para sus necesidades
- Responder preguntas sobre especificaciones técnicas
- Dar recomendaciones personalizadas basadas en presupuesto y uso
- Ser amable, conciso y útil

📋 REGLAS:
- Siempre responde en español
- Menciona precios en Soles (S/)
- Si recomiendas un producto, incluye su precio y características principales
- Si el usuario pide algo que no tenemos, sugiere alternativas disponibles
- Sé conversacional pero profesional
- Usa emojis ocasionalmente para hacer la conversación más amigable

PROMPT;

        if ($includeProducts) {
            $products = $this->getAvailableProducts();
            $categories = $this->getCategories();
            
            if ($categories->isNotEmpty()) {
                $prompt .= "\n\n🏷️ CATEGORÍAS DISPONIBLES:\n";
                foreach ($categories as $cat) {
                    $prompt .= "- {$cat->name} ({$cat->products_count} productos)\n";
                }
            }

            if ($products->isNotEmpty()) {
                $prices = $products->pluck('price');
                $minPrice = number_format($prices->min(), 2);
                $maxPrice = number_format($prices->max(), 2);
                
                $prompt .= "\n💰 RANGO DE PRECIOS: S/ {$minPrice} - S/ {$maxPrice}\n";
                $prompt .= "\n📦 CATÁLOGO DE PRODUCTOS:\n";
                
                foreach ($products as $product) {
                    $specs = '';
                    if ($product->specifications && is_array($product->specifications)) {
                        $specsArray = array_slice($product->specifications, 0, 4);
                        $specs = ' | Specs: ' . implode(', ', array_map(
                            fn($k, $v) => "$k: $v",
                            array_keys($specsArray),
                            $specsArray
                        ));
                    }
                    
                    $prompt .= sprintf(
                        "\n• [ID:%d] %s\n  Categoría: %s | Precio: S/ %.2f | Stock: %d%s\n  Descripción: %s\n",
                        $product->id,
                        $product->name,
                        $product->category->name ?? 'Sin categoría',
                        $product->price,
                        $product->stock,
                        $specs,
                        substr($product->description ?? '', 0, 100)
                    );
                }
                
                $prompt .= "\n\n✨ Usa esta información para dar recomendaciones precisas y personalizadas.";
            } else {
                $prompt .= "\n\n⚠️ Actualmente no hay productos disponibles. Informa al usuario amablemente.";
            }
        }

        return $prompt;
    }

    /**
     * 🏷️ Obtiene las categorías con conteo de productos
     */
    private function getCategories()
    {
        return \App\Models\Category::withCount(['products' => function($q) {
            $q->where('is_active', true)->where('stock', '>', 0);
        }])->get();
    }

    /**
     * 🛍️ Obtiene los productos disponibles en la tienda
     */
    private function getAvailableProducts()
    {
        return Product::with('category')
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->select('id', 'name', 'description', 'price', 'stock', 'category_id')
            ->limit(50)
            ->get();
    }
}
