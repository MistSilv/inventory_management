<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\EanCode;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nazwa' => 'required|string|max:255',
            'id_abaco' => 'nullable|string|max:255',
            'ean_codes.*' => 'nullable|string|size:13',
        ]);

        $product = Product::create([
            'nazwa' => $validated['nazwa'],
            'id_abaco' => $validated['id_abaco'] ?? null,
        ]);

        if (!empty($validated['ean_codes'])) {
            foreach ($validated['ean_codes'] as $code) {
                if ($code) {
                    $product->eanCodes()->create(['kod_ean' => $code]);
                }
            }
        }

        return redirect()->route('welcome')->with('success', 'Produkt został dodany.');
    }

    //usunięcie albo poprawienie w innnym miejscu
    public function showAll()
    {
        $products = \App\Models\Product::with('eanCodes')->get();
        return view('products.show', compact('products'));
    }

    //potem do usunięcia, poprawienia w innych miejscach
    public function raport()
    {
        $products = \App\Models\Product::with('eanCodes')->get();
        return view('products.raport', compact('products'));
    }
}
