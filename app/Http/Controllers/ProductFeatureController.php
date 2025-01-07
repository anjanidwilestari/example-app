<?php

namespace App\Http\Controllers;

use App\Models\ProductFeature;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFeatureController extends Controller
{
    public function index()
    {
        $features = ProductFeature::all();
        return inertia('ProductFeatures/Index', ['features' => $features]);
    }

    public function show($id)
    {
        $feature = ProductFeature::with('product')->findOrFail($id); // Eager load 'product'
        $products = Product::all();
        return inertia('ProductFeatures/Show', ['feature' => $feature, 'products' => $products]);
    }



    public function create()
    {
        // Get all products to pass to the view
        $products = Product::all();
        
        // Return the view with the products
        return inertia('ProductFeatures/Create', ['products' => $products]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'feature' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ProductFeature::create($request->all());
        return redirect()->route('product_features.index');
    }

    public function edit($id)
    {
        $feature = ProductFeature::findOrFail($id);
        $products = Product::all();
        return inertia('ProductFeatures/Edit', ['feature' => $feature, 'products' => $products]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'feature' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $feature = ProductFeature::findOrFail($id);
        $feature->update($request->all());
        return redirect()->route('product_features.index');
    }

    public function destroy($id)
    {
        $feature = ProductFeature::findOrFail($id);
        $feature->delete();
        return redirect()->route('product_features.index');
    }
}
