<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Login Request
|--------------------------------------------------------------------------
| Esta classe valida e processa a tentativa de login.
|
| SEGURANÇA IMPLEMENTADA:
| 1. Validação de email e senha
| 2. Rate limiting (bloqueia após muitas tentativas)
| 3. Verificação se o usuário está ativo
|
*/

class LoginRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Mensagens de erro customizadas em português.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Informe um email válido.',
            'password.required' => 'A senha é obrigatória.',
        ];
    }

    /**
     * Tenta autenticar o usuário.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // NOVO: Verificar se o usuário existe e está ativo ANTES de tentar o login
        $user = User::where('email', $this->email)->first();

        if (!$user || !$user->is_active) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Sua conta está inativa. Por favor, entre em contato com o administrador.',
            ]);
        }

        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'Credenciais inválidas. Verifique seu email e senha.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Garante que o usuário não está bloqueado por rate limiting.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => 'Muitas tentativas de login. Tente novamente em ' . ceil($seconds / 60) . ' minuto(s).',
        ]);
    }

    /**
     * Chave única para o rate limiter.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
