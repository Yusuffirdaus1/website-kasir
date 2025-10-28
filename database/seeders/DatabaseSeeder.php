<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder untuk aplikasi.
     */
    public function run(): void
    {
        // Kamu bisa tambahkan seeder lain di sini juga kalau nanti perlu
        $this->call([
            UserSeeder::class, // Memanggil seeder user (admin & kasir)
            ProductSeeder::class, // Produk contoh
        ]);

        // Contoh tambahan (nanti kalau sudah ada)
        // $this->call(CategorySeeder::class);
        // $this->call(ProductSeeder::class);
    }
}
