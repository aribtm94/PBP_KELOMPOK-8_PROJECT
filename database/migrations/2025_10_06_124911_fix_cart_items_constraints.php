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
        // Since we can't drop the existing unique constraint easily due to foreign key dependencies,
        // let's work around it by allowing the current constraint and adding color/size handling at the application level
        
        // Just add the color and size columns if they don't exist
        if (!Schema::hasColumn('cart_items', 'color')) {
            Schema::table('cart_items', function (Blueprint $table) {
                $table->string('color')->nullable();
                $table->string('size')->nullable();
            });
        }
        
        // For now, we'll handle uniqueness at the application level in the CartController
        // The existing unique constraint will prevent same product in cart, 
        // but we'll modify the controller to update existing items instead of creating new ones
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['color', 'size']);
        });
    }
};
