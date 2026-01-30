<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/*
|--------------------------------------------------------------------------
| Model Role
|--------------------------------------------------------------------------
| Representa um perfil de acesso no sistema.
| 
| CONCEITO IMPORTANTE - RELACIONAMENTOS:
| Um Role "tem muitos" (hasMany) Users
| É como dizer: "Um cargo pode ter vários funcionários"
|
*/

class Role extends Model
{
    use HasFactory;


    /**
     * $fillable define quais campos podem ser preenchidos em massa.
     * 
     * Isso é uma proteção de segurança do Laravel.
     * Só os campos listados aqui podem ser usados em:
     * Role::create(['nome' => 'Admin', ...])
     */
    protected $fillable = [
        'name',
        'description',
        'cant_consult',
        'cant_insert',
        'cant_manage_users',
    ];

    /**
     * $casts converte automaticamente os tipos de dados.
     * 
     * No banco, boolean é armazenado como 0 ou 1.
     * Com cast, o Laravel converte para true/false automaticamente.
     */
    protected $casts = [
        'cant_consult' => 'boolean',
        'cant_insert' => 'boolean',
        'cant_manage_users' => 'boolean',
    ];

     /**
     * Relacionamento: Um Role tem muitos Users
     * 
     * Isso permite fazer: $role->users para pegar todos 
     * os usuários que têm esse perfil.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
