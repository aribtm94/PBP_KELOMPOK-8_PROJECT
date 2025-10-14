<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ===== ORDERS TABLE =====
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_number', 50)->unique();
            $table->string('receiver_name', 100);
            $table->text('receiver_address');
            $table->string('receiver_phone', 20)->nullable();
            $table->string('payment_method', 50)->default('transfer');
            $table->string('status', 50)->default('baru');
            $table->bigInteger('total')->default(0);
            $table->timestamps();
        });

        // ===== ORDER ITEMS TABLE =====
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->bigInteger('price');
            $table->integer('qty');
            $table->bigInteger('subtotal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
