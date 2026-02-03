<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- 
        viewport: Essencial para responsividade!
        Diz ao navegador mobile para usar a largura real da tela
    --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Token CSRF: Proteção contra ataques de formulário --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema') }} - @yield('title', 'Acesso')</title>

    {{-- 
        @vite: Carrega os assets compilados
        Em desenvolvimento: carrega do servidor Vite
        Em produção: carrega dos arquivos compilados
    --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    {{-- 
        Container para Toasts (notificações)
        Fica no canto superior direito
    --}}
    <div id="toast-container" class="toast-container position-fixed top-0 end-0 p-3"></div>

    {{-- 
        min-vh-100: Altura mínima de 100% da viewport
        d-flex + align-items-center: Centraliza verticalmente
    --}}
    <main class="min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                {{-- 
                    col-11: Usa 11/12 da largura em mobile (quase tudo)
                    col-sm-8: Em telas pequenas, usa 8/12
                    col-md-6: Em telas médias, usa 6/12 (metade)
                    col-lg-4: Em telas grandes, usa 4/12 (um terço)
                --}}
                <div class="col-11 col-sm-8 col-md-6 col-lg-4">
                    {{-- Logo/Título do Sistema --}}
                    <div class="text-center mb-4">
                        <h1 class="h3 text-primary fw-bold">
                            <i class="bi bi-shield-lock"></i>
                            SCAOM
                        </h1>
                        <p class="text-muted small">Acesso restrito a usuários autorizados</p>
                    </div>

                    {{-- Card com o conteúdo (formulário de login, etc.) --}}
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            {{-- 
                                @yield('content'): Aqui será inserido o conteúdo
                                das páginas que estendem este layout
                            --}}
                            @yield('content')
                        </div>
                    </div>

                    {{-- Rodapé --}}
                    <p class="text-center text-muted small mt-4">
                        &copy; {{ date('Y') }} - Anderson Rafael Schlender
                    </p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>