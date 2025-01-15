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
        // Fetch the product along with related features and galleries
        $product = Product::with('features', 'galleries')->findOrFail($id);
    
        // Generate the full URL for each gallery image
        $product->galleries->map(function ($gallery) {
            $gallery->image_url = asset('storage/' . $gallery->image_path);
            return $gallery;
        });
    
        // Fetch categories and subcategories
        $categories = ProductCategory::all();
        $subCategories = ProductSubCategory::all();
    
        // Pass the data to the edit view
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
    // Validate the incoming request
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Store the uploaded image in the 'product_images' folder in the 'public' disk
    $imagePath = $request->file('image')->store('product_images', 'public');

    // Create a new gallery entry
    ProductGallery::create([
        'product_id' => $productId,
        'image_path' => $imagePath,  // Store the relative path
    ]);

    // Redirect back to the product edit page with success message
    return redirect()->route('products.edit', $productId);
}


    
public function editGallery(Request $request, $productId, $galleryId)
{
    // Validate the incoming request for a nullable image
    $request->validate([
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    // Find the gallery entry by product ID and gallery ID
    $gallery = ProductGallery::where('product_id', $productId)->findOrFail($galleryId);

    // If a new image is uploaded, process the image
    if ($request->hasFile('image')) {
        // Delete the old image from the public storage if exists
        $oldImagePath = storage_path('app/public/' . $gallery->image_path);
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }

        // Store the new uploaded image in 'product_images' folder in the public disk
        $imagePath = $request->file('image')->store('product_images', 'public');

        // Update the gallery entry with the new image path
        $gallery->update([
            'image_path' => $imagePath,  // Update the relative path
        ]);
    }

    // Redirect to the product edit page
    return redirect()->route('products.edit', $productId);
}
public function deleteGallery($productId, $galleryId)
{
    // Find the gallery entry by product ID and gallery ID
    $gallery = ProductGallery::where('product_id', $productId)->findOrFail($galleryId);

    // Get the path of the image to delete
    $imagePath = storage_path('app/public/' . $gallery->image_path);

    // Check if the image exists and delete it from the storage
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete the gallery entry from the database
    $gallery->delete();

    // Redirect back to the product edit page
    return redirect()->route('products.edit', $productId);
}


}
