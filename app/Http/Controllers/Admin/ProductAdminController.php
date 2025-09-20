<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductAdminController extends Controller
{
    public function __construct() { $this->middleware(['auth','can:admin']); }

    public function index()
    {
        $products   = Product::with('category')->latest()->paginate(20);
        $categories = Category::orderBy('name')->get();
        return view('admin.products.index', compact('products','categories'));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'nullable', // checkbox → di-handle manual
            'description' => 'nullable|string',
        ]);

        if ($r->hasFile('image')) {
            $data['image_path'] = $r->file('image')->store('products','public');
        }

        $data['is_active'] = $r->boolean('is_active'); // true/false
        unset($data['image']); // jangan ikut mass-assign

        Product::create($data);

        return back()->with('success','Produk ditambahkan.');
    }

    public function update(Request $r, Product $product)
    {
        $data = $r->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'nullable',
            'description' => 'nullable|string',
        ]);

        if ($r->hasFile('image')) {
            $data['image_path'] = $r->file('image')->store('products','public');
        }
        $data['is_active'] = $r->boolean('is_active');
        unset($data['image']);

        $product->update($data);

        return back()->with('success','Produk diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Produk dihapus.');
    }
}
