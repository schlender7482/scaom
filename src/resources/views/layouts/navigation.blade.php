{{--
|--------------------------------------------------------------------------
| Navegação Principal
|--------------------------------------------------------------------------
| Menu responsivo com Bootstrap 5
|
| RESPONSIVIDADE:
| - Mobile: Menu hambúrguer (collapsed)
| - Desktop: Menu horizontal expandido
| - navbar-expand-lg: Expande a partir de 992px
|
--}}

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        
        {{-- Logo/Nome do Sistema --}}
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="bi bi-shield-lock me-2"></i>
            <span class="hide-mobile">Sistema de Abordados</span>
            <span class="hide-desktop">SCAOM</span>
        </a>

        {{-- 
            Botão Hambúrguer (aparece apenas em mobile)
            data-bs-toggle: Ativa o comportamento do Bootstrap
            data-bs-target: ID do elemento que será expandido
        --}}
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarMain"
            aria-controls="navbarMain" 
            aria-expanded="false" 
            aria-label="Abrir menu"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Conteúdo do Menu (collapsável) --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            
            {{-- Menu Principal (Esquerda) --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        <i class="bi bi-house me-1"></i>
                        Dashboard
                    </a>
                </li>

                {{-- 
                    Menu Abordados
                    Só aparece se o usuário tem permissão para visualizar
                --}}
                @if(auth()->user()->canAcessModule('abordados'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('abordados.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="bi bi-people me-1"></i>
                        Abordados
                    </a>
                </li>
                @endif

                {{-- Menu Ocorrências (futuro) --}}
                @if(auth()->user()->canAcessModule('ocorrencias'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ocorrencias.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="bi bi-file-earmark-text me-1"></i>
                        Ocorrências
                    </a>
                </li>
                @endif

                {{-- Menu Maria da Penha (futuro) --}}
                @if(auth()->user()->canAcessModule('maria_penha'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('maria_penha.*') ? 'active' : '' }}" 
                       href="#">
                        <i class="bi bi-heart me-1"></i>
                        Maria da Penha
                    </a>
                </li>
                @endif

                {{-- 
                    Menu Administrativo (Dropdown)
                    Só aparece para administradores ou quem tem permissão
                --}}
                @if(auth()->user()->isAdmin() || auth()->user()->canAcessModule('usuarios') || auth()->user()->canAcessModule('roles'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}" 
                       href="#" 
                       id="adminDropdown" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <i class="bi bi-gear me-1"></i>
                        Administração
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        @if(auth()->user()->canAcess('usuarios.visualizar'))
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-people me-2"></i>
                                Usuários
                            </a>
                        </li>
                        @endif
                        
                        @if(auth()->user()->canAcess('roles.visualizar'))
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person-badge me-2"></i>
                                Perfis de Acesso
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

            </ul>

            {{-- Menu do Usuário (Direita) --}}
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" 
                       href="#" 
                       id="userDropdown" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        {{-- Ícone do usuário --}}
                        <i class="bi bi-person-circle me-1"></i>
                        
                        {{-- Nome (esconde em mobile para economizar espaço) --}}
                        <span class="hide-mobile">{{ Auth::user()->name }}</span>
                        
                        {{-- Badge do perfil (apenas desktop) --}}
                        <span class="badge bg-light text-dark ms-2 hide-mobile">
                            {{ Auth::user()->role->name }}
                        </span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        {{-- Informações do usuário (aparece em mobile) --}}
                        <li class="dropdown-header hide-desktop">
                            <strong>{{ Auth::user()->name }}</strong><br>
                            <small class="text-muted">{{ Auth::user()->role->name }}</small>
                        </li>
                        <li class="hide-desktop"><hr class="dropdown-divider"></li>
                        
                        {{-- Meu Perfil --}}
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person me-2"></i>
                                Meu Perfil
                            </a>
                        </li>
                        
                        {{-- Alterar Senha --}}
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-key me-2"></i>
                                Alterar Senha
                            </a>
                        </li>
                        
                        <li><hr class="dropdown-divider"></li>
                        
                        {{-- Sair --}}
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Sair do Sistema
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            
        </div>
    </div>
</nav>