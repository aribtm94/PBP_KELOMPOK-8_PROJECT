<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // pastikan kolom subtotal dihapus jika ada
            if (Schema::hasColumn('orders', 'subtotal')) {
                $table->dropColumn('subtotal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // tambahkan kembali jika dibutuhkan rollback
            $table->bigInteger('subtotal')->default(0);
        });
    }
};
