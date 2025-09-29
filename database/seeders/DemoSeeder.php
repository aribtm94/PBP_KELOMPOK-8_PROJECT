<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User,Cart,Category,Product};

class DemoSeeder extends Seeder {
    public function run(): void {
        $admin = User::firstOrCreate(
            ['email'=>'admin@gayakuid.local'],
            ['name'=>'Admin','password'=>Hash::make('password'),'role'=>'admin']
        );
        $user = User::firstOrCreate(
            ['email'=>'user@butik.local'],
            ['name'=>'Pembeli','password'=>Hash::make('password'),'role'=>'user']
        );
        Cart::firstOrCreate(['user_id'=>$user->id]);

        // Membuat kategori fashion
        $kemeja = Category::firstOrCreate(['name'=>'Kemeja']);
        $kaos   = Category::firstOrCreate(['name'=>'Kaos']);
        $celana = Category::firstOrCreate(['name'=>'Celana']);
        $jaket  = Category::firstOrCreate(['name'=>'Jaket']);

        // Produk untuk setiap kategori
        Product::firstOrCreate(
            ['name'=>'Kemeja Linen Putih'],
            ['category_id'=>$kemeja->id,'price'=>179000,'stock'=>10,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Kaos Graphic Hitam'],
            ['category_id'=>$kaos->id,'price'=>99000,'stock'=>25,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Celana Jeans Slim Fit'],
            ['category_id'=>$celana->id,'price'=>299000,'stock'=>15,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Jaket Denim Vintage'],
            ['category_id'=>$jaket->id,'price'=>399000,'stock'=>8,'is_active'=>true]
        );
    }
}
