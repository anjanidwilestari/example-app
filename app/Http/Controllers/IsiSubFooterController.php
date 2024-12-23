<?php

namespace App\Http\Controllers;

use App\Models\IsiSubFooter;
use Illuminate\Http\Request;

class IsiSubFooterController extends Controller
{
    public function index()
    {
        return IsiSubFooter::with('subFooter')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'sub_footer_id' => 'required|exists:sub_footers,id',
            'name' => 'required|string|max:255',
            'link' => 'required|url',
        ]);

        return IsiSubFooter::create($request->all());
    }

    public function update(Request $request, IsiSubFooter $isiSubFooter)
    {
        $isiSubFooter->update($request->all());
        return $isiSubFooter;
    }

    public function destroy(IsiSubFooter $isiSubFooter)
    {
        $isiSubFooter->delete();
        return response()->json(['message' => 'Isi Sub-footer deleted successfully']);
    }
}
