<?php

namespace App\Http\Controllers;

use App\Models\Stocktaking;
use App\Models\StocktakingItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StocktakingController extends Controller
{
    // Lista spisów
    public function index()
    {
        $stocktakings = Stocktaking::with('creator')->latest()->paginate(10);
        return view('stocktakings.index', compact('stocktakings'));
    }

    // Formularz dodania nowego spisu
    public function create()
    {
        return view('stocktakings.create');
    }

    // Zapis nowego spisu
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $stocktaking = Stocktaking::create([
            'date' => $validated['date'],
            'description' => $validated['description'] ?? null,
            'status' => 'draft',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('stocktakings.show', $stocktaking)->with('success', 'Spis został utworzony');
    }

    // Podgląd spisu wraz z pozycjami
    public function show(Stocktaking $stocktaking)
{
    $stocktaking->load('items.product.barcodes'); // <-- dołączamy barcodes
    $products = Product::with('barcodes')->get(); // wszystkie produkty z EAN
    return view('stocktakings.show', compact('stocktaking', 'products'));
}


    // Dodanie pozycji do spisu
    public function addItem(Request $request, Stocktaking $stocktaking)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.selected' => 'nullable|boolean',
            'products.*.quantity' => 'nullable|numeric|min:0',
            'products.*.price' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['products'] as $productId => $data) {
            if (!empty($data['selected'])) {
                $item = $stocktaking->items()->create([
                    'product_id' => $productId,
                    'quantity' => $data['quantity'] ?? 0,
                    'price' => $data['price'] ?? 0,
                ]);

                $item->logs()->create([
                    'user_id' => Auth::id(),
                    'action' => 'create',
                ]);
            }
        }

        return redirect()->route('stocktakings.show', $stocktaking)->with('success', 'Produkty zostały dodane do spisu');
    }



public function generate(Stocktaking $stocktaking)
{
    $stocktaking->load('items.product.barcodes'); // <-- dołączamy barcodes
    return view('stocktakings.generate', compact('stocktaking'));
}

public function updateItems(Request $request, Stocktaking $stocktaking)
{
    foreach ($request->items as $itemId => $data) {
        $item = $stocktaking->items()->find($itemId);
        if ($item) {
            $item->update([
                'quantity' => $data['quantity'],
                'price' => $data['price'],
            ]);
        }
    }
    return redirect()->back()->with('success', 'Pozycje zostały zaktualizowane');
}

public function deleteItem(StocktakingItem $item)
{
    $item->delete();
    return redirect()->back()->with('success', 'Pozycja została usunięta');
}


public function print(Stocktaking $stocktaking)
{
    $stocktaking->load('items.product.barcodes', 'creator'); // <-- dołączamy barcodes
    return view('stocktakings.print', compact('stocktaking'));
}


    
}
