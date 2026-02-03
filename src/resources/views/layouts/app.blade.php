<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema') }} - @yield('title', 'Dashboard')</title>

    {{-- CORRIGIDO: Usar SCSS em vez de CSS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- Estilos adicionais específicos de páginas --}}
    @stack('styles')
</head>
<body class="bg-light">
    {{-- Container para Toasts --}}
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>

    {{-- Navegação --}}
    @include('layouts.navigation')

    {{-- Conteúdo Principal --}}
    <main class="py-4">
        <div class="container-fluid px-3 px-md-4">
            {{-- Alertas de sessão (mensagens flash) --}}
            @include('layouts.partials.alerts')
            
            {{-- Conteúdo da página --}}
            @yield('content')
        </div>
    </main>

    {{-- Footer simples (opcional) --}}
    <footer class="py-3 text-center text-muted small">
        <div class="container-fluid">
            &copy; {{ date('Y') }} - Sistema Operacional
        </div>
    </footer>

    {{-- Scripts adicionais específicos de páginas --}}
    @stack('scripts')
</body>
</html>