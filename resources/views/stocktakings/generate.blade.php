<x-layout>
<div class="max-w-6xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-lg min-h-screen">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-500">Spis #{{ $stocktaking->id }} – {{ $stocktaking->date->format('Y-m-d') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('stocktakings.index') }}" 
               class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg shadow">
                Powrót
            </a>
            <a href="{{ route('stocktakings.print', $stocktaking) }}" target="_blank"
               class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white rounded-lg shadow">
                📄 Generuj dokument
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('stocktakings.updateItems', $stocktaking) }}">
        @csrf
        @method('PUT')
        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Lp.</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Produkt</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">EAN</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Jednostka</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Ilość</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Cena (PLN)</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Wartość (PLN)</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Usuń</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @php $total = 0; @endphp
                    @foreach($stocktaking->items as $index => $item)
                        @php $value = $item->quantity * $item->price; $total += $value; @endphp
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2 text-gray-400 text-sm">
                                @foreach($item->product->barcodes as $barcode)
                                    {{ $barcode->code }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $item->product->unit }}</td>
                            <td class="px-4 py-2">
                                <input type="number" step="0.001" name="items[{{ $item->id }}][quantity]" 
                                       value="{{ $item->quantity }}" 
                                       class="w-24 p-1 rounded bg-gray-700 text-white border border-gray-600">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" step="0.01" name="items[{{ $item->id }}][price]" 
                                       value="{{ $item->price }}" 
                                       class="w-24 p-1 rounded bg-gray-700 text-white border border-gray-600">
                            </td>
                            <td class="px-4 py-2">{{ number_format($value, 2, ',', ' ') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('stocktakings.deleteItem', $item) }}" 
                                   class="px-2 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm">
                                   Usuń
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-gray-700 font-bold">
                        <td colspan="6" class="px-4 py-2 text-right">Łączna wartość:</td>
                        <td class="px-4 py-2">{{ number_format($total, 2, ',', ' ') }} PLN</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-4">
            <button type="submit" 
                    class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg">
                Zapisz zmiany
            </button>
        </div>
    </form>
</div>
</x-layout>
