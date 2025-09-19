<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider {
    public function boot(): void {
        Gate::define('admin', fn(User $user) => $user->isAdmin());
    }
}
