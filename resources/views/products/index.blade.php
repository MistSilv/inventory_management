<x-layout>
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
