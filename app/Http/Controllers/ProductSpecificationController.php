<?php

namespace App\Http\Controllers;

use App\Models\ProductSpecification;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    public function index()
    {
        $specifications = ProductSpecification::all();
        return inertia('ProductSpecifications/Index', ['specifications' => $specifications]);
    }

    public function show($id)
    {
        $specification = ProductSpecification::with('product')->findOrFail($id); // Eager load 'product'
        return inertia('ProductSpecifications/Show', ['specification' => $specification]);
    }

    public function create()
    {
        $products = Product::all();
        return inertia('ProductSpecifications/Create', ['products' => $products]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'specification' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ProductSpecification::create($request->all());
        return redirect()->route('product_specifications.index');
    }

    public function edit($id)
    {
        $specification = ProductSpecification::findOrFail($id);
        $products = Product::all();
        return inertia('ProductSpecifications/Edit', ['specification' => $specification, 'products' => $products]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'specification' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $specification = ProductSpecification::findOrFail($id);
        $specification->update($request->all());
        return redirect()->route('product_specifications.index');
    }

    public function destroy($id)
    {
        $specification = ProductSpecification::findOrFail($id);
        $specification->delete();
        return redirect()->route('product_specifications.index');
    }
}
