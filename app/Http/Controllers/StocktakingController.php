<?php

namespace App\Http\Controllers;

use App\Models\Stocktaking;
use Illuminate\Http\Request;

class StocktakingController extends Controller
{
    public function create()
    {
        return view('stocktaking.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'data' => 'required|date',
            'opis' => 'nullable|string',
        ]);

        Stocktaking::create($request->only('data', 'opis'));

        return redirect()->route('stocktaking.create')->with('success', 'Inwentaryzacja została dodana.');
    }
}
