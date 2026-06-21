<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ showPassword: false }" class="min-h-screen bg-[#f8f7fc] text-slate-900">
    <div class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(127,86,217,0.16),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(50,213,131,0.10),transparent_24%)]"></div>

        <div class="relative grid w-full max-w-6xl overflow-hidden rounded-[32px] border border-white/70 bg-white shadow-[0_30px_80px_rgba(15,23,42,0.10)] lg:grid-cols-[0.85fr_1.15fr]">
            <section class="hidden flex-col justify-between bg-[#181846] p-8 text-white lg:flex">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#7F56D9] text-xl font-black shadow-[0_18px_40px_rgba(127,86,217,0.35)]">V</div>
                        <div>
                            <p class="text-3xl font-black tracking-tight">VisitX</p>
                            <p class="text-xs uppercase tracking-[0.35em] text-violet-200">Reception platform</p>
                        </div>
                    </div>

                    <div class="mt-12 max-w-xs">
                        <p class="text-xs font-bold uppercase tracking-[0.3em] text-violet-200">Connexion securisee</p>
                        <h1 class="mt-4 text-3xl font-bold leading-tight">Accedez a la console visiteurs.</h1>
                        <p class="mt-4 text-sm leading-7 text-slate-300">Authentification simple pour l'accueil, le suivi des visites et la supervision des flux.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-sm font-semibold">Gestion visiteurs</p>
                        <p class="mt-1 text-xs text-slate-300">Enregistrement, historique, suivi des badges.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-sm font-semibold">Acces multi-profils</p>
                        <p class="mt-1 text-xs text-slate-300">Reception, president, services, antennes.</p>
                    </div>
                </div>
            </section>
 
            <section class="bg-white p-8 sm:p-12">
                <div class="mx-auto max-w-lg">
                    <div class="mb-8 text-center lg:text-left">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-100 text-xl font-black text-violet-700 lg:mx-0">V</div>
                        <h2 class="mt-5 text-3xl font-bold tracking-tight text-slate-950">Connexion</h2>
                        <p class="mt-2 text-sm text-slate-500">Saisissez vos identifiants pour ouvrir la session.</p>
                    </div>

                    <form action="{{ route('p_login') }}" method="post" class="space-y-5">
                        @csrf

                        <div>
                            <label for="name" class="mb-2 block text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Nom d'utilisateur</label>
                            <input type="text" name="name" id="name" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-violet-300 focus:bg-white focus:ring-4 focus:ring-violet-100" value="{{ old('name') }}">
                            @error('email')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Mot de passe</label>
                            <div class="relative">
                                <input x-bind:type="showPassword ? 'text' : 'password'" name="password" id="password" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-12 text-sm text-slate-900 outline-none transition focus:border-violet-300 focus:bg-white focus:ring-4 focus:ring-violet-100">
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition hover:text-violet-600" aria-label="Afficher ou masquer le mot de passe">
                                    <svg x-show="!showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7c-4.477 0-8.268-2.943-9.542-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 3l18 18"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.584 10.587A2 2 0 0 0 12 14a2 2 0 0 0 1.414-.586"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.363 5.365A9.466 9.466 0 0 1 12 5c4.478 0 8.268 2.943 9.542 7a9.523 9.523 0 0 1-4.249 5.257"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.228 6.228A9.45 9.45 0 0 0 2.458 12c1.274 4.057 5.065 7 9.542 7a9.47 9.47 0 0 0 5.772-1.772"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="mt-1 block text-sm text-red-500">{{ $message }}</span>
                            @enderror
                            @error('failed')
                                <span class="mt-1 block text-sm font-semibold text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <label for="remember" class="flex items-center gap-3 text-sm text-slate-500">
                            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-slate-300 text-violet-600 focus:ring-violet-200">
                            <span>Se souvenir de moi</span>
                        </label>

                        <button type="submit" class="w-full rounded-2xl bg-[#7F56D9] px-4 py-3 text-sm font-bold text-white shadow-[0_18px_40px_rgba(127,86,217,0.28)] transition hover:bg-[#6941C6]">
                            Se connecter
                        </button>
                    </form>

                    <div class="mt-8 border-t border-slate-100 pt-5 text-center text-xs text-slate-400 lg:text-left">
                        VisiLog {{ config('app.version') }} // ANAM {{ date('Y') }}
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>
