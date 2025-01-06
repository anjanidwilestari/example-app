<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Testimoni;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        // Ambil semua testimoni dan kirim ke Inertia
        $testimonis = Testimoni::all();
        return Inertia::render('Testimonis/Index', [
            'testimonis' => $testimonis,
        ]);
    }

    public function show($id)
    {
        // Ambil data buku berdasarkan ID
        $testimoni = Testimoni::findOrFail($id);

        // Kirim data buku ke Vue component
        return Inertia::render('Testimonis/Show', [
            'testimoni' => $testimoni,
        ]);
    }

    public function create()
    {
        return Inertia::render('Testimonis/Create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name_customer' => 'required|string|max:255',
            'workplace' => 'required|string|max:255',
            'review' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Maksimal 2MB untuk foto
            'status' => 'nullable|boolean',  // Menambahkan validasi untuk status
        ]);

        // Menambahkan testimoni baru
        $testimoni = new Testimoni();
        $testimoni->name_customer = $request->name_customer;
        $testimoni->workplace = $request->workplace;
        $testimoni->review = $request->review;
        $testimoni->status = $request->filled('status') ? true : false;

        // Simpan file jika ada
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public'); // Menyimpan foto ke storage
            $testimoni->photo = basename($path); // Hanya menyimpan nama file
        }

        $testimoni->save(); // Menyimpan data testimoni

        // Mengembalikan response JSON
        return redirect()->route('testimonis.index');
    }

    public function edit($id)
    {
        // Ambil data testimoni berdasarkan id untuk ditampilkan di form edit
        $testimoni = Testimoni::findOrFail($id);

        return Inertia::render('Testimonis/Edit', [
            'testimoni' => $testimoni,  // Mengirim data testimoni untuk form edit
        ]);
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        // Validasi input
        $request->validate([
            'name_customer' => 'required|string|max:255',
            'workplace' => 'required|string|max:255',
            'review' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  
            'status' => 'nullable|boolean', 
        ]);

        // Update data testimoni
        $testimoni->update([
            'name_customer' => $request->name_customer ?? $testimoni->name_customer,
            'workplace' => $request->workplace ?? $testimoni->workplace,
            'review' => $request->review ?? $testimoni->review,
            'status' => $request->filled('status') ? true : false,
        ]);

        // Jika ada foto baru, simpan dan hapus foto lama jika ada
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($testimoni->photo && Storage::disk('public')->exists($testimoni->photo)) {
                Storage::disk('public')->delete($testimoni->photo);
            }
        
            // Simpan foto baru
            $newPhoto = $request->file('photo')->store('photos', 'public');
            $testimoni->photo = basename($newPhoto);  // Simpan nama file tanpa path 'public/'
        }
        
        $testimoni->save();  // Simpan perubahan

        return redirect()->route('testimonis.index');
    }

    public function destroy(Testimoni $testimoni)
    {
        // Hapus file terkait jika ada
        if ($testimoni->photo && Storage::disk('public')->exists($testimoni->photo)) {
            Storage::disk('public')->delete($testimoni->photo);
        }

        // Hapus testimoni dari database
        $testimoni->delete();

        // Respons penghapusan berhasil
        return redirect()->route('testimonis.index');
    }

    public function selectTestimonis(Request $request)
    {
        // Validasi data yang dipilih
        $request->validate([
            'selected_testimoni_ids' => 'required|array|size:3',
        ]);

        // Ambil atau buat setting untuk user yang sedang login
        $setting = Setting::firstOrCreate(
            ['user_id' => auth()->id()],
            ['selected_testimoni_ids' => json_encode($request->selected_testimoni_ids)]
        );

        // Update pengaturan dengan testimoni yang dipilih
        $setting->selected_testimoni_ids = json_encode($request->selected_testimoni_ids);
        $setting->save();

        return response()->json($setting);
    }
}
