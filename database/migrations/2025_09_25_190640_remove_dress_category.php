<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Hapus produk yang terkait dengan kategori Dress
        $dressCategory = Category::where('name', 'Dress')->first();
        if ($dressCategory) {
            Product::where('category_id', $dressCategory->id)->delete();
            $dressCategory->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate dress category and product if needed for rollback
        $dress = Category::create(['name' => 'Dress']);
        Product::create([
            'name' => 'Dress Floral Casual',
            'category_id' => $dress->id,
            'price' => 259000,
            'stock' => 12,
            'is_active' => true
        ]);
    }
};
