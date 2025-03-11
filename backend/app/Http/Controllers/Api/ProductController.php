<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;




class ProductController extends Controller
{
    /**
     * Get all products
     */
    public function index()
    {

        return ProductResource::collection(Product::with(['colors', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
            ]);
    }

    /**Product by slug */
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // we dont need to check "!$product" because laravel auto check the product and if not available then it will return 404
        // if (!$product) {
        //     abort(404);
        // }

        // Eager load relationships
        $product->load(['colors', 'reviews', 'sizes', 'brand', 'category']);

        // Return the single product wrapped in a resource
        return new ProductResource($product);
    }
    /**
     * Filter Product by Category
     */

    public function filterProductsByCategory(Category $category)
    {

        return ProductResource::collection($category->products()->with(['colors', 'reviews', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
                'filter' => $category->name
            ]);
    }
    /**
     * Filter Product by Brand
     */

    public function filterProductsByBrand(Brand $brand)
    {

        return ProductResource::collection($brand->products()->with(['colors', 'reviews', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
                'filter' => $brand->name
            ]);
    }
    /**
     * Filter Product by Color
     */

    public function filterProductsByColor(Color $color)
    {

        return ProductResource::collection($color->products()->with(['colors', 'reviews', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
                'filter' => $color->name
            ]);
    }
    /**
     * Filter Product by Size
     */

    public function filterProductsBySize(Size $size)
    {

        return ProductResource::collection($size->products()->with(['colors', 'reviews', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
                'filter' => $size->name
            ]);
    }
    /**
     * Filter Product by Search Term
     */

    public function filterProductsByTerm($searchterm)
    {

        return ProductResource::collection(Product::where('name', 'LIKE', '%' . $searchterm . '%')->with(['colors', 'reviews', 'sizes', 'brand', 'category'])
            ->latest()->get())
            ->additional([
                'colors' => Color::has('products')->get(),
                'sizes' => Size::has('products')->get(),
                'brands' => Brand::has('products')->get(),
                'categories' => Category::has('products')->get(),
            ]);
    }
}
