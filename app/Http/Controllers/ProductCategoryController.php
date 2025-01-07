<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    // Display a listing of all product categories.
    public function index()
    {
        $categories = ProductCategory::all();
        return inertia('ProductCategories/Index', ['categories' => $categories]);
    }

    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return inertia('ProductCategories/Show', ['category' => $category]);
    }

    
    // Show the form for creating a new product category.
    public function create()
    {
        return inertia('ProductCategories/Create');
    }

    // Store a newly created product category in the database.
    public function store(Request $request)
    {
        // Validate the incoming request.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500', // Example of description validation
        ]);

        // Store the validated data into the database.
        ProductCategory::create($validated); // Pass the validated data

        // Return redirect with success message.
        return redirect()->route('product_categories.index')
            ->with('success', 'Product category created successfully.');
    }


    // Show the form for editing the specified product category.
    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return inertia('ProductCategories/Edit', ['category' => $category]);
    }

    // Update the specified product category in the database.
    public function update(Request $request, $id)
    {
        // Validate the incoming request.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        // Find and update the category.
        $category = ProductCategory::findOrFail($id);

        // Update the category with validated data
        $category->update($validated);

        // Return redirect with success message.
        return redirect()->route('product_categories.index')
            ->with('success', 'Product category updated successfully.');
    }


    // Remove the specified product category from the database.
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        // Check if the category is used by any products.
        if ($category->products()->count() > 0) {
            return redirect()->route('product_categories.index')->with('error', 'This category is in use and cannot be deleted.');
        }

        // Proceed with deleting the category if it's not in use.
        $category->delete();

        return redirect()->route('product_categories.index')->with('success', 'Product category deleted successfully.');
    }

}
