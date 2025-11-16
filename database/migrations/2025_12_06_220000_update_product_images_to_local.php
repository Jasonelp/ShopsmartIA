<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing products with local images
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

        foreach ($imageMap as $productKey => $imagePath) {
            DB::table('products')
                ->where('name', 'like', "%{$productKey}%")
                ->update(['image' => $imagePath]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to placeholder images if needed
    }
};
