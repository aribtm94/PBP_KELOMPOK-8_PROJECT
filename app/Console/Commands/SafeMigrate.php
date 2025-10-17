<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SafeMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:safe {--fresh : Run fresh migration with backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations with automatic backup of important data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $this->info('🔄 Starting safe fresh migration...');
            
            // Backup products before fresh migration
            $this->info('📦 Backing up products...');
            Artisan::call('backup:products');
            $this->info(Artisan::output());

            // Confirm with user
            if (!$this->confirm('This will drop ALL tables. Continue?')) {
                $this->info('Migration cancelled.');
                return 0;
            }

            // Run fresh migration
            $this->info('🗄️ Running fresh migration...');
            Artisan::call('migrate:fresh', ['--seed' => true]);
            $this->info(Artisan::output());

            // Offer to restore products
            if ($this->confirm('Restore products from backup?')) {
                Artisan::call('backup:products', ['--restore' => true]);
                $this->info(Artisan::output());
            }

            $this->info('✅ Safe migration completed!');
        } else {
            // Regular migration
            $this->info('🔄 Running regular migration...');
            Artisan::call('migrate');
            $this->info(Artisan::output());
        }

        return 0;
    }
}
