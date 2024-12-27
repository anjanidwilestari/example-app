<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Footer;
use App\Models\Setting;
use App\Models\Testimoni;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class SettingController extends Controller
{
    // Halaman welcome untuk user
    // Halaman welcome untuk user (tidak memerlukan login) 
    // Halaman welcome untuk publik
    public function welcome()
    {
        // Ambil pengaturan global (ambil record pertama dari tabel settings)
        $setting = Setting::first();
    
        // Ambil data buku dan testimoni berdasarkan pengaturan yang disimpan
        $currentBook = null;
        $selectedTestimonis = [];

        // Mengambil data footer beserta sub-footers
        $footers = Footer::with('subFooters')->get();

        if ($setting) {
            $currentBook = Book::find($setting->selected_book_id);
            $selectedTestimonis = Testimoni::whereIn('id', json_decode($setting->selected_testimoni_ids))->get();
        }
    
        // Kirim data ke tampilan
        return Inertia::render('WelcomeUser', [
            'currentBook' => $currentBook,
            'currentTestimonis' => $selectedTestimonis, // Pastikan data testimonis dikirim
            'footers' => $footers, 
        ]);
    }
    


    // Halaman dashboard untuk admin
    public function dashboard()
    {
        // Ambil pengaturan yang tersimpan untuk user ini
        $user = auth()->user();
        $setting = Setting::where('user_id', $user->id)->first();
        
        // Ambil data buku dan testimoni berdasarkan ID yang tersimpan
        $currentBook = null;
        $selectedTestimonis = [];
        
        // Mengambil data footer beserta sub-footers
        $footers = Footer::with('subFooters')->get();

        if ($setting) {
            $currentBook = Book::find($setting->selected_book_id);
            $selectedTestimonis = Testimoni::whereIn('id', json_decode($setting->selected_testimoni_ids))->get();
        }

        // Kirim data ke tampilan
        return Inertia::render('Dashboard', [
            'currentBook' => $currentBook,
            'selectedTestimonis' => $selectedTestimonis,
            'footers' => $footers,  // Kirim data footers dan sub-footers ke tampilan
        ]);
    }


    public function dashboardedit(Request $request)
    {
        // Mendapatkan user yang sedang login
        $user = auth()->user();
        
        // Ambil data setting terkait user
        $setting = $user->setting;
        
        // Ambil ID buku yang telah dipilih
        $selectedBookId = $setting ? $setting->selected_book_id : null;
        
        // Ambil ID testimoni yang telah dipilih
        $selectedTestimonisIds = $setting ? json_decode($setting->selected_testimoni_ids, true) : [];

        // Ambil semua buku untuk dropdown
        $books = Book::all();
        
        // Ambil buku yang dipilih (jika ada)
        $currentBook = $selectedBookId ? Book::find($selectedBookId) : null;
        
        // Ambil semua testimoni
        $testimonis = Testimoni::all();
        
        return Inertia::render('DashboardEdit', [
            'books' => $books,  // Daftar buku
            'currentBook' => $currentBook, // Menampilkan buku yang dipilih
            'testimonis' => $testimonis, // Semua testimoni
            'selectedTestimonisIds' => $selectedTestimonisIds, // ID testimoni yang dipilih
            'csrfToken' => csrf_token(),
        ]);
    }


    // Menyimpan pilihan buku dan testimoni yang dipilih
    public function saveSettings(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'book_id' => 'required|exists:books,id', // Pastikan ID buku valid
            'testimoni_ids' => 'required|array|size:3', // Pastikan ada tepat 3 testimoni
            'testimoni_ids.*' => 'exists:testimonis,id', // Validasi masing-masing ID testimoni
        ]);

        // Ambil user saat ini
        $user = auth()->user();

        // Periksa apakah sudah ada pengaturan untuk user ini
        $setting = Setting::where('user_id', $user->id)->first();

        // Jika sudah ada, update pengaturan
        if ($setting) {
            $setting->selected_book_id = $validatedData['book_id'];
            $setting->selected_testimoni_ids = json_encode($validatedData['testimoni_ids']);
        } else {
            // Jika belum ada, buat pengaturan baru
            $setting = new Setting();
            $setting->user_id = $user->id;
            $setting->selected_book_id = $validatedData['book_id'];
            $setting->selected_testimoni_ids = json_encode($validatedData['testimoni_ids']);
        }

        // Simpan pengaturan
        try {
            $setting->save();
        } catch (\Exception $e) {
            // Tangani kesalahan jika ada
            Log::error("Gagal menyimpan pengaturan: " . $e->getMessage());
            return redirect()->route('dashboard.edit')->with('error', 'Gagal menyimpan pengaturan.');
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->route('dashboard.edit')->with('success', 'Pengaturan berhasil disimpan!');
    }




}