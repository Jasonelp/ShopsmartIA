<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    private function getProductImage(string $productName): string
    {
        // Map product names to their local image files
        $imageMap = [
            'iPhone 15 Pro' => 'products/iphone_15_pro.png',
            'Samsung Galaxy S24' => 'products/samsung_galaxy_s24.png',
            'Xiaomi Redmi Note' => 'products/xiaomi_redmi_note.png',
            'Google Pixel 8' => 'products/google_pixel_8.png',
            'MacBook Pro 16' => 'products/macbook_pro_16.png',
            'Dell XPS 15' => 'products/dell_xps_15.png',
            'Lenovo ThinkPad' => 'products/lenovo_thinkpad.png',
            'ASUS ROG Zephyrus' => 'products/asus_rog_zephyrus.png',
            'Canon EOS R6' => 'products/canon_eos_r6.png',
            'Sony Alpha A7' => 'products/sony_alpha_a7.png',
            'Nikon Z8' => 'products/nikon_z8.png',
            'Apple Watch Series 9' => 'products/apple_watch_9.png',
            'Samsung Galaxy Watch' => 'products/samsung_galaxy_watch.png',
            'Garmin Fenix 7X' => 'products/garmin_fenix_7x.png',
            'AirPods Pro' => 'products/airpods_pro_2.png',
            'Sony WH-1000XM5' => 'products/sony_wh1000xm5.png',
            'Bose QuietComfort' => 'products/bose_quietcomfort.png',
            'iPad Pro 12.9' => 'products/ipad_pro_12.png',
            'Samsung Galaxy Tab S9' => 'products/samsung_tab_s9.png',
            'Microsoft Surface Pro 9' => 'products/surface_pro_9.png',
        ];

        foreach ($imageMap as $key => $image) {
            if (str_contains($productName, $key)) {
                return $image;
            }
        }

        return 'products/iphone_15_pro.png'; // Default fallback
    }

    public function run()
    {
        $products = [
            // Smartphones
            [
                'name' => 'iPhone 15 Pro - 256GB Titanio Natural',
                'description' => 'El smartphone más avanzado de Apple con chip A17 Pro y cámara de 48MP',
                'price' => 4899.00,
                'stock' => 25,
                'category_id' => 1,
                'user_id' => 2,
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra - 512GB',
                'description' => 'Potencia extrema con S Pen integrado y pantalla Dynamic AMOLED 2X',
                'price' => 4299.00,
                'stock' => 18,
                'category_id' => 1,
                'user_id' => 2,
            ],
            [
                'name' => 'Xiaomi Redmi Note 13 Pro - 256GB',
                'description' => 'Excelente relación calidad-precio con cámara de 200MP',
                'price' => 899.00,
                'stock' => 45,
                'category_id' => 1,
                'user_id' => 5,
            ],
            [
                'name' => 'Google Pixel 8 Pro - 128GB',
                'description' => 'Fotografía computacional de Google con IA avanzada',
                'price' => 3499.00,
                'stock' => 30,
                'category_id' => 1,
                'user_id' => 2,
            ],

            // Computadoras
            [
                'name' => 'MacBook Pro 16" M3 Pro',
                'description' => 'Rendimiento profesional para creativos y desarrolladores',
                'price' => 8999.00,
                'stock' => 12,
                'category_id' => 2,
                'user_id' => 2,
            ],
            [
                'name' => 'Dell XPS 15 - Intel i9',
                'description' => 'Laptop premium con pantalla OLED 4K',
                'price' => 6499.00,
                'stock' => 15,
                'category_id' => 2,
                'user_id' => 5,
            ],
            [
                'name' => 'Lenovo ThinkPad X1 Carbon',
                'description' => 'Ultraligera y perfecta para negocios',
                'price' => 5299.00,
                'stock' => 20,
                'category_id' => 2,
                'user_id' => 5,
            ],
            [
                'name' => 'ASUS ROG Zephyrus G14',
                'description' => 'Gaming portátil con AMD Ryzen 9 y RTX 4060',
                'price' => 4999.00,
                'stock' => 10,
                'category_id' => 2,
                'user_id' => 2,
            ],

            // Cámaras
            [
                'name' => 'Canon EOS R6 Mark II',
                'description' => 'Cámara mirrorless full-frame de 24MP',
                'price' => 9499.00,
                'stock' => 8,
                'category_id' => 3,
                'user_id' => 2,
            ],
            [
                'name' => 'Sony Alpha A7 IV',
                'description' => 'Versátil cámara híbrida para foto y video',
                'price' => 8999.00,
                'stock' => 10,
                'category_id' => 3,
                'user_id' => 5,
            ],
            [
                'name' => 'Nikon Z8',
                'description' => 'Cámara profesional con sensor de 45.7MP',
                'price' => 12999.00,
                'stock' => 5,
                'category_id' => 3,
                'user_id' => 2,
            ],

            // Relojes
            [
                'name' => 'Apple Watch Series 9 GPS',
                'description' => 'El reloj inteligente más popular del mundo',
                'price' => 1599.00,
                'stock' => 35,
                'category_id' => 4,
                'user_id' => 2,
            ],
            [
                'name' => 'Samsung Galaxy Watch 6 Classic',
                'description' => 'Elegancia y tecnología en tu muñeca',
                'price' => 1299.00,
                'stock' => 28,
                'category_id' => 4,
                'user_id' => 5,
            ],
            [
                'name' => 'Garmin Fenix 7X',
                'description' => 'Reloj deportivo premium con GPS multibanda',
                'price' => 2999.00,
                'stock' => 15,
                'category_id' => 4,
                'user_id' => 2,
            ],

            // Auriculares
            [
                'name' => 'AirPods Pro 2da Generación',
                'description' => 'Cancelación de ruido adaptativa y audio espacial',
                'price' => 899.00,
                'stock' => 50,
                'category_id' => 5,
                'user_id' => 2,
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Los mejores auriculares con cancelación de ruido',
                'price' => 1299.00,
                'stock' => 30,
                'category_id' => 5,
                'user_id' => 5,
            ],
            [
                'name' => 'Bose QuietComfort Ultra',
                'description' => 'Audio inmersivo con cancelación de ruido premium',
                'price' => 1499.00,
                'stock' => 25,
                'category_id' => 5,
                'user_id' => 2,
            ],

            // Tablets
            [
                'name' => 'iPad Pro 12.9" M2',
                'description' => 'La tablet más potente con chip M2',
                'price' => 4499.00,
                'stock' => 15,
                'category_id' => 6,
                'user_id' => 2,
            ],
            [
                'name' => 'Samsung Galaxy Tab S9 Ultra',
                'description' => 'Pantalla AMOLED gigante de 14.6 pulgadas',
                'price' => 3999.00,
                'stock' => 12,
                'category_id' => 6,
                'user_id' => 5,
            ],
            [
                'name' => 'Microsoft Surface Pro 9',
                'description' => 'Tablet 2 en 1 con Windows 11',
                'price' => 3299.00,
                'stock' => 18,
                'category_id' => 6,
                'user_id' => 2,
            ],
        ];

        foreach ($products as $index => $product) {
            $product['image'] = $this->getProductImage($product['name']);
            Product::create($product);
        }
    }
}
