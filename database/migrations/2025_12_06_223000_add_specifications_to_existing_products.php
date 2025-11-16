<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Especificaciones técnicas para cada producto
        $specifications = [
            // Smartphones
            'iPhone 15 Pro' => [
                'Pantalla' => '6.1" Super Retina XDR OLED',
                'Procesador' => 'Apple A17 Pro',
                'RAM' => '8 GB',
                'Almacenamiento' => '256 GB',
                'Cámara Principal' => '48 MP + 12 MP + 12 MP',
                'Cámara Frontal' => '12 MP TrueDepth',
                'Batería' => '3274 mAh',
                'Sistema' => 'iOS 17',
                '5G' => 'Sí',
                'Face ID' => 'Sí',
            ],
            'Samsung Galaxy S24' => [
                'Pantalla' => '6.8" Dynamic AMOLED 2X QHD+',
                'Procesador' => 'Snapdragon 8 Gen 3',
                'RAM' => '12 GB',
                'Almacenamiento' => '512 GB',
                'Cámara Principal' => '200 MP + 12 MP + 50 MP + 10 MP',
                'Cámara Frontal' => '12 MP',
                'Batería' => '5000 mAh',
                'Sistema' => 'Android 14 + One UI 6.1',
                '5G' => 'Sí',
                'S Pen' => 'Incluido',
            ],
            'Xiaomi Redmi Note' => [
                'Pantalla' => '6.67" AMOLED 120Hz',
                'Procesador' => 'MediaTek Dimensity 7200',
                'RAM' => '8 GB',
                'Almacenamiento' => '256 GB',
                'Cámara Principal' => '200 MP + 8 MP + 2 MP',
                'Cámara Frontal' => '16 MP',
                'Batería' => '5100 mAh',
                'Sistema' => 'Android 13 + MIUI 14',
                '5G' => 'Sí',
                'Carga Rápida' => '67W',
            ],
            'Google Pixel 8' => [
                'Pantalla' => '6.7" LTPO OLED 120Hz',
                'Procesador' => 'Google Tensor G3',
                'RAM' => '12 GB',
                'Almacenamiento' => '128 GB',
                'Cámara Principal' => '50 MP + 48 MP',
                'Cámara Frontal' => '10.5 MP',
                'Batería' => '5050 mAh',
                'Sistema' => 'Android 14',
                '5G' => 'Sí',
                'IA Google' => 'Magic Eraser, Best Take',
            ],

            // Laptops
            'MacBook Pro 16' => [
                'Pantalla' => '16.2" Liquid Retina XDR',
                'Procesador' => 'Apple M3 Pro (12 núcleos)',
                'RAM' => '18 GB Unificada',
                'Almacenamiento' => '512 GB SSD',
                'GPU' => 'GPU 18 núcleos integrada',
                'Batería' => 'Hasta 22 horas',
                'Puertos' => '3x Thunderbolt 4, HDMI, SD, MagSafe',
                'Peso' => '2.14 kg',
                'Sistema' => 'macOS Sonoma',
            ],
            'Dell XPS 15' => [
                'Pantalla' => '15.6" OLED 4K Touch',
                'Procesador' => 'Intel Core i9-13900H',
                'RAM' => '32 GB DDR5',
                'Almacenamiento' => '1 TB NVMe SSD',
                'GPU' => 'NVIDIA GeForce RTX 4060',
                'Batería' => 'Hasta 13 horas',
                'Puertos' => '2x Thunderbolt 4, USB-C, SD',
                'Peso' => '1.86 kg',
                'Sistema' => 'Windows 11 Pro',
            ],
            'Lenovo ThinkPad' => [
                'Pantalla' => '14" 2.8K OLED',
                'Procesador' => 'Intel Core i7-1365U',
                'RAM' => '16 GB LPDDR5',
                'Almacenamiento' => '512 GB SSD',
                'GPU' => 'Intel Iris Xe',
                'Batería' => 'Hasta 15 horas',
                'Puertos' => '2x Thunderbolt 4, 2x USB-A, HDMI',
                'Peso' => '1.12 kg',
                'Sistema' => 'Windows 11 Pro',
                'Certificación' => 'MIL-STD-810H',
            ],
            'ASUS ROG Zephyrus' => [
                'Pantalla' => '14" QHD+ 165Hz',
                'Procesador' => 'AMD Ryzen 9 7940HS',
                'RAM' => '16 GB DDR5',
                'Almacenamiento' => '1 TB NVMe SSD',
                'GPU' => 'NVIDIA GeForce RTX 4060',
                'Batería' => 'Hasta 10 horas',
                'Teclado' => 'RGB per-key',
                'Peso' => '1.65 kg',
                'Sistema' => 'Windows 11',
                'Refrigeración' => 'ROG Intelligent Cooling',
            ],

            // Cámaras
            'Canon EOS R6' => [
                'Sensor' => 'Full Frame CMOS 24.2 MP',
                'Procesador' => 'DIGIC X',
                'ISO' => '100-102400 (expandible)',
                'Video' => '4K 60fps, Full HD 120fps',
                'Estabilización' => 'IBIS 8 pasos',
                'AF' => 'Dual Pixel CMOS AF II',
                'Pantalla' => '3" táctil articulada',
                'Ráfaga' => '40 fps electrónico',
                'Montura' => 'Canon RF',
            ],
            'Sony Alpha A7' => [
                'Sensor' => 'Full Frame Exmor R 33 MP',
                'Procesador' => 'BIONZ XR',
                'ISO' => '100-51200 (expandible)',
                'Video' => '4K 60fps, Full HD 120fps',
                'Estabilización' => 'IBIS 5.5 pasos',
                'AF' => '759 puntos fase + 425 contraste',
                'Pantalla' => '3" táctil abatible',
                'Ráfaga' => '10 fps',
                'Montura' => 'Sony E',
            ],
            'Nikon Z8' => [
                'Sensor' => 'Full Frame 45.7 MP',
                'Procesador' => 'EXPEED 7',
                'ISO' => '64-25600 (expandible)',
                'Video' => '8K 30fps, 4K 120fps',
                'Estabilización' => 'IBIS 6 pasos',
                'AF' => '493 puntos detección sujetos',
                'Pantalla' => '3.2" táctil articulada',
                'Ráfaga' => '20 fps RAW',
                'Montura' => 'Nikon Z',
            ],

            // Relojes
            'Apple Watch Series 9' => [
                'Pantalla' => '1.9" Retina OLED Always-On',
                'Procesador' => 'Apple S9 SiP',
                'Almacenamiento' => '64 GB',
                'Batería' => 'Hasta 18 horas',
                'Resistencia' => '50m agua (WR50)',
                'Sensores' => 'Oxígeno sangre, ECG, Temperatura',
                'GPS' => 'GPS + GLONASS',
                'Conectividad' => 'Bluetooth 5.3, Wi-Fi',
                'Material' => 'Aluminio',
            ],
            'Samsung Galaxy Watch' => [
                'Pantalla' => '1.5" Super AMOLED',
                'Procesador' => 'Exynos W930',
                'Almacenamiento' => '16 GB',
                'Batería' => 'Hasta 40 horas',
                'Resistencia' => '50m agua + IP68',
                'Sensores' => 'BioActive (ECG, presión, composición)',
                'GPS' => 'GPS dual',
                'Conectividad' => 'Bluetooth 5.2, Wi-Fi, LTE opcional',
                'Material' => 'Acero inoxidable + Bisel rotatorio',
            ],
            'Garmin Fenix 7X' => [
                'Pantalla' => '1.4" MIP transflectiva',
                'Batería' => 'Hasta 37 días smartwatch',
                'Resistencia' => '10 ATM',
                'GPS' => 'Multi-GNSS multibanda',
                'Mapas' => 'TopoActive + Ski',
                'Sensores' => 'Pulso, SpO2, altímetro, brújula',
                'Deportes' => '+60 apps deportivas',
                'Material' => 'Titanio + Cristal zafiro',
                'Linterna' => 'LED integrada',
            ],

            // Auriculares
            'AirPods Pro' => [
                'Driver' => 'Apple H2 chip',
                'ANC' => 'Cancelación activa adaptativa',
                'Modo' => 'Transparencia conversacional',
                'Audio' => 'Espacial personalizado',
                'Batería' => '6h (30h con estuche)',
                'Carga' => 'MagSafe, Qi, USB-C',
                'Resistencia' => 'IP54 (polvo y agua)',
                'Controles' => 'Táctil + Force Sensor',
            ],
            'Sony WH-1000XM5' => [
                'Driver' => '30mm con borde suave',
                'ANC' => '8 micrófonos + Auto NC Optimizer',
                'Procesador' => 'V1 + QN1',
                'Códecs' => 'LDAC, AAC, SBC',
                'Batería' => '30 horas con ANC',
                'Carga Rápida' => '3 min = 3 horas',
                'Peso' => '250 g',
                'Multipoint' => '2 dispositivos simultáneos',
                'Speak-to-Chat' => 'Pausa automática',
            ],
            'Bose QuietComfort' => [
                'Driver' => 'TriPort acústica',
                'ANC' => 'QuietMode con ajuste',
                'Audio' => 'Immersive Audio + EQ',
                'Batería' => '24 horas',
                'Carga Rápida' => '15 min = 2.5 horas',
                'Peso' => '250 g',
                'Multipoint' => 'Bluetooth 5.3',
                'CustomTune' => 'Calibración personalizada',
            ],

            // Tablets
            'iPad Pro 12.9' => [
                'Pantalla' => '12.9" Liquid Retina XDR',
                'Procesador' => 'Apple M2',
                'RAM' => '8 GB',
                'Almacenamiento' => '256 GB',
                'Cámaras' => '12 MP + 10 MP + LiDAR',
                'Face ID' => 'Sí',
                'Conectividad' => 'Wi-Fi 6E, 5G opcional',
                'Apple Pencil' => 'Compatible 2da gen',
                'Magic Keyboard' => 'Compatible',
            ],
            'Samsung Galaxy Tab S9' => [
                'Pantalla' => '14.6" Dynamic AMOLED 2X',
                'Procesador' => 'Snapdragon 8 Gen 2',
                'RAM' => '12 GB',
                'Almacenamiento' => '256 GB',
                'Cámaras' => '13 MP + 8 MP',
                'Batería' => '11200 mAh',
                'S Pen' => 'Incluido',
                'Resistencia' => 'IP68',
                'DeX' => 'Modo escritorio',
            ],
            'Microsoft Surface Pro 9' => [
                'Pantalla' => '13" PixelSense Flow 120Hz',
                'Procesador' => 'Intel Core i7-1255U',
                'RAM' => '16 GB LPDDR5',
                'Almacenamiento' => '256 GB SSD',
                'Cámaras' => '10 MP + 5 MP Windows Hello',
                'Batería' => 'Hasta 15.5 horas',
                'Puertos' => '2x USB-C Thunderbolt 4',
                'Surface Pen' => 'Compatible (se vende aparte)',
                'Sistema' => 'Windows 11',
            ],
        ];

        foreach ($specifications as $productKey => $specs) {
            DB::table('products')
                ->where('name', 'like', "%{$productKey}%")
                ->update(['specifications' => json_encode($specs)]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')->update(['specifications' => null]);
    }
};
