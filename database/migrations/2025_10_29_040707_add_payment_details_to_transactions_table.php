<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('invoice_number')->after('transaction_code')->nullable();
            $table->decimal('cash_amount', 15, 2)->after('total_amount')->default(0);
            $table->decimal('change_amount', 15, 2)->after('cash_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'cash_amount', 'change_amount']);
        });
    }
};
