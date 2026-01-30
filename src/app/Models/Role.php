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
| RELACIONAMENTOS:
| - hasMany Users → Um role tem muitos usuários
| - belongsToMany Permissions → Um role tem muitas permissões
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
        'is_admin',
        'color'
    ];

    /**
     * $casts converte automaticamente os tipos de dados.
     * 
     * No banco, boolean é armazenado como 0 ou 1.
     * Com cast, o Laravel converte para true/false automaticamente.
     */
    protected $casts = [
        'is_admin' => 'boolean',
    ];

    /**
     * Um Role tem muitos Users
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento Many-to-Many com Permission
     * 
     * belongsToMany indica que um Role pode ter muitas Permissions
     * O segundo parâmetro é o nome da tabela pivot
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    // ========== MÉTODOS DE PERMISSÃO ==========

    /**
     * Verifica se este role tem uma permissão específica
     * 
     * @param string $permission Nome da permissão (ex: "abordados.criar")
     * @return bool
     * 
     * Uso: $role->hasPermission('abordados.criar')
     */
    public function hasPermission(string $permission): bool
    {
        // Admin tem todas as permissões
        if ($this->is_admin) {
            return true;
        }
        // Verifica se a permissão está vinculada a este role
        return $this->permissions()
                    ->where('name', $permission)
                    ->exists();
    }

    /**
     * Verifica se tem qualquer permissão de um módulo
     * 
     * @param string $module Nome do módulo (ex: "abordados")
     * @return bool
     * 
     * Uso: $role->hasAccessModule('abordados')
     */
    public function hasAccessModule(string $module): bool
    {
        if ($this->is_admin) {
            return true;
        }

        return $this->permissions()
                    ->where('module', $module)
                    ->exists();
    }

    /**
     * Retorna lista de nomes das permissões deste role
     * 
     * Útil para passar para o JavaScript ou cache
     */
    public function listPermissions(): array
    {
        if ($this->is_admin) {
            return ['*']; // Asterisco indica "todas"
        }

        return $this->permissions()
                    ->pluck('name')
                    ->toArray();
    }

     /**
     * Sincroniza as permissões do role
     * 
     * @param array $permissionIds Array com IDs das permissões
     * 
     * Uso: $role->syncPermissions([1, 2, 3, 5])
     */
    public function syncPermissions(array $permissionIds): void
    {
        $this->permissions()->sync($permissionIds);
    }
}
