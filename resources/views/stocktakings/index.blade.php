<x-layout>
    <div class="max-w-5xl mx-auto p-6 bg-gray-900 text-white rounded-lg shadow-lg min-h-screen">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-green-500">Spisy z natury</h1>
            <a href="{{ route('stocktakings.create') }}"
               class="px-4 py-2 bg-green-700 hover:bg-green-600 text-white rounded-lg shadow">
                ➕ Nowy spis
            </a>
        </div>

        {{-- Komunikat sukcesu --}}
        @if(session('success'))
            <div class="mb-6 p-3 bg-green-800 text-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Data</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Opis</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Utworzony przez</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold">Akcje</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($stocktakings as $s)
                        <tr class="hover:bg-gray-700">
                            <td class="px-4 py-2">{{ $s->id }}</td>
                            <td class="px-4 py-2">{{ $s->date->format('Y-m-d') }}</td>
                            <td class="px-4 py-2">{{ $s->description ?? '-' }}</td>
                            <td class="px-4 py-2 capitalize">{{ $s->status }}</td>
                            <td class="px-4 py-2">{{ $s->creator->name }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('stocktakings.show', $s) }}"
                                   class="px-2 py-1 bg-green-700 hover:bg-green-600 text-white rounded text-sm">
                                    Podgląd
                                </a>
                                <a href="{{ route('stocktakings.generate', $s) }}" target="_blank"
                                   class="px-2 py-1 bg-green-500 hover:bg-green-400 text-white rounded text-sm">
                                    Generuj
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $stocktakings->links() }}
        </div>
    </div>
</x-layout>
