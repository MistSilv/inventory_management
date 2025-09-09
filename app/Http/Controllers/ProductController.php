<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Barcode;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('barcodes')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $units = ['szt', 'kg', 'm', 'l', 'opak'];
        return view('products.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'unit' => 'required|in:szt,kg,m,l,opak',
            'ean_codes' => 'array',
            'ean_codes.*' => 'nullable|string|max:13',
        ]);

        $product = Product::create([
            'name' => $validated['name'],
            'sku' => $validated['sku'] ?? null,
            'unit' => $validated['unit'],
        ]);

        if (!empty($validated['ean_codes'])) {
            foreach ($validated['ean_codes'] as $ean) {
                if (!empty($ean)) {
                    $product->barcodes()->create(['code' => $ean]);
                }
            }
        }

        return redirect()->route('products.create')->with('success', 'Produkt został dodany');
    }

    public function show(Product $product)
    {
        // Ładowanie powiązanych kodów EAN
        $product->load('barcodes');

        return view('products.show', compact('product'));
    }

}

