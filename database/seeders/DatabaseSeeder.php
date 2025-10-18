<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@butik.local'],
            [
                'name' => 'Admin GayaKu',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@butik.local'],
            [
                'name' => 'User Pembeli',
                'password' => bcrypt('password'),
                'role' => 'user',
            ]
        );

        $categoryNames = ['T-Shirts','Shirts','Pants','Outerwear'];
        foreach ($categoryNames as $catName) {
            Category::firstOrCreate(['name' => $catName]);
        }

        $products = [
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(
                ['name' => $p['name']],
                $p
            );
        }

        // First run DemoSeeder to ensure demo products exist (DemoSeeder is idempotent)
        $this->call(DemoSeeder::class);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        // Find an existing product to add to the cart (avoid hard-coded id)
        $firstProduct = Product::first();
        if ($firstProduct) {
            // seed cart item idempotently (no duplicate product rows)
            // If cart_items table supports color/size columns, include them in the constraint.
            if (Schema::hasTable('cart_items') && Schema::hasColumn('cart_items', 'color') && Schema::hasColumn('cart_items', 'size')) {
                $cart->items()->updateOrCreate(
                    ['product_id' => $firstProduct->id, 'color' => null, 'size' => null],
                    ['qty' => 1]
                );
            } else {
                $cart->items()->updateOrCreate(
                    ['product_id' => $firstProduct->id],
                    ['qty' => 1]
                );
            }
        }
    }
}
