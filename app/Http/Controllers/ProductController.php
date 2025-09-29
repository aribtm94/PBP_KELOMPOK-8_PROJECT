<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $r)
    {
        $q = Product::query()->with('category')->where('is_active', true);

        if ($r->filled('search')) {
            $term = (string) $r->string('search');
            $q->where('name', 'like', "%{$term}%");
        }
        if ($r->filled('category')) {
            $q->where('category_id', (int) $r->integer('category'));
        }

        $products   = $q->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $related = Product::where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->take(4)->get();

        return view('products.show', compact('product', 'related'));
    }

    // Method untuk kategori spesifik
    public function kemeja(Request $r)
    {
        return $this->getProductsByCategory('Kemeja', $r);
    }

    public function kaos(Request $r)
    {
        return $this->getProductsByCategory('Kaos', $r);
    }

    public function celana(Request $r)
    {
        return $this->getProductsByCategory('Celana', $r);
    }

    public function jaket(Request $r)
    {
        return $this->getProductsByCategory('Jaket', $r);
    }

    // Helper method untuk filtering berdasarkan kategori
    private function getProductsByCategory($categoryName, Request $r)
    {
        $category = Category::where('name', $categoryName)->firstOrFail();
        
        $q = Product::query()->with('category')->where('is_active', true)
                    ->where('category_id', $category->id);

        if ($r->filled('search')) {
            $term = (string) $r->string('search');
            $q->where('name', 'like', "%{$term}%");
        }

        $products = $q->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'))
               ->with('selectedCategory', $category);
    }
}
