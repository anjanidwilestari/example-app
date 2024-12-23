<?php

namespace App\Http\Controllers;
use App\Models\SubFooter;

use Illuminate\Http\Request;

class SubFooterController extends Controller
{
    public function index()
    {
        return SubFooter::with('footer')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'footer_id' => 'required|exists:footers,id',
            'name' => 'required|string|max:255',
        ]);

        return SubFooter::create($request->all());
    }

    public function show(SubFooter $subFooter)
    {
        return $subFooter->load('isiSubFooters');
    }

    public function update(Request $request, SubFooter $subFooter)
    {
        $subFooter->update($request->all());
        return $subFooter;
    }

    public function destroy(SubFooter $subFooter)
    {
        $subFooter->delete();
        return response()->json(['message' => 'Sub-footer deleted successfully']);
    }
}
