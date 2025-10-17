<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\{User,Cart,Category,Product};

class DemoSeeder extends Seeder {
    public function run(): void {
        // PERINGATAN: Seeder ini akan menambah data default
        // Jangan gunakan migrate:fresh jika ada data penting!
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


        // ==============================================================
        // Upload gambar produk seperti halaman admin
        // - Sumber file: public/images/Product/<FolderKategori>/*
        // - Disalin ke: storage/app/public/products/<FolderKategori>/<file>
        // - Disimpan ke DB: image_path = "products/<FolderKategori>/<file>"
        //   (persis seperti $request->file('image')->store('products','public'))
        // ==============================================================

        $folderMap = [
            'T-Shirt'   => 'T-Shirts',
            'Shirt'     => 'Shirts',
            'Pants'     => 'Pants',
            'Outerwear' => 'Outerwear',
        ];

        $sourceBase = public_path('images/Product');
        if (File::isDirectory($sourceBase)) {
            foreach ($folderMap as $srcFolder => $categoryName) {
                $category = Category::firstOrCreate(['name' => $categoryName]);
                $srcPath = $sourceBase . DIRECTORY_SEPARATOR . $srcFolder;
                if (!File::isDirectory($srcPath)) continue;

                $files = collect(File::files($srcPath))
                    ->filter(fn ($f) => in_array(strtolower($f->getExtension()), ['png','jpg','jpeg','webp']))
                    ->values();

                foreach ($files as $file) {
                    $filename   = $file->getFilename();
                    $nameBase   = pathinfo($filename, PATHINFO_FILENAME);

                    // Lewati file dengan nama generik seperti "Gambar1", "Gambar 2", "Gambar-3", dst.
                    if (preg_match('/^gambar[\s_-]*\d+$/i', $nameBase)) {
                        continue;
                    }
                    $productName = Str::of($nameBase)
                        ->replace(['_', '-'], ' ')
                        ->replace(['(', ')'], '')
                        ->squish()
                        ->title();

                    // Tujuan di disk 'public', mirip ->store('products','public')
                    $relativeDir = 'products/'.$srcFolder;
                    $relativePath = $relativeDir.'/'.$filename; // disimpan ke kolom image_path

                    // Pastikan direktori ada, lalu copy jika belum ada
                    Storage::disk('public')->makeDirectory($relativeDir);
                    if (!Storage::disk('public')->exists($relativePath)) {
                        Storage::disk('public')->put($relativePath, File::get($file->getRealPath()));
                    }

                    // Buat / perbarui produk agar image_path terisi
                    Product::updateOrCreate(
                        [
                            'name' => (string) $productName,
                            'category_id' => $category->id,
                        ],
                        [
                            'price' => $this->guessPriceFromName((string) $productName),
                            'stock' => rand(8, 30),
                            'is_active' => true,
                            'image_path' => $relativePath, // persis seperti admin upload
                            'description' => $this->generateDescription((string) $productName, $categoryName),
                        ]
                    );
                }
            }
        }
    }

    private function guessPriceFromName(string $name): int
    {
        $buckets = [99000, 129000, 179000, 199000, 249000, 299000, 329000, 399000, 459000, 599000];
        $hash = crc32(strtolower($name));
        return $buckets[$hash % count($buckets)];
    }

    private function generateDescription(string $name, string $category): string
    {
        $templates = [
            'Pilihan %name% untuk kategori %category% dengan material nyaman dan mudah dipadukan untuk aktivitas harian.',
            '%name% menghadirkan gaya kasual yang rapi. Cocok untuk outfit sehari-hari maupun semi-formal.',
            'Produk %category%: %name% dibuat dari bahan berkualitas, potongan modern, dan detail yang fungsional.',
            '%name%—tampilan simpel namun stylish. Ringan, adem, dan siap menemani kegiatanmu.',
        ];
        $tpl = $templates[crc32(strtolower($name.$category)) % count($templates)];
        return str_replace(['%name%','%category%'], [$name, $category], $tpl);
    }
}
