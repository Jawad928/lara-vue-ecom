<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.products.index')
            ->with([
                'products' => Product::with(['colors', 'sizes', 'brand', 'category'])->latest()->get()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $brands = Brand::all();

        return view('admin.products.create')->with([
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddProductRequest $request)
    {
        //

        $data = $request->validated();


        $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
        $data['slug'] = Str::slug($request->name);
        if ($request->has('first_image')) {
            $data['first_image'] = $this->saveImage($request->file('first_image'));
        }
        if ($request->has('second_image')) {
            $data['second_image'] = $this->saveImage($request->file('second_image'));
        }
        if ($request->has('third_image')) {
            $data['third_image'] = $this->saveImage($request->file('third_image'));
        }

        $product = Product::create($data);

        $product->colors()->sync($request->color_id);
        $product->sizes()->sync($request->size_id);

        return redirect()->route('admin.products.index')->with([
            'success' => "Product Has Been Added Successfuly"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();
        $brands = Brand::all();

        return view('admin.products.edit')->with([
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes,
            'brands' => $brands,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
        $data = $request->validated();
        if ($request->thumbnail) {
            //remove old thumbnail
            $this->removeProductImageFromStorage($product->thumbnail);
            //add new image
            $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
        }
        if ($request->has('first_image')) {
            //remove old first_image
            $this->removeProductImageFromStorage($product->first_image);
            //add new image
            $data['first_image'] = $this->saveImage($request->file('first_image'));
        }
        if ($request->has('second_image')) {
            //remove old second_image
            $this->removeProductImageFromStorage($product->second_image);
            //add new image
            $data['second_image'] = $this->saveImage($request->file('second_image'));
        }
        if ($request->has('third_image')) {
            //remove old third_image
            $this->removeProductImageFromStorage($product->third_image);
            //add new image
            $data['third_image'] = $this->saveImage($request->file('third_image'));
        }
        $data['slug'] = Str::slug($request->name);

        $data['status'] = $request->status;

        $product->update($data);

        $product->colors()->sync($request->color_id);
        $product->sizes()->sync($request->size_id);

        return redirect()->route('admin.products.index')->with([
            'success' => "Product Has Been updated Successfuly"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
        $this->removeProductImageFromStorage($product->thumbnail);
        $this->removeProductImageFromStorage($product->first_image);
        $this->removeProductImageFromStorage($product->second_image);
        $this->removeProductImageFromStorage($product->third_image);

        $product->delete();
        return redirect()->route('admin.products.index')->with(['success' => 'Product has been Deleted successfully!']);
    }

    /**
     * To save Image in storage
     */
    public function saveImage($file)
    {
        if ($file) {
            $imgName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/products/', $imgName, 'public');
            return $imgName;
        }
    }

    /**
     * Remove old images from storage
     */
    public function removeProductImageFromStorage($file)
    {
        if ($file) { // Check if file is not null
            $path = 'images/products/' . $file;

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}
