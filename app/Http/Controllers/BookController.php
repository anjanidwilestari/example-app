<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    //Dashboard (tampilan user)
    public function welcome()
    {
         // Ambil ID buku yang telah dipilih dari session
         $selectedBookId = session('selected_book_id', null);

         // Jika ada buku yang dipilih, ambil datanya
         $currentBook = $selectedBookId ? Book::find($selectedBookId) : Book::first(); // Default ke buku pertama
 
         return Inertia::render('WelcomeUser', [
             'books' => Book::all(),
             'currentBook' => $currentBook, // Buku yang dipilih
         ]);
    }

    // Menampilkan halaman dashboard (admin)
    public function dashboard()
    {
        // Ambil ID buku yang telah dipilih dari session
        $selectedBookId = session('selected_book_id', null);

        // Jika ada buku yang dipilih, ambil datanya
        $currentBook = $selectedBookId ? Book::find($selectedBookId) : Book::first(); // Default ke buku pertama

        return Inertia::render('Dashboard', [
            'books' => Book::all(),
            'currentBook' => $currentBook, // Buku yang dipilih
        ]);
    }

    // Menampilkan halaman edit dashboard
    public function dashboardedit(Request $request)
    {
        // Ambil semua buku untuk dropdown
        $books = Book::all();

        // Jika ada 'book_id' dalam request, simpan ke session
        if ($request->has('book_id')) {
            $bookId = $request->input('book_id');
            session(['selected_book_id' => $bookId]);
        }

        // Ambil ID buku yang telah disimpan di session
        $selectedBookId = session('selected_book_id', null);

        // Ambil buku yang dipilih (jika ada)
        $currentBook = $selectedBookId ? Book::find($selectedBookId) : null;

        return Inertia::render('DashboardEdit', [
            'books' => $books,
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

        // Simpan ID buku yang dipilih dalam session
        session(['selected_book_id' => $request->input('book_id')]);

        return redirect()->route('dashboard');
    }


    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::all();
        return Inertia::render('Books/Index', [
            'books' => $books,
        ]);
    }

    public function show($id)
    {
        // Ambil data buku berdasarkan ID
        $book = Book::findOrFail($id);

        // Kirim data buku ke Vue component
        return inertia('Books/Show', [
            'book' => $book,
        ]);
    }

    // Menampilkan form untuk membuat buku baru
    public function create()
    {
        return Inertia::render('Books/Create');
    }

    // Menyimpan buku baru
    public function store(Request $request)
{
    // Tambahkan log untuk memeriksa apakah file sudah diterima
    Log::info('Request data: ', $request->all());
    Log::info('Files: ', $request->files->all());

    $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'description' => 'nullable|string',
        'image' => 'nullable|image|max:2048',  // Maksimal 2MB untuk gambar
        'video' => 'nullable|mimes:mp4,avi,mov|max:10240',  // Maksimal 10MB untuk video
        'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',  // Maksimal 10MB untuk audio
    ]);

    // Proses penyimpanan file
    $book = new Book();
    $book->title = $request->title;
    $book->author = $request->author;
    $book->description = $request->description;

    // Menyimpan file jika ada
    if ($request->hasFile('image')) {
        $book->image_path = $request->file('image')->store('images', 'public');
    }
    
    if ($request->hasFile('video')) {
        $book->video_path = $request->file('video')->store('videos', 'public');
    }
    
    if ($request->hasFile('audio')) {
        $book->audio_path = $request->file('audio')->store('audio', 'public');
    }

    $book->save();
    
    return redirect()->route('books.index');
}


    // Menampilkan form untuk mengedit buku
    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
        ]);
    }

    // Update data buku
    public function update(Request $request, Book $book)
    {
        // Validasi input
        $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg,m4a|max:10240',
        ]);

        // Update kolom lainnya
        $book->update([
            'title' => $request->title ?? $book->title,
            'author' => $request->author ?? $book->author,
            'description' => $request->description ?? $book->description,
        ]);

        // Menangani upload gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
                Storage::disk('public')->delete($book->image_path);
            }

            // Simpan gambar baru dan perbarui path-nya
            $newImagePath = $request->file('image')->store('images', 'public');
            $book->image_path = $newImagePath;
        }

        // Menangani upload video jika ada
        if ($request->hasFile('video')) {
            // Hapus video lama jika ada
            if ($book->video_path && Storage::disk('public')->exists($book->video_path)) {
                Storage::disk('public')->delete($book->video_path);
            }
            // Simpan video baru dan perbarui path-nya
            $book->video_path = $request->file('video')->store('videos', 'public');
        }

        // Menangani upload audio jika ada
        if ($request->hasFile('audio')) {
            // Hapus audio lama jika ada
            if ($book->audio_path && Storage::disk('public')->exists($book->audio_path)) {
                Storage::disk('public')->delete($book->audio_path);
            }
            // Simpan audio baru dan perbarui path-nya
            $book->audio_path = $request->file('audio')->store('audio', 'public');
        }

        // Simpan perubahan buku termasuk perubahan path file
        $book->save();

        // Redirect ke halaman buku
        return redirect()->route('books.index');
    }

    // Menghapus buku
    public function destroy(Book $book)
    {
        // Hapus file terkait jika ada
        if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
            Storage::disk('public')->delete($book->image_path);
        }

        if ($book->video_path && Storage::disk('public')->exists($book->video_path)) {
            Storage::disk('public')->delete($book->video_path);
        }

        if ($book->audio_path && Storage::disk('public')->exists($book->audio_path)) {
            Storage::disk('public')->delete($book->audio_path);
        }

        // Hapus data buku
        $book->delete();

        return redirect()->route('books.index');
    }
}
