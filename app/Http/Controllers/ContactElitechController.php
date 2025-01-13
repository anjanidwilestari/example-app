<?php

namespace App\Http\Controllers;

use App\Models\ContactElitech;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactElitechController extends Controller
{
    

    public function edit($id)
    {
        $contact = ContactElitech::findOrFail($id);
        return Inertia::render('ContactElitech/Edit', [
            'contact' => $contact
        ]);
    }

    public function update(Request $request, $id)
    {
        $contact = ContactElitech::findOrFail($id);
        $data = $request->validate([
            'whatsapp_number' => 'array',
            'phone_number' => 'array',
            'email' => 'array',
            'instagram' => 'array',
            'youtube' => 'array',
            'address' => 'array',
            'link_maps' => 'array',
        ]);
        $contact->update($data);
        return redirect()->route('contact_elitechs.edit', $contact->id);
    }
}
