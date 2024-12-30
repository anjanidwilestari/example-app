<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DistributorController extends Controller
{
    // Menampilkan daftar distributor
    public function index()
    {
        $distributors = Distributor::all();
        return Inertia::render('Distributors/Index', [
            'distributors' => $distributors
        ]);
    }

    // Menampilkan halaman form untuk menambah distributor
    public function create()
    {
        return Inertia::render('Distributors/Create');
    }

    // Menyimpan distributor baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'island' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        Distributor::create($request->all());

        return redirect()->route('distributors.index');
    }

    // Menampilkan detail distributor
    public function show(Distributor $distributor)
    {
        return Inertia::render('Distributors/Show', [
            'distributor' => $distributor
        ]);
    }

    // Menampilkan halaman form untuk mengedit distributor
    public function edit(Distributor $distributor)
    {
        return Inertia::render('Distributors/Edit', [
            'distributor' => $distributor
        ]);
    }

    // Mengupdate distributor
    public function update(Request $request, Distributor $distributor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'island' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $distributor->update($request->all());

        return redirect()->route('distributors.index');
    }

    // Menghapus distributor
    public function destroy(Distributor $distributor)
    {
        $distributor->delete();
        return redirect()->route('distributors.index');
    }
}
