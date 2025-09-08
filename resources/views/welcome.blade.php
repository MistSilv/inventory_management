<x-layout>

    <div class="mt-10">
        <p class="text-lg mb-6">Kiedyś tutaj będzie jakaś strona główna albo coś w tym stylu.</p>


        <a href="{{ route('produkty.create') }}" 
            class="inline-block px-6 py-3 bg-indigo-600 text-white text-lg font-semibold rounded-lg shadow hover:bg-indigo-700">
            ➕ Dodaj produkt
        </a>
    </div>
    <div class="max-w-2xl mx-auto mt-8">
        <pre class="bg-slate-900 text-slate-100 font-mono text-xs p-4 rounded-lg border border-emerald-600/50 overflow-x-auto">
         / \
        |\_/|
        |---|
        |   |
        |   |
      _ |=-=| _
  _  / \|   |/ \
 / \|   |   |   ||\
|   |   |   |   | \>
|   |   |   |   |   \
| -   -   -   - |)   )
|                   /
 \                 /
  \               /
   \             /
    \           /
        </pre>
    </div>
</x-layout>