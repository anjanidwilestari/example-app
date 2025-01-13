<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductFeature;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory'])->get();
        return inertia('Products/Index', ['products' => $products]);
    }

    public function create()
    {
        $categories = ProductCategory::all();
        $subCategories = ProductSubCategory::all();
        return inertia('Products/Create', ['categories' => $categories, 'subCategories' => $subCategories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'required|exists:product_sub_categories,id',
        ]);

        $product = Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'subCategory']);
        return Inertia::render('Products/Show', [
            'product' => $product,
            'categories' => ProductCategory::all(),
            'subCategories' => ProductSubCategory::all(),
        ]);
    }
    

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        $subCategories = ProductSubCategory::all();
        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'sub_category_id' => 'required|exists:product_sub_categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index');
    }
}
