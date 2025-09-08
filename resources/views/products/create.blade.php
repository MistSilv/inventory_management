<x-layout title="Dodaj produkt">
    <h1 class="text-2xl font-bold mb-6 text-slate-100">Dodaj nowy produkt</h1>

    @if ($errors->any())
        <div class="bg-red-800/20 text-red-400 border border-red-500/30 p-4 rounded mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produkty.store') }}" method="POST" class="space-y-6 bg-slate-900 p-6 rounded-lg shadow-lg border border-slate-800">
        @csrf

        <div>
            <label for="nazwa" class="block font-semibold text-slate-100 mb-1">Nazwa produktu</label>
            <input type="text" name="nazwa" id="nazwa" value="{{ old('nazwa') }}"
                   class="w-full bg-slate-800 border border-emerald-600/50 text-slate-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 transition">
        </div>

        <div>
            <label for="id_abaco" class="block font-semibold text-slate-100 mb-1">ID Abaco</label>
            <input type="text" name="id_abaco" id="id_abaco" value="{{ old('id_abaco') }}"
                   class="w-full bg-slate-800 border border-emerald-600/50 text-slate-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 transition">
        </div>

        <div id="ean-wrapper">
            <label class="block font-semibold text-slate-100 mb-2">Kody EAN</label>

            <div class="flex space-x-2 mb-2">
                <input type="text" name="ean_codes[]" placeholder="Wpisz kod EAN"
                       class="flex-1 bg-slate-800 border border-emerald-600/50 text-slate-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 transition">
                <button type="button" onclick="addEanInput()"
                        class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-semibold rounded transition">
                    +
                </button>
            </div>
        </div>

        <button type="submit"
                class="w-full sm:w-auto px-6 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-semibold rounded transition">
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
                       class="flex-1 bg-slate-800 border border-emerald-600/50 text-slate-100 p-2 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 transition">
                <button type="button" onclick="this.parentElement.remove()"
                        class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-semibold rounded transition">-</button>
            `;
            wrapper.appendChild(div);
        }
    </script>
</x-layout>
