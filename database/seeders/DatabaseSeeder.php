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
            Product::updateOrCreate(
                ['name' => $p['name']],
                $p
            );
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $cart->items()->create([
            'product_id' => 1, 
            'qty' => 1,
        ]);
    }
}
