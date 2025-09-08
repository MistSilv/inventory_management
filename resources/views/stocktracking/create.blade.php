<x-layout title="Nowa inwentaryzacja">
    <h1 class="text-2xl font-bold mb-6">Dodaj inwentaryzację</h1>

    <form action="{{ route('stocktaking.store') }}" method="POST" class="space-y-4 max-w-md">
        @csrf

        <div>
            <label for="data" class="block font-medium">Data inwentaryzacji</label>
            <input type="date" name="data" id="data"
                   class="w-full border rounded p-2"
                   value="{{ old('data') }}" required>
        </div>

        <div>
            <label for="opis" class="block font-medium">Opis (opcjonalny)</label>
            <textarea name="opis" id="opis" rows="3"
                      class="w-full border rounded p-2">{{ old('opis') }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Zapisz inwentaryzację
        </button>
    </form>
</x-layout>
