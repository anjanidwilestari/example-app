<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    // Menampilkan daftar buku
    public function index()
    {
        $books = Book::all();
        return Inertia::render('Books/Index', [
            'books' => $books,
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
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'description' => $request->input('description'),
        ]);

        // Menangani upload gambar jika ada
        if ($request->hasFile('image')) {
            if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
                Storage::disk('public')->delete($book->image_path);
            }
            $book->image_path = $request->file('image')->store('images', 'public');
        }

        // Menangani upload video jika ada
        if ($request->hasFile('video')) {
            if ($book->video_path && Storage::disk('public')->exists($book->video_path)) {
                Storage::disk('public')->delete($book->video_path);
            }
            $book->video_path = $request->file('video')->store('videos', 'public');
        }

        // Menangani upload audio jika ada
        if ($request->hasFile('audio')) {
            if ($book->audio_path && Storage::disk('public')->exists($book->audio_path)) {
                Storage::disk('public')->delete($book->audio_path);
            }
            $book->audio_path = $request->file('audio')->store('audio', 'public');
        }

        // Simpan perubahan buku termasuk perubahan path file
        $book->save();

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
