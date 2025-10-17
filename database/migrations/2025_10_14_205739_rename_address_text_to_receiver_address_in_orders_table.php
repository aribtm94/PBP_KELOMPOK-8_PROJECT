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
        // Rename orders.address_text -> orders.receiver_address only if the source column exists
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'address_text') && !Schema::hasColumn('orders', 'receiver_address')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('address_text', 'receiver_address');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback rename if applicable
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'receiver_address') && !Schema::hasColumn('orders', 'address_text')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('receiver_address', 'address_text');
            });
        }
    }
};
