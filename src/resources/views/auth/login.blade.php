{{-- 
    @extends: Herda o layout guest
    Todo o conteúdo será inserido no @yield('content') do layout
--}}
@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <h5 class="card-title text-center mb-4">Acesso ao Sistema</h5>

    {{-- 
        Exibir mensagem de status (ex: "Link de recuperação enviado")
        O Laravel define isso automaticamente em algumas situações
    --}}
    @if (session('status'))
        <div class="alert alert-success small" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- 
        Formulário de Login
        method="POST": Envia dados de forma segura
        action: URL para onde os dados serão enviados
    --}}
    <form method="POST" action="{{ route('login') }}">
        {{-- 
            @csrf: Gera um token de segurança
            Obrigatório em todos os formulários POST do Laravel
            Protege contra ataques CSRF (Cross-Site Request Forgery)
        --}}
        @csrf

        {{-- Campo Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email') }}"
                required 
                autofocus
                placeholder="seu.email@exemplo.com"
            >
            {{-- 
                @error: Verifica se há erro de validação para este campo
                old('email'): Mantém o valor digitado se houver erro
            --}}
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Campo Senha --}}
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                id="password" 
                name="password" 
                required
                placeholder="••••••••"
            >
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Checkbox Lembrar-me --}}
        <div class="mb-3 form-check">
            <input 
                type="checkbox" 
                class="form-check-input" 
                id="remember" 
                name="remember"
            >
            <label class="form-check-label" for="remember">
                Lembrar-me neste dispositivo
            </label>
        </div>

        {{-- Botão de Submit --}}
        <div class="d-grid gap-2">
            {{-- 
                d-grid: Faz o botão ocupar toda a largura
                Melhor para toque em dispositivos móveis
            --}}
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right me-2"></i>
                Entrar
            </button>
        </div>

        {{-- Link Esqueci Senha --}}
        @if (Route::has('password.request'))
            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-decoration-none small">
                    Esqueceu sua senha?
                </a>
            </div>
        @endif
    </form>
@endsection