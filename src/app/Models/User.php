<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
|--------------------------------------------------------------------------
| Model User
|--------------------------------------------------------------------------
| Representa um usuário do sistema (policial).
|
| VERIFICAÇÃO DE PERMISSÕES:
| As permissões são verificadas através do Role do usuário.
| Usamos métodos como $user->pode('abordados.criar')
|
*/

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'registration',
        'phone',
        'role_id',
        'is_active',
    ];

     /**
     * Campos que são escondidos ao converter para JSON/array.
     * 
     * Isso é segurança: nunca expor a senha, mesmo criptografada.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    // ========== RELACIONAMENTOS ==========

    /**
     * User pertence a um Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relacionamento: User cadastrou muitos Abordados
     * 
     * Permite fazer: $user->abordados_cadastrados
     * Para ver todos que esse policial cadastrou
     */
    public function addressedInserted()
    {
        return $this->hasMany(Addressed::class, 'user_insert_id');
    }

    // ========== MÉTODOS DE PERMISSÃO ==========

    /**
     * Verifica se o usuário tem uma permissão específica
     * 
     * @param string $permission Nome da permissão
     * @return bool
     * 
     * Uso:
     *   if ($user->can('abordados.criar')) { ... }
     *   if ($user->can('ocorrencias.visualizar')) { ... }
     */
    public function canAcess(string $permission): bool
    {
        // Usuário inativo não pode nada
        if (!$this->is_active) {
            return false;
        }

        return $this->role->hasPermission($permission);
    }

    /**
     * Verifica se o usuário tem acesso a um módulo
     * 
     * @param string $modulo Nome do módulo
     * @return bool
     * 
     * Uso: if ($user->canAcessModule('maria_penha')) { ... }
     */
    public function canAcessModule(string $module): bool
    {
        if (!$this->is_active) {
            return false;
        }

        return $this->role->hasAccessModule($module);
    }

    /**
     * Verifica se o usuário é administrador
     */
    public function isAdmin(): bool
    {
        return $this->is_active && $this->role->is_admin;
    }

     /**
     * Retorna array com todas as permissões do usuário
     * Útil para passar para o frontend/JavaScript
     */
    public function allPermissions(): array
    {
        if (!$this->is_active) {
            return [];
        }

        return $this->role->listPermissions();
    }

    // ========== MÉTODOS AUXILIARES ==========
    /**
     * Formata o CPF para exibição
     */
    public function getCpfFormat(): ?string
    {
        if (!$this->cpf) return null;
        
        return substr($this->cpf, 0, 3) . '.' .
               substr($this->cpf, 3, 3) . '.' .
               substr($this->cpf, 6, 3) . '-' .
               substr($this->cpf, 9, 2);
    }
}