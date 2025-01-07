<?php

namespace App\Http\Controllers;

use App\Models\ProductSubCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = ProductSubCategory::with('category')->get();
        return inertia('ProductSubCategories/Index', ['subCategories' => $subCategories]);
    }

    public function show($id)
    {
        $subCategory = ProductSubCategory::with('category')->findOrFail($id);
        return inertia('ProductSubCategories/Show', ['subCategory' => $subCategory]);
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return inertia('ProductSubCategories/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
        ]);
        ProductSubCategory::create($request->all());
        return redirect()->route('product_sub_categories.index');
    }

    public function edit($id)
    {
        $subCategory = ProductSubCategory::findOrFail($id);
        $categories = ProductCategory::all();
        return inertia('ProductSubCategories/Edit', ['subCategory' => $subCategory, 'categories' => $categories]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
        ]);
        $subCategory = ProductSubCategory::findOrFail($id);
        $subCategory->update($request->all());
        return redirect()->route('product_sub_categories.index');
    }

    public function destroy($id)
    {
        $subCategory = ProductSubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->route('product_sub_categories.index');
    }
}
