<?php

namespace App\Http\Controllers;

use App\Models\ProductGallery;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    public function index($productId)
    {
        // Fetch all galleries related to a specific product
        $galleries = ProductGallery::where('product_id', $productId)->get()->map(function ($gallery) {
            $gallery->image_url = asset('storage/' . $gallery->image_path);
            return $gallery;
        });
        return inertia('ProductGalleries/Index', ['galleries' => $galleries, 'productId' => (int)$productId]);
    }

    public function show($id)
    {
        // Fetch a specific gallery entry
        $gallery = ProductGallery::with('product')->findOrFail($id);
        
        // Add the image_url to the gallery
        $gallery->image_url = asset('storage/' . $gallery->image_path);
        
        return inertia('ProductGalleries/Show', ['gallery' => $gallery]);
    }

    public function create($productId)
    {
        // Provide product ID for the gallery creation view
        $product = Product::findOrFail($productId);
        return inertia('ProductGalleries/Create', ['product' => $product]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'image_path' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Store the uploaded image
        $imagePath = $request->file('image_path')->store('product_images', 'public');

        // Create a new gallery entry
        ProductGallery::create([
            'product_id' => $request->product_id,
            'image_path' => $imagePath,
        ]);

        // Redirect back with success message
        return redirect()->route('product_galleries.index', ['productId' => $request->product_id]);
    }

    public function edit($id)
    {
        // Fetch the gallery entry to be edited
        $gallery = ProductGallery::findOrFail($id);
        
        // Add the image_url to the gallery
        $gallery->image_url = asset('storage/' . $gallery->image_path);
        
        return inertia('ProductGalleries/Edit', ['gallery' => $gallery]);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Find the gallery image
        $gallery = ProductGallery::findOrFail($id);

        // If a new image is uploaded, store it
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('product_images', 'public');
            $gallery->update(['image_path' => $imagePath]);
        }

        return redirect()->route('product_galleries.index', ['productId' => $gallery->product_id]);
    }

    public function destroy($id)
    {
        // Find and delete the gallery image
        $gallery = ProductGallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('product_galleries.index', ['productId' => $gallery->product_id]);
    }
}
