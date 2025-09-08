<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 flex items-center justify-center min-h-screen px-2">
    <div class="w-full max-w-md bg-slate-900 rounded-lg shadow-lg p-6 sm:p-8 border border-emerald-600/50">
        <h1 class="text-2xl font-bold mb-6 text-center text-slate-100">Rejestracja</h1>
        @if($errors->any())
            <div class="mb-4 bg-emerald-600/15 text-emerald-300 border border-emerald-600/50 rounded p-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5">
            @csrf
            <div>
                <label class="block text-slate-100 mb-1 text-sm" for="name">Imię i nazwisko</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-emerald-600/50 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 placeholder:text-slate-400 text-sm"
                    value="{{ old('name') }}" />
            </div>
            <div>
                <label class="block text-slate-100 mb-1 text-sm" for="email">Email</label>
                <input type="email" name="email" id="email" required
                    class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-emerald-600/50 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 placeholder:text-slate-400 text-sm"
                    value="{{ old('email') }}" />
            </div>
            <div>
                <label class="block text-slate-100 mb-1 text-sm" for="rola">Rola</label>
                <select name="rola" id="rola" required
                    class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-emerald-600/50 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 text-sm">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" @if(old('rola') == $role) selected @endif>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-slate-100 mb-1 text-sm" for="password">Hasło</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-emerald-600/50 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 placeholder:text-slate-400 text-sm" />
            </div>
            <div>
                <label class="block text-slate-100 mb-1 text-sm" for="password_confirmation">Powtórz hasło</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-4 py-2 bg-slate-800 text-slate-100 border border-emerald-600/50 rounded focus:outline-none focus:ring-2 focus:ring-emerald-500/60 placeholder:text-slate-400 text-sm" />
            </div>
            <button type="submit"
                class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 py-2 rounded transition font-semibold text-sm">Zarejestruj</button>
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 text-sm">Masz już konto? Zaloguj się</a>
            </div>
        </form>
    </div>