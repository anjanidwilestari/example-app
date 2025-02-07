<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\ReasonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductSubCategoryController;
use App\Http\Controllers\ProductSpecificationController;
use App\Http\Controllers\ProductFeatureController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ContactElitechController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::get('/welcome', [SettingController::class, 'welcome'])->name('welcome'); // Tampilan Welcome User
Route::get('/product/{id}', [SettingController::class, 'productShow'])->name('productShow');
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Admin
    Route::get('/dashboard', [SettingController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard-edit', [SettingController::class, 'dashboardedit'])->name('dashboard.edit');
    Route::post('/save-settings', [SettingController::class, 'saveSettings'])->name('saveSettings');

    
    //Buku
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books-create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::post('/books/{book}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/{id}/audits', [BookController::class, 'audits'])->name('books.audits');

    Route::get('/books/{id}/latest-audit', [BookController::class, 'latestAudit']);
    Route::get('/books/{id}/audit-changes', [BookController::class, 'auditChanges']);
    Route::get('/books/{id}/history', [BookController::class, 'history'])->name('books.history');





    // Testimoni
    Route::get('/testimonis', [TestimoniController::class, 'index'])->name('testimonis.index');
    Route::get('/testimonis/{id}', [TestimoniController::class, 'show'])->name('testimonis.show');
    Route::get('/testimonis-create', [TestimoniController::class, 'create'])->name('testimonis.create');
    Route::post('/testimonis', [TestimoniController::class, 'store'])->name('testimonis.store');
    Route::get('/testimonis/{testimoni}/edit', [TestimoniController::class, 'edit'])->name('testimonis.edit');
    Route::post('/testimonis/{testimoni}', [TestimoniController::class, 'update'])->name('testimonis.update');
    Route::delete('/testimonis/{testimoni}', [TestimoniController::class, 'destroy'])->name('testimonis.destroy');

    //Footer
    Route::resource('footers', FooterController::class);
    Route::post('footers/{footer}/sub-footers', [FooterController::class, 'storeSubFooter'])->name('footers.storeSubFooter');
    Route::put('sub-footers/{subFooter}', [FooterController::class, 'updateSubFooter'])->name('subFooters.update');
    Route::delete('sub-footers/{subFooter}', [FooterController::class, 'destroySubFooter'])->name('subFooters.destroy');

    // Distributor
    Route::resource('distributors', DistributorController::class);

    // Reason
    Route::get('/reasons', [ReasonController::class, 'index'])->name('reasons.index');
    Route::get('/reasons/{id}', [ReasonController::class, 'show'])->name('reasons.show');
    Route::get('/reasons-create', [ReasonController::class, 'create'])->name('reasons.create');
    Route::post('/reasons', [ReasonController::class, 'store'])->name('reasons.store');
    Route::get('/reasons/{reason}/edit', [ReasonController::class, 'edit'])->name('reasons.edit');
    Route::post('/reasons/{reason}', [ReasonController::class, 'update'])->name('reasons.update');
    Route::delete('/reasons/{reason}', [ReasonController::class, 'destroy'])->name('reasons.destroy');

    Route::resource('products', ProductController::class);
    Route::resource('product_categories', ProductCategoryController::class);
    Route::resource('product_sub_categories', ProductSubCategoryController::class);
    Route::resource('product_features', ProductFeatureController::class);
    Route::resource('product_specifications', ProductSpecificationController::class);


    //Gallery
    Route::prefix('product-galleries')->group(function () {
        Route::get('{productId}', [ProductGalleryController::class, 'index'])->name('product_galleries.index');
        Route::get('{id}/show', [ProductGalleryController::class, 'show'])->name('product_galleries.show');
        Route::get('{productId}/create', [ProductGalleryController::class, 'create'])->name('product_galleries.create');
        Route::post('', [ProductGalleryController::class, 'store'])->name('product_galleries.store');
        Route::get('{id}/edit', [ProductGalleryController::class, 'edit'])->name('product_galleries.edit');
        Route::put('{id}', [ProductGalleryController::class, 'update'])->name('product_galleries.update');
        Route::delete('{id}', [ProductGalleryController::class, 'destroy'])->name('product_galleries.destroy');
    });

    Route::resource('contact_elitechs', ContactElitechController::class);
    Route::post('/products/{product}/add-feature', [ProductController::class, 'addFeature'])->name('products.add-feature');
    Route::patch('/products/{product}/edit-feature/{feature}', [ProductController::class, 'editFeature'])->name('products.edit-feature');
    Route::delete('/products/{product}/delete-feature/{feature}', [ProductController::class, 'deleteFeature'])->name('products.delete-feature');
    
    Route::post('/products/{product}/add-gallery', [ProductController::class, 'addGallery'])->name('products.add-gallery');
Route::patch('/products/{product}/edit-gallery/{gallery}', [ProductController::class, 'editGallery'])->name('products.edit-gallery');
Route::delete('/products/{product}/delete-gallery/{gallery}', [ProductController::class, 'deleteGallery'])->name('products.delete-gallery');

});

require __DIR__.'/auth.php';
