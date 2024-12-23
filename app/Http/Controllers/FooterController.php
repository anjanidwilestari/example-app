<?php

namespace App\Http\Controllers;

use App\Models\Footer;
use Inertia\Inertia;
use Illuminate\Http\Request;


class FooterController extends Controller
{
    public function index()
    {
        $footers = Footer::all();
        return Inertia::render('Footers/Footer', [
            'footers' => $footers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Footer::create($request->all());
    }

    public function show(Footer $footer)
    {
        return $footer->load('subFooters.isiSubFooters');
    }

    public function update(Request $request, Footer $footer)
    {
        $footer->update($request->all());
        return $footer;
    }

    public function destroy(Footer $footer)
    {
        $footer->delete();
        return response()->json(['message' => 'Footer deleted successfully']);
    }
}
