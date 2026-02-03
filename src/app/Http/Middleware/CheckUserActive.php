<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Middleware: Verificar Usuário Ativo
|--------------------------------------------------------------------------
| Este middleware verifica se o usuário logado ainda está ativo.
|
| POR QUE ISSO É IMPORTANTE?
| Se um administrador desativar um usuário enquanto ele está logado,
| esse usuário deve ser deslogado imediatamente por segurança.
|
| COMO FUNCIONA:
| Toda requisição protegida passa por este middleware.
| Se o usuário não estiver ativo, é deslogado e redirecionado.
|
*/

class CheckUserActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Se o usuário está logado mas não está ativo
        if (Auth::check() && !Auth::user()->is_active) {
            // Desloga o usuário
            Auth::logout();
            
            // Invalida a sessão
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            // Redireciona para login com mensagem
            return redirect()
                ->route('login')
                ->with('error', 'Sua conta foi desativada. Entre em contato com o administrador.');
        }

        return $next($request);
    }
}