<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\SubFooterController;
use App\Http\Controllers\IsiSubFooterController;
use App\Http\Controllers\TestimoniController;

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
});

require __DIR__.'/auth.php';
