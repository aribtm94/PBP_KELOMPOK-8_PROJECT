<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total');
            $table->enum('status',['baru','diproses','dikirim','selesai','batal'])->default('baru');
            $table->string('receiver_name');
            $table->text('address_text');
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('price');   // snapshot saat beli
            $table->unsignedInteger('qty');
            $table->unsignedInteger('subtotal');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
