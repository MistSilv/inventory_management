<x-layout>
    <form method="GET" action="{{ route('products.index') }}" class="mb-4 flex flex-wrap gap-2 items-end">
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
            
            <a href="{{ route('products.index') }}"
            class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-500">
                Wyczyść
            </a>
        </div>
    </form>



    
    <div class="max-w-6xl mx-auto p-6 bg-gray-900 text-white min-h-screen">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-green-500">Lista produktów</h1>
            <a href="{{ route('products.create') }}" 
               class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-600">
                ➕ Dodaj produkt
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-800 shadow-lg rounded-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Nazwa</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">SKU</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Jednostka</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">EAN</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Data dodania</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $product->id }}</td>
                            <td class="px-4 py-2 font-medium">{{ $product->name }}</td>
                            <td class="px-4 py-2">{{ $product->sku ?? '-' }}</td>
                            <td class="px-4 py-2">{{ strtoupper($product->unit) }}</td>
                            <td class="px-4 py-2">
                                @foreach($product->barcodes as $barcode)
                                    <span class="inline-block bg-green-800 text-green-200 px-2 py-0.5 rounded text-sm mr-1">{{ $barcode->code }}</span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2">{{ $product->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-layout>
