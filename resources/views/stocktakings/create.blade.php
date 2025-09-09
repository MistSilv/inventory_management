<x-layout>
    <div class="max-w-xl mx-auto p-6 bg-gray-900 text-white min-h-screen rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-green-500">Nowy spis</h1>

        {{-- Komunikat sukcesu --}}
        @if(session('success'))
            <div class="mb-6 p-3 bg-green-800 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('stocktakings.store') }}" class="space-y-6">
            @csrf

            {{-- Data spisu --}}
            <div>
                <label class="block text-sm font-medium mb-1">Data spisu *</label>
                <input type="date" name="date" value="{{ old('date') }}"
                       class="w-full border-gray-700 bg-gray-800 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2 text-white">
                @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Opis --}}
            <div>
                <label class="block text-sm font-medium mb-1">Opis</label>
                <textarea name="description" rows="3"
                          class="w-full border-gray-700 bg-gray-800 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2 text-white">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                        class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg">
                    Zapisz spis
                </button>
            </div>
        </form>
    </div>
</x-layout>
