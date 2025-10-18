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
                'kemeja' => '/T-Shirts', 
                'kaos' => '/Shirts',
                't-shirt' => '/T-Shirts',
                'tshirt' => '/T-Shirts',
                'shirt' => '/Shirts',
                'shirts' => '/Shirts',
                'celana' => '/Pants',
                'pants' => '/Pants',
                'jaket' => '/Outerwear',
                'jacket' => '/Outerwear',
                'outerwear' => '/Outerwear'
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
                    'T-Shirts' => '/T-Shirts',
                    'Shirts' => '/Shirts',
                    'Pants' => '/Pants',
                    'Outerwear' => '/Outerwear'
                ];
                
                if (isset($categoryRoutes[$category->name])) {
                    // Preserve search parameter if provided
                    $params = $r->filled('search') ? ['search' => $r->string('search')] : [];
                    return redirect($categoryRoutes[$category->name])->with($params);
                }
            }
        }

        $q = Product::query()->with('category')->where('is_active', true);
        $sort = $r->query('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $q->orderBy('price');
                break;
            case 'price_desc':
                $q->orderByDesc('price');
                break;
            case 'name_asc':
                $q->orderBy('name');
                break;
            case 'name_desc':
                $q->orderByDesc('name');
                break;
            default:
                $q->latest();
        }
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
        return $this->getProductsByCategory('T-Shirts', $r, 'products.tshirts');
    }

    public function kaos(Request $r)
    {
        return $this->getProductsByCategory('Shirts', $r, 'products.shirts');
    }

    public function celana(Request $r)
    {
        return $this->getProductsByCategory('Pants', $r, 'products.pants');
    }

    public function jaket(Request $r)
    {
        return $this->getProductsByCategory('Outerwear', $r, 'products.outerwear');
    }

    public function shirt(Request $r)
    {
        // Redirect to /Shirts (kaos method)
        return redirect()->route('kaos');
    }

    public function pants(Request $r)
    {
        return $this->getProductsByCategory('Pants', $r, 'products.pants');
    }

    public function dress(Request $r)
    {
        // Dress category was removed, redirect to home
        return redirect()->route('home');
    }

    // Helper method untuk filtering berdasarkan kategori
    private function getProductsByCategory($categoryName, Request $r, $viewName = 'products.index')
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

        return view($viewName, compact('products', 'categories'))
               ->with('selectedCategory', $category);
    }
}
