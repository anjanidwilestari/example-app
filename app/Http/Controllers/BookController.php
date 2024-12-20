<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

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
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
        ]);

        $book = new Book();
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->description = $validated['description'];

        // Menyimpan file gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public'); // Menyimpan di disk public
            $book->image_path = $imagePath;
        }

        // Menyimpan file video
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
            $book->video_path = $videoPath;
        }

        // Menyimpan file audio
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio', 'public');
            $book->audio_path = $audioPath;
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
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:10240',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
        ]);

        // Update kolom lainnya
        $book->update([
            'title' => $request->input('title'),
            'author' => $request->input('author'),
            'description' => $request->input('description'),
        ]);

        // Menangani upload gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($book->image_path && Storage::disk('public')->exists($book->image_path)) {
                Storage::disk('public')->delete($book->image_path);
            }

            // Simpan gambar baru dan perbarui path-nya
            $imagePath = $request->file('image')->store('images', 'public');
            $book->image_path = $imagePath;
        }

        // Menangani upload video jika ada
        if ($request->hasFile('video')) {
            // Hapus video lama jika ada
            if ($book->video_path && Storage::disk('public')->exists($book->video_path)) {
                Storage::disk('public')->delete($book->video_path);
            }

            // Simpan video baru dan perbarui path-nya
            $videoPath = $request->file('video')->store('videos', 'public');
            $book->video_path = $videoPath;
        }

        // Menangani upload audio jika ada
        if ($request->hasFile('audio')) {
            // Hapus audio lama jika ada
            if ($book->audio_path && Storage::disk('public')->exists($book->audio_path)) {
                Storage::disk('public')->delete($book->audio_path);
            }

            // Simpan audio baru dan perbarui path-nya
            $audioPath = $request->file('audio')->store('audio', 'public');
            $book->audio_path = $audioPath;
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
