<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Product, Category};
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
            'name'        => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image',
            'is_active'   => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        if ($r->hasFile('image')) {
            $data['image_path'] = $r->file('image')->store('products','public');
        }
        $data['is_active'] = $r->boolean('is_active');

        Product::create($data);
        return back()->with('success','Produk ditambahkan.');
    }

    public function update(Request $r, Product $product)
    {
        $data = $r->validate([
            'name'        => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image',
            'is_active'   => 'sometimes|boolean',
            'description' => 'nullable|string',
        ]);

        if ($r->hasFile('image')) {
            $data['image_path'] = $r->file('image')->store('products','public');
        }
        $data['is_active'] = $r->boolean('is_active');

        $product->update($data);
        return back()->with('success','Produk diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success','Produk dihapus.');
    }
}
