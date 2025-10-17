<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class BackupProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:products {--restore : Restore products from backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup or restore products data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('restore')) {
            return $this->restoreProducts();
        }

        return $this->backupProducts();
    }

    private function backupProducts()
    {
        $products = Product::with('category')->get()->map(function ($product) {
            return [
                'name' => $product->name,
                'category_name' => $product->category->name,
                'price' => $product->price,
                'stock' => $product->stock,
                'is_active' => $product->is_active,
                'created_at' => $product->created_at,
            ];
        });

        $filename = 'products_backup_' . now()->format('Y_m_d_H_i_s') . '.json';
        Storage::put($filename, json_encode($products, JSON_PRETTY_PRINT));

        $this->info("Products backed up to: storage/app/{$filename}");
        $this->info("Total products backed up: " . $products->count());

        return 0;
    }

    private function restoreProducts()
    {
        $files = Storage::files('.');
        $backupFiles = collect($files)->filter(function ($file) {
            return str_starts_with($file, 'products_backup_') && str_ends_with($file, '.json');
        })->sort()->reverse();

        if ($backupFiles->isEmpty()) {
            $this->error('No backup files found!');
            return 1;
        }

        $this->info('Available backup files:');
        $backupFiles->each(function ($file, $index) {
            $this->line("{$index}: {$file}");
        });

        $choice = $this->ask('Enter the number of the backup file to restore', '0');
        $selectedFile = $backupFiles->get($choice);

        if (!$selectedFile) {
            $this->error('Invalid selection!');
            return 1;
        }

        $products = json_decode(Storage::get($selectedFile), true);

        foreach ($products as $productData) {
            $category = \App\Models\Category::firstOrCreate(['name' => $productData['category_name']]);
            
            Product::firstOrCreate(
                ['name' => $productData['name']],
                [
                    'category_id' => $category->id,
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'is_active' => $productData['is_active'],
                ]
            );
        }

        $this->info("Products restored from: {$selectedFile}");
        $this->info("Total products restored: " . count($products));

        return 0;
    }
}
