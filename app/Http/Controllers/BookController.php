<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Audit;
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
    // Validasi input
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
   
    
    public function historyAll()
    {
        $audits = \OwenIt\Auditing\Models\Audit::with('user')
            ->where('auditable_type', 'App\Models\Book') // Hanya ambil audit untuk buku
            ->orderBy('created_at', 'desc')
            ->get();
    
        return Inertia::render('Books/HistoryAll', [
            'audits' => $audits,
        ]);
    }
    

    public function history($id)
{
    $book = Book::with('audits.user')->findOrFail($id);
    return Inertia::render('Books/History', [
        'book' => $book,
        'audits' => $book->audits,
    ]);
}


}
