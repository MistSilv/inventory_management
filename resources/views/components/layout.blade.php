<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Aplikacja Inwentaryzacyjna' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <header class="bg-white shadow p-4">
        <nav class="container mx-auto flex space-x-4">
            <a href="{{ route('home') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Strona główna</a>
            <a href="{{ route('produkty') }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Produkty</a>
            <a href="{{ route('raporty') }}" class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600">Raporty</a>
            <a href="{{ route('ustawienia') }}" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Ustawienia</a>
        </nav>
    </header>

    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

</body>
</html>
