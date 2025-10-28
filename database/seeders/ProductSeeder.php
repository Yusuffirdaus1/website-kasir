<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Indomie Goreng', 'price' => 3500, 'description' => 'Mie instan rasa goreng', 'image' => 'products/indomie-goreng.jpg', 'category' => 'Makanan', 'stock' => 100],
            ['name' => 'Coca Cola 330ml', 'price' => 7000, 'description' => 'Minuman bersoda', 'image' => 'products/coca-cola.jpg', 'category' => 'Minuman', 'stock' => 80],
            ['name' => 'Chitato 68g', 'price' => 9000, 'description' => 'Keripik kentang rasa BBQ', 'image' => 'products/chitato.jpg', 'category' => 'Makanan', 'stock' => 50],
            ['name' => 'Aqua Botol 600ml', 'price' => 5000, 'description' => 'Air mineral', 'image' => 'products/aqua.jpg', 'category' => 'Minuman', 'stock' => 200],
            ['name' => 'Sikat Gigi', 'price' => 12000, 'description' => 'Sikat gigi lembut', 'image' => 'products/sikat-gigi.jpg', 'category' => 'Perawatan', 'stock' => 40],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}
