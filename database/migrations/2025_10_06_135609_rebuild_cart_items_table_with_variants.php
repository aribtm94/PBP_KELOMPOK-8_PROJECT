<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Backup existing data
        $existingItems = DB::table('cart_items')->get();
        
        // Drop the existing table
        Schema::dropIfExists('cart_items');
        
        // Recreate the table with proper structure
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->unsignedInteger('qty');
            $table->timestamps();
            
            // New unique constraint that includes color and size
            $table->unique(['cart_id', 'product_id', 'color', 'size'], 'cart_items_variant_unique');
        });
        
        // Restore the data but avoid inserting duplicates which would violate unique constraints.
        $seen = [];
        foreach ($existingItems as $item) {
            // Normalize nulls to empty string to build a stable key
            $color = $item->color ?? '';
            $size = $item->size ?? '';
            $key = implode('-', [$item->cart_id, $item->product_id, $color, $size]);
            if (isset($seen[$key])) {
                // skip duplicates
                continue;
            }
            $seen[$key] = true;

            try {
                DB::table('cart_items')->insert([
                    'id' => $item->id,
                    'cart_id' => $item->cart_id,
                    'product_id' => $item->product_id,
                    'color' => $item->color,
                    'size' => $item->size,
                    'qty' => $item->qty,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ]);
            } catch (\Exception $e) {
                // If an insert fails due to a constraint, skip and continue restoring remaining items
                // Useful for messy legacy data during migration.
                continue;
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Backup existing data
        $existingItems = DB::table('cart_items')->get();
        
        // Drop the new table
        Schema::dropIfExists('cart_items');
        
        // Recreate the old table structure
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('qty');
            $table->timestamps();

            $table->unique(['cart_id','product_id']);
        });
        
        // Restore the data (without color and size)
        foreach ($existingItems as $item) {
            DB::table('cart_items')->insert([
                'id' => $item->id,
                'cart_id' => $item->cart_id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ]);
        }
    }
};
