<?php

// app/Http/Controllers/FooterController.php
namespace App\Http\Controllers;

use App\Models\Footer;
use App\Models\SubFooter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FooterController extends Controller
{
    // Menampilkan daftar footers beserta subfooters
    public function index()
    {
        // Ambil data footers beserta subfooters terkait
        $footers = Footer::with('subFooters')->get();

        // Render tampilan Vue menggunakan Inertia dan kirimkan data footers
        return Inertia::render('Footers/Index', [
            'footers' => $footers,
        ]);
    }

    // Menyimpan footer baru
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buat footer baru
        Footer::create($request->all());

        // Redirect kembali ke halaman index setelah menyimpan footer
        return redirect()->route('footers.index');
    }

    // Mengupdate footer
    public function update(Request $request, Footer $footer)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update data footer
        $footer->update($request->all());

        // Redirect kembali ke halaman index setelah mengupdate footer
        return redirect()->route('footers.index');
    }

    // Menghapus footer
    public function destroy(Footer $footer)
    {
        // Hapus footer beserta subfootersnya (cascade delete)
        $footer->delete();

        // Redirect kembali ke halaman index setelah menghapus footer
        return redirect()->route('footers.index');
    }

    // Menyimpan subfooter untuk footer tertentu
    public function storeSubFooter(Request $request, Footer $footer)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        // Buat subfooter baru yang terkait dengan footer ini
        $footer->subFooters()->create($request->all());

        // Redirect kembali ke halaman index setelah menyimpan subfooter
        return redirect()->route('footers.index');
    }

    // Mengupdate subfooter
    public function updateSubFooter(Request $request, SubFooter $subFooter)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|string|max:255',
        ]);

        // Update data subfooter
        $subFooter->update($request->all());

        // Redirect kembali ke halaman index setelah mengupdate subfooter
        return redirect()->route('footers.index');
    }

    // Menghapus subfooter
    public function destroySubFooter(SubFooter $subFooter)
    {
        // Hapus subfooter
        $subFooter->delete();

        // Redirect kembali ke halaman index setelah menghapus subfooter
        return redirect()->route('footers.index');
    }
}
