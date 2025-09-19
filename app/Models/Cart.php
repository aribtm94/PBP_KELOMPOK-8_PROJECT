<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    // relasi: 1 cart punya banyak item
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    // helper total rupiah
    public function total(): int
    {
        return $this->items->sum(fn($i) => $i->qty * ($i->product->price ?? 0));
    }
}
