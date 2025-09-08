<x-layout title="Dodaj produkt">
    <h1 class="text-2xl font-bold mb-6">Dodaj nowy produkt</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produkty.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="nazwa" class="block font-semibold">Nazwa produktu</label>
            <input type="text" name="nazwa" id="nazwa" value="{{ old('nazwa') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label for="id_abaco" class="block font-semibold">ID Abaco</label>
            <input type="text" name="id_abaco" id="id_abaco" value="{{ old('id_abaco') }}"
                   class="w-full border rounded p-2">
        </div>

        <div id="ean-wrapper">
            <label class="block font-semibold">Kody EAN</label>
            <div class="flex space-x-2 mb-2">
                <input type="text" name="ean_codes[]" placeholder="Wpisz kod EAN"
                       class="flex-1 border rounded p-2">
                <button type="button" onclick="addEanInput()" 
                        class="px-4 py-2 bg-green-500 text-white rounded">+</button>
            </div>
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Zapisz
        </button>
    </form>

    <script>
        function addEanInput() {
            const wrapper = document.getElementById('ean-wrapper');
            const div = document.createElement('div');
            div.classList.add('flex', 'space-x-2', 'mb-2');
            div.innerHTML = `
                <input type="text" name="ean_codes[]" placeholder="Wpisz kod EAN"
                       class="flex-1 border rounded p-2">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="px-4 py-2 bg-red-500 text-white rounded">-</button>
            `;
            wrapper.appendChild(div);
        }
    </script>
</x-layout>
