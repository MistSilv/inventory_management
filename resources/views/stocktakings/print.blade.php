<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Spis z natury #{{ $stocktaking->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .center { text-align: center; }
        .right { text-align: right; }
        .title { font-size: 18px; font-weight: bold; text-align: center; margin-bottom: 20px; }
        .signatures { margin-top: 40px; display: flex; justify-content: space-between; }
        .signature-box { width: 45%; text-align: center; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; }
        .ean { font-size: 10px; color: #555; }
    </style>
</head>
<body>

    <div class="title">Spis z natury #{{ $stocktaking->id }}</div>

    <p><strong>Data spisu:</strong> {{ $stocktaking->date->format('Y-m-d') }}</p>
    <p><strong>Opis:</strong> {{ $stocktaking->description ?? '-' }}</p>
    <p><strong>Utworzony przez:</strong> {{ $stocktaking->creator->name }}</p>

    <table>
        <thead>
            <tr>
                <th>Lp.</th>
                <th>Produkt</th>
                <th>EAN</th>
                <th>Jednostka</th>
                <th>Ilość</th>
                <th>Cena jednostkowa (PLN)</th>
                <th>Wartość (PLN)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($stocktaking->items as $index => $item)
                @php $value = $item->quantity * $item->price; $total += $value; @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td class="ean">
                        @foreach($item->product->barcodes as $barcode)
                            {{ $barcode->code }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td class="center">{{ $item->product->unit }}</td>
                    <td class="right">{{ number_format($item->quantity, 3, ',', ' ') }}</td>
                    <td class="right">{{ number_format($item->price, 2, ',', ' ') }}</td>
                    <td class="right">{{ number_format($value, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" class="right"><strong>Łączna wartość:</strong></td>
                <td class="right"><strong>{{ number_format($total, 2, ',', ' ') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <div class="signature-box">
            Osoba sporządzająca spis
            <div class="signature-line"></div>
        </div>
        <div class="signature-box">
            Właściciel / wspólnik
            <div class="signature-line"></div>
        </div>
    </div>

</body>
</html>
