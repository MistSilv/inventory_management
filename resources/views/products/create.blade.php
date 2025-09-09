<x-layout>
    <div class="max-w-xl mx-auto p-6 bg-gray-900 shadow-lg rounded-lg text-white min-h-screen">
        <h1 class="text-2xl font-bold mb-6 text-green-500">Dodaj produkt</h1>

        {{-- Komunikat sukcesu --}}
        @if(session('success'))
            <div class="mb-6 p-3 bg-green-800 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.store') }}" class="space-y-6">
            @csrf

            {{-- Nazwa produktu --}}
            <div>
                <label class="block text-sm font-medium text-green-300 mb-1">Nazwa *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full bg-gray-800 text-white border-gray-700 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label class="block text-sm font-medium text-green-300 mb-1">SKU</label>
                <input type="text" name="sku" value="{{ old('sku') }}"
                       class="w-full bg-gray-800 text-white border-gray-700 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
            </div>

            {{-- Jednostka --}}
            <div>
                <label class="block text-sm font-medium text-green-300 mb-1">Jednostka *</label>
                <select name="unit"
                        class="w-full bg-gray-800 text-white border-gray-700 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                    <option value="">-- wybierz --</option>
                    @foreach(['szt','kg','m','l','opak'] as $unit)
                        <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>
                            {{ strtoupper($unit) }}
                        </option>
                    @endforeach
                </select>
                @error('unit') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Kody EAN --}}
            <div>
                <label class="block text-sm font-medium text-green-300 mb-1">Kody EAN</label>
                <div id="ean-wrapper" class="space-y-2">
                    <input type="text" name="ean_codes[]" value="{{ old('ean_codes.0') }}"
                           class="w-full bg-gray-800 text-white border-gray-700 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2">
                </div>
                <button type="button" onclick="addEan()"
                        class="mt-2 px-3 py-1 bg-green-700 text-white rounded hover:bg-green-600 text-sm">
                    ➕ Dodaj kolejny EAN
                </button>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-600">
                    Zapisz
                </button>
            </div>
        </form>
    </div>

    {{-- Skrypt dynamicznego dodawania EAN --}}
    <script>
        function addEan() {
            const wrapper = document.getElementById('ean-wrapper');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'ean_codes[]';
            input.className = 'w-full bg-gray-800 text-white border-gray-700 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-2';
            wrapper.appendChild(input);
        }
    </script>
</x-layout>
