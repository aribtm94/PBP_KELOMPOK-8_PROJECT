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

        // NOTE: Removed automatic cart seeding to avoid pre-populating carts during development.
        // If you need to seed carts for testing, add an explicit CartSeeder or enable via an env flag.
    }
}
