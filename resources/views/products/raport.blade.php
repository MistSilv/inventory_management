<!-- filepath: resources/views/products/raport.blade.php -->
<x-layout>
<div class="max-w-5xl mx-auto bg-slate-900 rounded-lg shadow-lg border border-emerald-600/50 p-6 text-slate-100">
    <div class="mb-6 flex flex-col sm:flex-row sm:justify-between">
        <div class="text-sm text-slate-400 leading-tight">
            <span class="font-semibold text-slate-100">Jarosławdis Sp. z o.o</span><br>
            ul. Wybrzeże Kościuszkowskie 45/79<br>
            00-347 Warszawa<br>
            NIP 5252657059
        </div>
        <div class="text-right mt-4 sm:mt-0 text-slate-400">
            Data sporządzenia: <span class="font-semibold">{{ now()->format('d.m.Y') }}</span><br>
            Arkusz spisu z natury nr 22/2025/SUR
        </div>
    </div>
    <div class="mb-4 text-slate-400">
        <span class="font-semibold text-slate-100">Spis z natury</span> – wersja recenzencka do testu.
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-slate-800 text-sm">
            <thead>
                <tr class="bg-slate-800 text-slate-100">
                    <th class="border border-slate-800 px-2 py-1">Poz.</th>
                    <th class="border border-slate-800 px-2 py-1">Nazwa składnika</th>
                    <th class="border border-slate-800 px-2 py-1">EAN</th>
                    <th class="border border-slate-800 px-2 py-1">Jm</th>
                    <th class="border border-slate-800 px-2 py-1">Ilość</th>
                    <th class="border border-slate-800 px-2 py-1">Cena jedn. (zł)</th>
                    <th class="border border-slate-800 px-2 py-1">Wartość (zł)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @forelse($products as $i => $product)
                    @php
                        $qty = $product->ilość ?? null;
                        $price = $product->cena ?? null;
                        $value = (isset($qty, $price)) ? $qty * $price : null;
                        $total += $value ?? 0;
                    @endphp
                    <tr class="bg-slate-900 hover:bg-slate-800 transition">
                        <td class="border border-slate-800 px-2 py-1 text-center">{{ $i+1 }}</td>
                        <td class="border border-slate-800 px-2 py-1">{{ $product->nazwa ?? 'null' }}</td>
                        <td class="border border-slate-800 px-2 py-1">
                            @if($product->eanCodes && $product->eanCodes->count())
                                {{ $product->eanCodes->pluck('kod_ean')->join(', ') }}
                            @else
                                null
                            @endif
                        </td>
                        <td class="border border-slate-800 px-2 py-1">{{ $product->jm ?? 'null' }}</td>
                        <td class="border border-slate-800 px-2 py-1 text-right">{{ $qty ?? 'null' }}</td>
                        <td class="border border-slate-800 px-2 py-1 text-right">
                            {{ isset($price) ? number_format($price, 2) : 'null' }}
                        </td>
                        <td class="border border-slate-800 px-2 py-1 text-right">
                            {{ isset($value) ? number_format($value, 2) : 'null' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="border border-slate-800 px-2 py-4 text-center text-slate-400">Brak produktów w bazie.</td>
                    </tr>
                @endforelse
                <tr class="bg-slate-800 font-bold">
                    <td colspan="6" class="border border-slate-800 px-2 py-2 text-right">Łączna wartość spisu z natury:</td>
                    <td class="border border-slate-800 px-2 py-2 text-right text-emerald-400">{{ number_format($total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-6 flex flex-col sm:flex-row sm:justify-between text-slate-100">
        <div>
            <div class="mb-2">Spis zakończono na pozycji: <span class="font-semibold">{{ count($products) }}</span></div>
            <div class="mb-2">Podpisy osób sporządzających spis:</div>
            <div class="h-8 border-b border-slate-800 w-64 mb-2"></div>
            <div class="h-8 border-b border-slate-800 w-64 mb-2"></div>
        </div>
        <div>
            <div class="mb-2">Podpis właściciela zakładu (wspólników):</div>
            <div class="h-8 border-b border-slate-800 w-64 mb-2"></div>
        </div>
    </div>
    <div class="mt-6 text-xs text-slate-400">
        Wygenerowano: {{ now()->format('d.m.Y H:i') }}
    </div>
</div>
</x-layout>