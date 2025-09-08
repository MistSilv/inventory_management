<x-layout>
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-slate-100">Lista produktów</h1>
    @if(session('success'))
        <div class="mb-4 bg-emerald-600/15 text-emerald-300 border border-emerald-600/50 rounded p-3">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-slate-900 rounded-lg shadow-lg border border-emerald-600/50 divide-y divide-slate-800">
        @forelse($products as $product)
            <div class="p-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <span class="font-semibold text-slate-100">{{ $product->nazwa }}</span>
                        @if($product->id_abaco)
                            <span class="ml-2 text-xs bg-slate-800 text-slate-400 px-2 py-1 rounded">ID Abaco: {{ $product->id_abaco }}</span>
                        @endif
                    </div>
                    @if($product->eanCodes->count())
                        <div class="mt-2 sm:mt-0">
                            <span class="text-xs text-slate-400">EAN:</span>
                            <span class="text-emerald-400">
                                {{ $product->eanCodes->pluck('kod_ean')->join(', ') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-4 text-slate-400">Brak produktów w bazie.</div>
        @endforelse
    </div>
</div>
</x-layout>