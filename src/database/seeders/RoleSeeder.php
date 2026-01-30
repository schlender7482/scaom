<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // ========== ROLE: ADMINISTRADOR ==========
        // is_admin = true significa acesso TOTAL
        $admin = Role::updateOrCreate(
            ['name' => 'Administrador'],
            [
                'description' => 'Acesso total ao sistema',
                'is_admin' => true,
                'color' => 'danger', // Vermelho no Bootstrap
            ]
        );
        // Admin não precisa de permissões específicas (is_admin = true)

        // ========== ROLE: SUPERVISOR ==========
        $supervisor = Role::updateOrCreate(
            ['name' => 'Supervisor'],
            [
                'description' => 'Supervisão de equipe e relatórios',
                'is_admin' => false,
                'color' => 'warning', // Amarelo
            ]
        );
        
        // Busca as permissões do supervisor
        $permissoesSupervisor = Permission::whereIn('name', [
            'abordados.visualizar',
            'abordados.criar',
            'abordados.editar',
            'ocorrencias.visualizar',
            'ocorrencias.criar',
            'ocorrencias.editar',
            'maria_penha.visualizar',
            'maria_penha.criar',
            'maria_penha.editar',
            'relatorios.basicos',
            'relatorios.avancados',
        ])->pluck('id')->toArray();
        
        $supervisor->syncPermissions($permissoesSupervisor);

        // ========== ROLE: AGENTE OPERACIONAL ==========
        $agenteOperacional = Role::updateOrCreate(
            ['name' => 'Agente Operacional'],
            [
                'description' => 'Agente de rua - consulta e cadastro',
                'is_admin' => false,
                'color' => 'primary', // Azul
            ]
        );
        
        $permissoesAgente = Permission::whereIn('name', [
            'abordados.visualizar',
            'abordados.criar',
            'abordados.editar',
            'ocorrencias.visualizar',
            'ocorrencias.criar',
        ])->pluck('id')->toArray();
        
        $agenteOperacional->syncPermissions($permissoesAgente);

        // ========== ROLE: AGENTE CONSULTA ==========
        $agenteConsulta = Role::updateOrCreate(
            ['name' => 'Agente Consulta'],
            [
                'description' => 'Apenas visualização de dados',
                'is_admin' => false,
                'color' => 'info', // Ciano
            ]
        );
        
        $permissoesConsulta = Permission::whereIn('name', [
            'abordados.visualizar',
            'ocorrencias.visualizar',
            'relatorios.basicos',
        ])->pluck('id')->toArray();
        
        $agenteConsulta->syncPermissions($permissoesConsulta);
    }
}
