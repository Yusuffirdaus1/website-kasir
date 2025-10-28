<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambahkan kolom 'role' ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom role setelah kolom email
            $table->string('role', 20)->default('pelanggan')->after('email');
            // (Opsional) tambahkan index biar query lebih cepat
            $table->index('role');
        });
    }

    /**
     * Rollback migrasi (hapus kolom role jika dibatalkan).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']); // hapus index
            $table->dropColumn('role');  // hapus kolom role
        });
    }
};
