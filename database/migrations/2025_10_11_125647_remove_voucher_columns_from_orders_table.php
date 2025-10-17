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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['voucher_code', 'discount_amount']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('voucher_code')->nullable();
            // Match the original type from 2025_09_19_182244_add_voucher_to_orders_table
            $table->integer('discount_amount')->default(0);
            // subtotal was also added in that migration, but removed later by 2025_10_14_220753; we intentionally
            // do not re-add it here to avoid conflicting with later migrations.
        });
    }
};
