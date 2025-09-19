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

        $kemeja = Category::firstOrCreate(['name'=>'Kemeja']);
        $kaos   = Category::firstOrCreate(['name'=>'Kaos']);

        Product::create(['name'=>'Kemeja Linen Putih','category_id'=>$kemeja->id,'price'=>179000,'stock'=>10,'is_active'=>true]);
        Product::create(['name'=>'Kaos Graphic Hitam','category_id'=>$kaos->id,'price'=>99000,'stock'=>25,'is_active'=>true]);
    }
}
