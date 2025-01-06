<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reason;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ReasonController extends Controller
{
    public function index() 
    {
        $reasons = Reason::all();
        return Inertia::render('Reasons/Index', ['reasons' => $reasons]);
    }

    public function show($id)
    {
        // Ambil data buku berdasarkan ID
        $reason = Reason::findOrFail($id);

        // Kirim data buku ke Vue component
        return Inertia::render('Reasons/Show', [
            'reason' => $reason,
        ]);
    }

    public function create() 
    {
        return Inertia::render('Reasons/Create');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $reason = new Reason();
        $reason->title = $request->title;
        $reason->description = $request->description;
    
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $reason->icon = basename($path);
        }
    
        $reason->save();
    
        return redirect()->route('reasons.index')->with('success', 'Reason created successfully.');
    }

    public function edit($id) 
    {
        $reason = Reason::findOrFail($id);

        return Inertia::render('Reasons/Edit', [
            'reason' => $reason,  // Mengirim data reason untuk form edit
        ]);
    }
    
    public function update(Request $request, Reason $reason) 
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $reason->update([
            'title' => $request->title ?? $reason->title,
        ]);

        if ($request->hasFile('icon')) {
            if ($reason->icon && Storage::disk('public')->exists($reason->icon)) {
                Storage::disk('public')->delete($reason->icon);
            }
        
            $newIcon = $request->file('icon')->store('icons', 'public');
            $reason->icon = basename($newIcon);
        }

        $reason->save();
    
        return redirect()->route('reasons.index')->with('success', 'Reason updated successfully.');
    }

    public function destroy(Reason $reason) {
        if ($reason->icon && Storage::disk('public')->exists($reason->icon)) {
            Storage::disk('public')->delete($reason->icon);
        }

        $reason->delete();

        return redirect()->route('reasons.index')->with('success', 'Reason deleted successfully.');
    }
    
}
