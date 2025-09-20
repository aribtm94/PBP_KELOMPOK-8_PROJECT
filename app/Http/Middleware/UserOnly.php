<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Jika sudah login dan role admin, tolak
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.products.index');
        }
        return $next($request);
    }
}
