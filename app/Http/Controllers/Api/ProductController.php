<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        // Logic to retrieve and return products
        return ProductResource::collection(
            Product::with(['category'])
                ->latest()
                ->get()
        )->additional([


            'categories' => Category::withCount('products')
                ->get(),
        ]);
    }

    /**
     * Fillter the products by category
     */
    public function filterProductByCategory(Category $category)
    {
        return ProductResource::collection($category->products()->with(['category'])->latest()->get())->additional([

            'categories' => Category::withCount('products')->get(),
            'filter' => $category->name
        ]);
    }

    /**
     * Fillter the products by term
     */
    public function filterProductByTerm($searchTerm)
    {
        return ProductResource::collection(Product::where('name', 'like', '%' . $searchTerm . '%')->with(['category',])->latest()->get())->additional([

            'categories' => Category::withCount('products')->get(),
        ]);
    }

    public function quickSearch(Request $request)
    {
        $q = $request->query('q');

        return Product::with('category')
            ->where('name', 'ILIKE', "%{$q}%")
            ->orWhere('sku', 'ILIKE', "%{$q}%")
            ->limit(6)
            ->get();
    }

    /**
     * Get recommended products (Best Selling)
     */
    public function recommended()
    {
        $products = Product::with(['category'])
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->select(
                'products.*',
                DB::raw('COUNT(order_product.id) as total_sold')
            )
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        return ProductResource::collection($products);
    }

    /**
     * Get products by id
     */
    public function show(Product $product)
    {

        return ProductResource::make($product->load(['category']));
    }
}
