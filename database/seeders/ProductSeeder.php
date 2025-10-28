<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Indomie Goreng', 'price' => 3500, 'description' => 'Mie instan rasa goreng', 'image' => null, 'category' => 'Makanan', 'stock' => 100],
            ['name' => 'Coca Cola 330ml', 'price' => 7000, 'description' => 'Minuman bersoda', 'image' => null, 'category' => 'Minuman', 'stock' => 80],
            ['name' => 'Chitato 68g', 'price' => 9000, 'description' => 'Keripik kentang rasa BBQ', 'image' => null, 'category' => 'Snack', 'stock' => 50],
            ['name' => 'Aqua Botol 600ml', 'price' => 5000, 'description' => 'Air mineral', 'image' => null, 'category' => 'Minuman', 'stock' => 200],
            ['name' => 'Sikat Gigi', 'price' => 12000, 'description' => 'Sikat gigi lembut', 'image' => null, 'category' => 'Kebutuhan Rumah', 'stock' => 40],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}
