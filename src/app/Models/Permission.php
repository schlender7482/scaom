<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/*
|--------------------------------------------------------------------------
| Model Permission
|--------------------------------------------------------------------------
| Representa uma permissão/ação do sistema.
|
| RELACIONAMENTO MANY-TO-MANY:
| Uma Permission pode pertencer a muitos Roles.
| Usamos belongsToMany() para esse tipo de relacionamento.
|
*/

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'module',
        'name',
        'description',
        'order',
    ];

    /**
     * Relacionamento Many-to-Many com Role
     * 
     * belongsToMany indica que uma Permission pertence a muitos Roles
     * através da tabela pivot "role_permission"
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission');
    }

    /**
     * Busca permissões agrupadas por módulo
     * 
     * Útil para exibir na tela de gerenciamento de roles
     * Retorna algo como:
     * [
     *   'abordados' => [Permission, Permission, ...],
     *   'ocorrencias' => [Permission, Permission, ...],
     * ]
     */
    public static function groupedByModule()
    {
        return self::orderBy('module')
                   ->orderBy('order')
                   ->get()
                   ->groupBy('module');
    }
}
