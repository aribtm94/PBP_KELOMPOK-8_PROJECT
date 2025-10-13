<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['user_id','total','subtotal','status','receiver_name','address_text','phone'];
    public function items(){ return $this->hasMany(OrderItem::class); }
    public function user(){ return $this->belongsTo(User::class); }

}

class OrderItem extends Model {
    protected $fillable = ['order_id','product_id','price','qty','subtotal','size'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function product(){ return $this->belongsTo(Product::class); }
}
