<x-layout>
<div class="max-w-5xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-lg min-h-screen">

    {{-- Nagłówek spisu --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-green-500">
            Spis #{{ $stocktaking->id }} – {{ $stocktaking->date->format('Y-m-d') }}
        </h1>
        <span class="px-3 py-1 bg-green-800 text-green-200 rounded">{{ ucfirst($stocktaking->status) }}</span>
    </div>

    {{-- Komunikat sukcesu --}}
    @if(session('success'))
        <div class="mb-6 p-3 bg-green-800 text-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lista pozycji w spisie --}}
    <h2 class="text-xl font-semibold mb-2 text-green-400">Pozycje w spisie</h2>
    <div class="overflow-x-auto mb-6 rounded-lg">
        <table class="min-w-full divide-y divide-gray-700 bg-gray-800 rounded-lg">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Produkt</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">EAN</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Jednostka</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Ilość</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Cena</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach($stocktaking->items as $item)
                    <tr class="hover:bg-gray-700">
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2 text-gray-400 text-sm">
                            @foreach($item->product->barcodes as $barcode)
                                {{ $barcode->code }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-2">{{ $item->product->unit }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">{{ $item->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Filtry --}}
    <form method="GET" action="{{ route('stocktakings.show', $stocktaking) }}" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <label for="search" class="block text-sm text-gray-300">Szukaj (nazwa / EAN)</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="px-3 py-2 rounded bg-gray-800 border border-gray-600 text-white w-64">
        </div>

        <div>
            <label for="date_from" class="block text-sm text-gray-300">Data od</label>
            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                   class="px-3 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>

        <div>
            <label for="date_to" class="block text-sm text-gray-300">Data do</label>
            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                   class="px-3 py-2 rounded bg-gray-800 border border-gray-600 text-white">
        </div>

        <div class="flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-600">
                Filtruj
            </button>
            <a href="{{ route('stocktakings.show', $stocktaking) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">
                Wyczyść
            </a>
        </div>
    </form>

    {{-- Dodawanie produktów do spisu --}}
    <h2 class="text-xl font-semibold mb-2 text-green-400">Dodaj produkty do spisu</h2>
    <form method="POST" action="{{ route('stocktakings.addItem', $stocktaking) }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($products->chunk(ceil($products->count() / 2)) as $chunk)
                <div class="space-y-2">
                    @foreach($chunk as $product)
                        @php
                            $checked = !empty($tempSelected[$product->id]) && $tempSelected[$product->id]->selected;
                            $quantity = $checked ? $tempSelected[$product->id]->quantity : '';
                            $price = $checked ? $tempSelected[$product->id]->price : '';
                        @endphp
                        <label class="flex items-center space-x-2 p-2 border border-gray-700 rounded hover:bg-gray-700">
                            <input type="checkbox" name="products[{{ $product->id }}][selected]" value="1"
                                   class="form-checkbox h-5 w-5 text-green-500" data-id="{{ $product->id }}"
                                   {{ $checked ? 'checked' : '' }}>
                            <span class="flex-1">
                                {{ $product->name }} ({{ $product->unit }})
                                @foreach($product->barcodes as $barcode)
                                    <span class="ml-2 text-xs bg-green-800 text-green-200 px-2 py-0.5 rounded">
                                        {{ $barcode->code }}
                                    </span>
                                @endforeach
                            </span>
                            <input type="number" step="0.001" name="products[{{ $product->id }}][quantity]"
                                   placeholder="Ilość" value="{{ $quantity }}"
                                   class="w-20 border-gray-600 rounded p-1 bg-gray-800 text-white"
                                   {{ $checked ? '' : 'disabled' }}>
                            <input type="number" step="0.01" name="products[{{ $product->id }}][price]"
                                   placeholder="Cena" value="{{ $price }}"
                                   class="w-20 border-gray-600 rounded p-1 bg-gray-800 text-white"
                                   {{ $checked ? '' : 'disabled' }}>
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg">
                Dodaj zaznaczone produkty
            </button>
        </div>
    </form>
</div>
</x-layout>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const checkboxes = document.querySelectorAll('input[type=checkbox][name^="products"]');

    function updateTempTable(productId, selected, quantity, price) {
        fetch("{{ route('stocktakings.rememberSelected', $stocktaking) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                selected: {
                    [productId]: {
                        selected: selected,
                        quantity: quantity,
                        price: price
                    }
                }
            })
        });
    }

    checkboxes.forEach(chk => {
        const container = chk.closest('label');
        const productId = chk.dataset.id;
        const quantityInput = container.querySelector('input[name^="products"][name$="[quantity]"]');
        const priceInput = container.querySelector('input[name^="products"][name$="[price]"]');

        // Obsługa checkboxa
        chk.addEventListener("change", function() {
            if (this.checked) {
                quantityInput.disabled = false;
                priceInput.disabled = false;
            } else {
                quantityInput.value = '';
                priceInput.value = '';
                quantityInput.disabled = true;
                priceInput.disabled = true;
            }
            updateTempTable(productId, this.checked, quantityInput.value || null, priceInput.value || null);
        });

        // Obsługa zmiany inputów
        quantityInput.addEventListener("input", () => {
            updateTempTable(productId, chk.checked, quantityInput.value || null, priceInput.value || null);
        });
        priceInput.addEventListener("input", () => {
            updateTempTable(productId, chk.checked, quantityInput.value || null, priceInput.value || null);
        });
    });
});
</script>



