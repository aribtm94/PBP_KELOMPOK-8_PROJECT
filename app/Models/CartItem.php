<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model {
    protected $fillable = ['user_id'];
    public function items(){ return $this->hasMany(CartItem::class); }
    public function total(): int {
        return $this->items->sum(fn($i)=>$i->qty * ($i->product->price ?? 0));
    }
}

class CartItem extends Model {
    protected $fillable = ['cart_id','product_id','qty'];
    public function cart(){ return $this->belongsTo(Cart::class); }
    public function product(){ return $this->belongsTo(Product::class); }
}
