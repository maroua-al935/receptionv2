<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="referrer" content="always">

        <title>VisiLog</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
          <style>
            [x-cloak] { display: none !important; }
          </style>

    @livewireStyles
    </head>
    <body>
        <div x-data="{ sidebarOpen: false }" class="app-shell">
            @include('Reception.layouts.sidebar')

            <div class="relative flex flex-1 flex-col overflow-hidden">
                @include('Reception.layouts.header')

                <main class="app-main">
                    <div class="app-container">
                        @yield('body')
                    </div>
                </main>
                <footer class="console-footer">
                    <span><span class="inline-block h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Gateway Ping : <strong>12ms</strong></span>
                    <span>Console : <strong>Reception Central 01</strong></span>
                    <span>VGP alert : <strong>Attentat</strong></span>
                </footer>
            </div>
        </div>
        @livewireScripts
    </body>
</html>
