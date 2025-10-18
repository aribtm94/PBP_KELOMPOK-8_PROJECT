<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin GayaKu',
            'email' => 'admin@butik.local',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $user = User::create([
            'name' => 'User Pembeli',
            'email' => 'user@butik.local',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $categories = Category::insert([
            ['name' => 'T-Shirts'],
            ['name' => 'Shirts'],
            ['name' => 'Pants'],
            ['name' => 'Outerwear'],
        ]);

        $products = [
            [
                'category_id' => 1,
                'name' => 'Kaos Polos Hitam',
                'description' => 'Kaos polos bahan katun combed 30s warna hitam ukuran L',
                'price' => 120000,
                'stock' => 20,
            ],
            [
                'category_id' => 2,
                'name' => 'Kemeja Putih Slim Fit',
                'description' => 'Kemeja putih bahan lembut model slim fit',
                'price' => 185000,
                'stock' => 15,
            ],
            [
                'category_id' => 3,
                'name' => 'Celana Chino Coklat',
                'description' => 'Celana chino bahan halus warna coklat muda',
                'price' => 220000,
                'stock' => 12,
            ],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => 1, 
            'qty' => 1,
        ]);
    }
}
