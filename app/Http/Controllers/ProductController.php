<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $r)
    {
        // Check if search term matches a category name and redirect
        if ($r->filled('search')) {
            $searchTerm = strtolower((string) $r->string('search'));
            
            // Map search terms to category routes
            $categoryMappings = [
                'shirt' => '/shirt',
                'kemeja' => '/kemeja', 
                'kaos' => '/kaos',
                't-shirt' => '/kaos',
                'tshirt' => '/kaos',
                'celana' => '/celana',
                'pants' => '/celana',
                'jaket' => '/jaket',
                'jacket' => '/jaket',
                'outerwear' => '/jaket'
            ];
            
            // Check if search term matches any category
            if (isset($categoryMappings[$searchTerm])) {
                return redirect($categoryMappings[$searchTerm])->with('search', $r->string('search'));
            }
        }
        
        // Check if category parameter is provided and redirect to specific category page
        if ($r->filled('category')) {
            $categoryId = (int) $r->integer('category');
            $category = Category::find($categoryId);
            
            if ($category) {
                // Map category names to routes
                $categoryRoutes = [
                    'Kemeja' => '/kemeja',
                    'Kaos' => '/kaos', 
                    'Celana' => '/celana',
                    'Jaket' => '/jaket',
                    'Shirt' => '/shirt',
                    'shirt' => '/shirt',
                    'SHIRT' => '/shirt'
                ];
                
                if (isset($categoryRoutes[$category->name])) {
                    // Preserve search parameter if provided
                    $params = $r->filled('search') ? ['search' => $r->string('search')] : [];
                    return redirect($categoryRoutes[$category->name])->with($params);
                }
            }
        }

        $q = Product::query()->with('category')->where('is_active', true);
        $showNoProductsPopup = false;

        if ($r->filled('search')) {
            $term = (string) $r->string('search');
            $searchResults = $q->where('name', 'like', "%{$term}%")->latest()->paginate(12)->withQueryString();
            
            // If search found no results, show popup but display all products
            if ($searchResults->count() === 0) {
                $showNoProductsPopup = true;
                // Reset query to show all products
                $q = Product::query()->with('category')->where('is_active', true);
                $products = $q->latest()->paginate(12);
            } else {
                $products = $searchResults;
            }
        } else {
            // No search, show all products normally
            if ($r->filled('category')) {
                $q->where('category_id', (int) $r->integer('category'));
            }
            $products = $q->latest()->paginate(12)->withQueryString();
        }

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'showNoProductsPopup'));
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

    public function shirt(Request $r)
    {
        // Try different variations of "shirt" category name
        $possibleNames = ['Shirt', 'shirt', 'SHIRT', 'Kemeja'];
        $category = null;
        
        foreach ($possibleNames as $name) {
            $category = Category::where('name', $name)->first();
            if ($category) break;
        }
        
        if (!$category) {
            // If no shirt category found, show debug info
            $categories = Category::all();
            $products = collect(); // empty collection
            return view('products.index', compact('products', 'categories'))
                   ->with('debugMessage', 'No Shirt category found. Available categories: ' . $categories->pluck('name')->join(', '));
        }
        
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
