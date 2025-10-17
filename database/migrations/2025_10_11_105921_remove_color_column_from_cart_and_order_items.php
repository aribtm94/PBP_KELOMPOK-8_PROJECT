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
        // This migration was initially empty. Implement safe conditional drops for legacy 'color' columns.
        if (Schema::hasTable('cart_items') && Schema::hasColumn('cart_items', 'color')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->dropColumn('color');
            });
        }
        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'color')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('color');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add columns for rollback only if missing
        if (Schema::hasTable('cart_items') && !Schema::hasColumn('cart_items', 'color')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->string('color')->nullable();
            });
        }
        if (Schema::hasTable('order_items') && !Schema::hasColumn('order_items', 'color')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->string('color')->nullable();
            });
        }
    }
};
