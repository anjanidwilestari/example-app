<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\ProductFeature;
use App\Models\ProductSpecification;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'subCategory'])->get();
        $categories = ProductCategory::all();
        $subCategories = ProductSubCategory::all();

        return inertia('Products/Index', [
            'products' => $products,
            'categories' => $categories,
            'subCategories' => $subCategories,
        ]);
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
        $product = Product::with('features')->findOrFail($id);
        $categories = ProductCategory::all();
        $subCategories = ProductSubCategory::all();
        
        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => $categories,
            'subCategories' => $subCategories,
            'features' => $product->features,
            'galleries' => $product->galleries,
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
    
    public function addFeature(Request $request, $productId)
    {
        $validated = $request->validate([
            'feature' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $product = Product::findOrFail($productId);
        $product->features()->create($validated);
    
        // Return the updated features
        return redirect()->route('products.edit', $productId);
    }
    
    public function editFeature(Request $request, $productId, $featureId)
    {
        $validated = $request->validate([
            'feature' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $product = Product::findOrFail($productId);
        $feature = $product->features()->findOrFail($featureId);
        $feature->update($validated);
    
        // Return updated feature data
        return redirect()->route('products.edit', $productId);
    }
    
    public function deleteFeature($productId, $featureId)
    {
        $product = Product::findOrFail($productId);
        $feature = $product->features()->findOrFail($featureId);
        $feature->delete();
    
        // Return redirect or updated data
        return redirect()->route('products.edit', $productId);
    }
    
public function addGallery(Request $request, $productId)
{
    // Validate the image
    $validated = $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Generate a unique file name to prevent overwriting
    $fileName = time() . '-' . $request->file('image')->getClientOriginalName();

    // Store the uploaded image in the storage directory (public disk)
    $path = $request->file('image')->storeAs('public/product_images', $fileName);

    // Create a new gallery entry with the relative image path
    ProductGallery::create([
        'product_id' => $productId,
        'image_path' => 'storage/product_images/' . $fileName, // Save the relative path
    ]);

    // Redirect to the edit page for the product
    return redirect()->route('products.edit', $productId);
}
    
public function editGallery(Request $request, $productId, $galleryId)
{
    // Validate the image (optional)
    $validated = $request->validate([
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Find the gallery by product ID and gallery ID
    $gallery = ProductGallery::where('product_id', $productId)->findOrFail($galleryId);

    if ($request->hasFile('image')) {
        // Delete the old image from the storage directory
        $oldImagePath = storage_path('app/' . $gallery->image_path);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        // Generate a unique file name for the new image
        $fileName = time() . '-' . $request->file('image')->getClientOriginalName();

        // Store the new uploaded image in the storage directory
        $path = $request->file('image')->storeAs('public/product_images', $fileName);

        // Update the gallery entry with the new image path
        $gallery->update([
            'image_path' => 'storage/product_images/' . $fileName, // Update the relative path
        ]);
    }

    // Redirect to the edit page for the product
    return redirect()->route('products.edit', $productId);
}
public function deleteGallery($productId, $galleryId)
{
    // Fetch the gallery entry
    $gallery = ProductGallery::where('product_id', $productId)->findOrFail($galleryId);

    // Get the path to the image file
    $imagePath = storage_path('app/' . $gallery->image_path);

    // Check if the file exists and delete it
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the gallery entry from the database
    $gallery->delete();

    // Redirect to the edit page for the product
    return redirect()->route('products.edit', $productId);
}


}
