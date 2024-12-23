<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Setting;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class SettingController extends Controller
{
// Halaman welcome untuk user
public function welcome()
{
    // Ambil setting global, bisa dengan nilai default
    $setting = Setting::first(); // Ambil setting pertama atau null jika tidak ada

    // Ambil ID buku yang telah dipilih
    $selectedBookId = $setting ? $setting->selected_book_id : null;

    // Jika ada buku yang dipilih, ambil datanya
    $currentBook = $selectedBookId ? Book::find($selectedBookId) : Book::first();

    return Inertia::render('WelcomeUser', [
        'books' => Book::all(),  // Ambil semua buku dari tabel books
        'currentBook' => $currentBook, // Buku yang dipilih
    ]);
}

// Halaman dashboard untuk admin
public function dashboard()
{
    // Mendapatkan user yang sedang login
    $user = auth()->user();

    // Ambil data setting terkait user
    $setting = $user->setting;

    // Ambil ID buku yang telah dipilih
    $selectedBookId = $setting ? $setting->selected_book_id : null;

    // Jika ada buku yang dipilih, ambil datanya
    $currentBook = $selectedBookId ? Book::find($selectedBookId) : Book::first(); // Default ke buku pertama

    return Inertia::render('Dashboard', [
        'books' => Book::all(),  // Ambil semua buku dari tabel books
        'currentBook' => $currentBook, // Buku yang dipilih
    ]);
}


    // Halaman edit dashboard untuk admin
public function dashboardedit(Request $request)
{
    // Mendapatkan user yang sedang login
    $user = auth()->user();

    // Ambil data setting terkait user
    $setting = $user->setting;

    // Ambil ID buku yang telah dipilih
    $selectedBookId = $setting ? $setting->selected_book_id : null;

    // Ambil semua buku untuk dropdown
    $books = Book::all();

    // Ambil buku yang dipilih (jika ada)
    $currentBook = $selectedBookId ? Book::find($selectedBookId) : null;

    return Inertia::render('DashboardEdit', [
        'books' => $books,  // Daftar buku
        'currentBook' => $currentBook, // Menampilkan buku yang dipilih
    ]);
}

    // Menyimpan pilihan buku yang dipilih
public function saveSelectedBook(Request $request)
{
    // Validasi input untuk memastikan ada book_id
    $request->validate([
        'book_id' => 'required|exists:books,id',
    ]);

    // Mendapatkan user yang sedang login
    $user = auth()->user();

    // Cari atau buat entri setting untuk user ini
    // Jika user sudah memiliki entri setting, kita update; jika belum, buat entri baru
    $setting = $user->setting ?? new Setting(); // Jika tidak ada, buat instance baru

    // Simpan ID buku yang dipilih dalam setting (baik untuk update maupun create)
    $setting->user_id = $user->id; // Pastikan user_id tersetting
    $setting->selected_book_id = $request->input('book_id'); // Set ID buku yang dipilih

    // Simpan entri setting ke database
    $setting->save();

    // Arahkan kembali ke halaman dashboard
    return redirect()->route('dashboard');
}


}
