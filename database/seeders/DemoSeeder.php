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

        // Membuat kategori fashion sesuai dengan navbar
        $tshirts = Category::firstOrCreate(['name'=>'T-Shirts']);
        $shirts  = Category::firstOrCreate(['name'=>'Shirts']);
        $pants   = Category::firstOrCreate(['name'=>'Pants']);
        $outerwear = Category::firstOrCreate(['name'=>'Outerwear']);

        // Produk untuk setiap kategori
        Product::firstOrCreate(
            ['name'=>'Classic White T-Shirt'],
            ['category_id'=>$tshirts->id,'price'=>99000,'stock'=>25,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Graphic Print T-Shirt'],
            ['category_id'=>$tshirts->id,'price'=>129000,'stock'=>20,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Formal White Shirt'],
            ['category_id'=>$shirts->id,'price'=>179000,'stock'=>15,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Casual Linen Shirt'],
            ['category_id'=>$shirts->id,'price'=>199000,'stock'=>12,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Slim Fit Jeans'],
            ['category_id'=>$pants->id,'price'=>299000,'stock'=>18,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Chino Pants'],
            ['category_id'=>$pants->id,'price'=>249000,'stock'=>15,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Denim Jacket'],
            ['category_id'=>$outerwear->id,'price'=>399000,'stock'=>8,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Bomber Jacket'],
            ['category_id'=>$outerwear->id,'price'=>459000,'stock'=>10,'is_active'=>true]
        );
        
        // Additional products untuk variasi
        Product::firstOrCreate(
            ['name'=>'Vintage Band T-Shirt'],
            ['category_id'=>$tshirts->id,'price'=>149000,'stock'=>30,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Striped Long Sleeve Shirt'],
            ['category_id'=>$shirts->id,'price'=>219000,'stock'=>14,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Cargo Pants'],
            ['category_id'=>$pants->id,'price'=>329000,'stock'=>12,'is_active'=>true]
        );
        Product::firstOrCreate(
            ['name'=>'Winter Coat'],
            ['category_id'=>$outerwear->id,'price'=>599000,'stock'=>6,'is_active'=>true]
        );
    }
}
