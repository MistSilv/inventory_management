<x-layout>

    <div class="mt-10">
        <p class="text-lg mb-6">Kiedyś tutaj będzie jakaś strona główna albo coś w tym stylu.</p>


        <a href="{{ route('products.create') }}" 
            class="inline-block px-6 py-3 bg-indigo-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-indigo-700">
            ➕ Dodaj produkt
        </a>
    </div>


    <p>Wstaw gdzie indziej potem</p>
    <nav class="bg-gray-800 text-white p-4 mb-6 rounded-lg shadow flex justify-between items-center">
        <div class="flex space-x-4">
            
        </div>
        @isset($stocktaking)
            <a href="{{ route('stocktakings.show', $stocktaking) }}"
            class="px-3 py-2 rounded hover:bg-gray-700">
            Podgląd spisu #{{ $stocktaking->id }}
            </a>
        @endisset
    </nav>
  

    <div class="flex items-center justify-center min-h-screen bg-black">
        <div class="text-4xl animate-spin">
            🐱‍🚀
            <br>
            🐱‍💻
        </div>
    </div>

</x-layout>