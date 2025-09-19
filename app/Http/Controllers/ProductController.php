<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller {
    public function index(Request $r) {
        $q = Product::query()->with('category')->where('is_active', true);
        if ($r->filled('search'))   $q->where('name','like',"%{$r->string('search')->toString()}%");
        if ($r->filled('category')) $q->where('category_id', $r->integer('category'));
        $products = $q->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        return view('products.index', compact('products','categories'));
    }

    public function show(Product $product) {
        abort_unless($product->is_active, 404);
        $related = Product::where('category_id',$product->category_id)
            ->whereKeyNot($product->id)->take(4)->get();
        return view('products.show', compact('product','related'));
    }
}
