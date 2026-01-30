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
| Extends Authenticatable: Isso faz o User ter recursos de autenticação
| (login, logout, verificação de senha, etc.)
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ========== RELACIONAMENTOS ==========

    /**
     * Relacionamento: User pertence a um Role
     * 
     * Inverso do hasMany. Permite fazer:
     * $user->role->nome // Retorna "Administrador", por exemplo
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

     // ========== MÉTODOS AUXILIARES ==========
    
    /**
     * Verifica se o usuário pode consultar abordados
     * 
     * Uso: if ($user->cantConsult()) { ... }
     */
    public function cantConsult(): bool
    {
        return $this->role->cant_consult;
    }

    /**
     * Verifica se o usuário pode cadastrar abordados
     */
    public function cantInsert(): bool
    {
        return $this->role->cant_insert;
    }

    /**
     * Verifica se o usuário é administrador
     */
    public function isAdmin(): bool
    {
        return $this->role->cant_manage_users;
    }
}
