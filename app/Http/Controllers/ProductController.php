<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Barcode;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with('barcodes');

        // Szukanie po nazwie / EAN
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhereHas('barcodes', function ($b) use ($search) {
                    $b->where('code', 'like', "%{$search}%");
                });
            });
        }

        // Filtrowanie po dacie od
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        // Filtrowanie po dacie do
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $products = $query->latest()->paginate(25)->withQueryString();

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

