<?php

namespace App\Http\Controllers;

use App\Models\Stocktaking;
use App\Models\StocktakingItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StocktakingController extends Controller
{
    // Lista spisów
    public function index()
    {
        // Czyścimy tymczasowe zaznaczenia bieżącego użytkownika
        DB::table('stocktaking_temp_items')
            ->where('user_id', Auth::id())
            ->delete();

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

        return redirect()->route('stocktakings.show', $stocktaking)
            ->with('success', 'Spis został utworzony');
    }

    // Podgląd spisu
    public function show(Stocktaking $stocktaking, Request $request)
    {
        $stocktaking->load('items.product.barcodes');

        $query = Product::query();

        // Szukanie po nazwie i EAN
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('barcodes', function($sub) use ($request) {
                      $sub->where('code', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filtr daty
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $products = $query->latest()->paginate(20)->withQueryString();

        // Pobranie zaznaczonych produktów z tymczasowej tabeli dla bieżącego użytkownika
        $tempSelected = DB::table('stocktaking_temp_items')
            ->where('stocktaking_id', $stocktaking->id)
            ->where('user_id', Auth::id())
            ->get()
            ->keyBy('product_id')
            ->toArray();

        return view('stocktakings.show', compact('stocktaking', 'products', 'tempSelected'));
    }

    // Dodanie produktów do spisu
    public function addItem(Request $request, Stocktaking $stocktaking)
    {
        $tempItems = DB::table('stocktaking_temp_items')
            ->where('stocktaking_id', $stocktaking->id)
            ->where('user_id', Auth::id())
            ->where('selected', true)
            ->get();

        foreach ($tempItems as $item) {
            $stocktaking->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity ?? 0,
                'price' => $item->price ?? 0,
            ]);
        }

        // Czyścimy tymczasowe zaznaczenia dla użytkownika
        DB::table('stocktaking_temp_items')
            ->where('stocktaking_id', $stocktaking->id)
            ->where('user_id', Auth::id())
            ->delete();

        return redirect()->route('stocktakings.show', $stocktaking)
            ->with('success', 'Produkty zostały dodane do spisu');
    }

    // Zapamiętywanie zaznaczeń w tabeli tymczasowej
    public function rememberSelected(Request $request, Stocktaking $stocktaking)
    {
        $selected = $request->input('selected', []);

        foreach ($selected as $productId => $data) {
            DB::table('stocktaking_temp_items')->updateOrInsert(
                [
                    'stocktaking_id' => $stocktaking->id,
                    'product_id' => $productId,
                    'user_id' => Auth::id(), // przypisanie do użytkownika
                ],
                [
                    'selected' => $data['selected'] ?? false,
                    'quantity' => $data['quantity'] ?? null,
                    'price' => $data['price'] ?? null,
                    'updated_at' => now()
                ]
            );
        }

        return response()->json(['status' => 'ok']);
    }


    //drukowanie i podgląd wydruku
    public function generate(Stocktaking $stocktaking)
{
    $stocktaking->load('items.product.barcodes');
    return view('stocktakings.generate', compact('stocktaking'));
}

 // Aktualizacja ilości i ceny
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
    $stocktaking->load('items.product.barcodes', 'creator');
    return view('stocktakings.print', compact('stocktaking'));
}


}
