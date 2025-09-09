<x-layout>
<div class="max-w-5xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-lg min-h-screen">

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-green-500">
            Spis #{{ $stocktaking->id }} – {{ $stocktaking->date->format('Y-m-d') }}
        </h1>
        <span class="px-3 py-1 bg-green-800 text-green-200 rounded">{{ ucfirst($stocktaking->status) }}</span>
    </div>

    @if(session('success'))
        <div class="mb-6 p-3 bg-green-800 text-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

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

    <h2 class="text-xl font-semibold mb-2 text-green-400">Dodaj produkty do spisu</h2>
    <form method="POST" action="{{ route('stocktakings.addItem', $stocktaking) }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto border border-gray-700 p-4 rounded-lg">
            @foreach($products as $product)
                <label class="flex items-center space-x-2 p-2 border border-gray-700 rounded hover:bg-gray-700">
                    <input type="checkbox" name="products[{{ $product->id }}][selected]" value="1"
                           class="form-checkbox h-5 w-5 text-green-500">
                    <div class="flex-1">
                        <div>{{ $product->name }} ({{ $product->unit }})</div>
                        <div class="text-gray-400 text-sm">
                            @foreach($product->barcodes as $barcode)
                                {{ $barcode->code }}@if(!$loop->last), @endif
                            @endforeach
                        </div>
                    </div>
                    <input type="number" step="0.001" name="products[{{ $product->id }}][quantity]" placeholder="Ilość"
                           class="w-20 border-gray-600 rounded p-1 bg-gray-800 text-white" disabled>
                    <input type="number" step="0.01" name="products[{{ $product->id }}][price]" placeholder="Cena"
                           class="w-20 border-gray-600 rounded p-1 bg-gray-800 text-white" disabled>
                </label>
            @endforeach
        </div>

        <div class="flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg">
                Dodaj zaznaczone produkty
            </button>
        </div>
    </form>

    <script>
        document.querySelectorAll('input[type=checkbox]').forEach(chk => {
            chk.addEventListener('change', function() {
                const container = this.closest('label');
                container.querySelectorAll('input[type=number]').forEach(input => {
                    input.disabled = !this.checked;
                });
            });
        });
    </script>
</div>
</x-layout>
