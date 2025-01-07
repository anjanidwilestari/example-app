<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Seed Product Categories
        $categoryId = DB::table('product_categories')->insertGetId([
            'name' => 'Electronics',
            'description' => 'Electronic devices and gadgets',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Product Sub Categories
        $subCategoryId = DB::table('product_sub_categories')->insertGetId([
            'name' => 'Medical Devices',
            'description' => 'Devices used in medical fields',
            'category_id' => $categoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Products
        $productId = DB::table('products')->insertGetId([
            'name' => 'ECG-1200G',
            'description' => 'Electrocardiograph used for monitoring heart conditions.',
            'price' => 0,
            'category_id' => $categoryId,
            'sub_category_id' => $subCategoryId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Product Features
        DB::table('product_features')->insert([
            [
                'product_id' => $productId,
                'feature' => 'Portable and easy to use',
                'description' => 'Compact design, lightweight, and easy to carry.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'feature' => 'Accurate results',
                'description' => 'Provides quick and precise readings.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Product Specifications
        DB::table('product_specifications')->insert([
            [
                'product_id' => $productId,
                'specification' => 'Power',
                'description' => 'AC 220V, 50Hz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'specification' => 'Material',
                'description' => 'Plastic ABS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => $productId,
                'specification' => 'Range',
                'description' => '0-300 bpm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
