<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} | Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <div class="relative flex min-h-screen flex-col overflow-hidden px-4 py-6 sm:px-8">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(79,70,229,0.08)_0%,transparent_65%)]"></div>
        <div class="pointer-events-none absolute right-1/4 top-0 h-80 w-80 rounded-full bg-emerald-500/5 blur-[100px]"></div>

        <header class="relative z-10 mx-auto flex w-full max-w-7xl items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl text-sm font-black text-white shadow-lg" style="background:#2949A6; box-shadow:0 10px 24px rgba(41,73,166,.18)">RC</div>
                <div>
                    <h1 class="text-xs font-black uppercase tracking-widest text-slate-950">Reception Console</h1>
                    <p class="font-mono text-[9px] font-extrabold uppercase tracking-wider" style="color:#2949A6">Secure surete & acces</p>
                </div>
            </div>
            <span class="hidden rounded border border-slate-200 bg-white px-2 py-1 font-mono text-[9px] font-semibold uppercase tracking-wider text-slate-500 shadow-sm sm:inline">Portail multi-roles ANAM</span>
        </header>

        <main class="relative z-10 mx-auto grid w-full max-w-7xl flex-1 grid-cols-1 items-center gap-8 py-8 lg:grid-cols-12">
            <section class="space-y-6 lg:col-span-7">
                <div class="space-y-2">
                    <span class="text-[10px] font-black uppercase tracking-widest" style="color:#2949A6">Acces habilite</span>
                    <h2 class="max-w-2xl text-2xl font-black uppercase tracking-tight text-slate-950 sm:text-3xl">Console d'audit et de reception du site</h2>
                    <p class="max-w-xl text-xs font-medium leading-relaxed text-slate-500">Controle des identites, suivi des visiteurs, pilotage des flux et tracabilite operationnelle depuis un espace unique.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-white p-4 shadow-sm" style="border:1px solid rgba(56,84,166,.18)">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl" style="background:rgba(41,73,166,.08); color:#2949A6">
                                <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5zm0 2.19l7 3.11V11c0 4.52-2.98 8.69-7 9.93C7.98 19.69 5 15.52 5 11V6.3z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-black uppercase tracking-wide text-slate-950">Reception principale</h3>
                                <p class="text-[10px] font-medium text-slate-500">Controle d'identite et attribution de badge.</p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                                <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="currentColor" d="M4 4h16v2H4zm2 4h12v2H6zm-2 4h16v8H4zm2 2v4h12v-4z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-xs font-black uppercase tracking-wide text-slate-950">Registre securise</h3>
                                <p class="text-[10px] font-medium text-slate-500">Historique et statuts en temps reel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="lg:col-span-5">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-200/70">
                    <div class="mb-6 flex items-center gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <div class="flex items-center gap-x-3">
                            <img class="h-14 w-14 object-contain" src="{{url('images/logo_anam.png')}}" alt="logo reception">
                            <div class="h-12 w-px bg-slate-200"></div>
                            <img class="h-14 w-14 object-contain" src="{{url('images/logo.png')}}" alt="logo anam">
                        </div>
                        <div>
                            <p class="text-sm font-black uppercase tracking-widest text-slate-950">VisiLog</p>
                            <p class="font-mono text-[10px] font-bold" style="color:#2949A6">Session securisee</p>
                        </div>
                    </div>

                    <form action="{{ route('p_login') }}" method="post" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="mb-1 block text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Nom d'utilisateur</label>
                            <input type="text" name="name" id="name" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs text-slate-900 outline-none transition" value="">
                            @error('email')
                                <div class="mt-1 text-sm text-red-500">{{$message}}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="mb-1 block text-[9px] font-extrabold uppercase tracking-widest text-slate-500">Mot de passe</label>
                            <input type="password" name="password" id="password" class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-xs text-slate-900 outline-none transition" value="">
                            <div class="mt-3 flex items-center gap-2 text-sm text-slate-500">
                                <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 bg-white" style="color:#2949A6">
                                <label for="remember">Se Souvenir de moi</label>
                            </div>
                            @error('password')
                                <span class="mt-1 block text-sm text-red-500">{{$message}}</span>
                            @enderror
                            @error('failed')
                                <span class="mt-1 block text-sm font-bold text-red-500">{{$message}}</span>
                            @enderror
                        </div>

                        <input type="submit" class="mt-2 w-full rounded-xl px-4 py-3 text-xs font-black uppercase tracking-wide text-white shadow-lg transition" style="background:#2949A6; box-shadow:0 10px 24px rgba(41,73,166,.12)" value="Demarrer la session habilitee">
                    </form>
                </div>
            </section>
        </main>

        <footer class="relative z-10 mx-auto max-w-xl space-y-1 text-center font-mono text-[10px] text-slate-500">
            <p>Systeme certifie Vigipirate - Niveau Alerte "Attentat".</p>
            <span class="block text-slate-500">VisiLog {{config('app.version')}} // ANAM {{ date('Y') }}</span>
        </footer>
    </div>
</body>
</html>
