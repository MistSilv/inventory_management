<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Aplikacja Inwentaryzacyjna</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto text-center py-10">
        <h1 class="text-3xl font-bold mb-6">Aplikacja Inwentaryzacyjna</h1>

        <nav class="space-x-4">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Strona główna</a>
            <a href="{{ route('produkty') }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Produkty</a>
            <a href="{{ route('raporty') }}" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">Raporty</a>
            <a href="{{ route('ustawienia') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ustawienia</a>
        </nav>

        <div class="mt-10">
            <p class="text-lg mb-6">Witaj w systemie inwentaryzacji. Kliknij w linki, aby przejść do wybranej sekcji.</p>


            <a href="{{ route('produkty.create') }}" 
               class="inline-block px-6 py-3 bg-indigo-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-indigo-700">
                ➕ Dodaj produkt
            </a>
        </div>
    </div>

</body>
</html>
