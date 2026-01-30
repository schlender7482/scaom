<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

/*
|--------------------------------------------------------------------------
| Seeder de Permissões
|--------------------------------------------------------------------------
| Cria todas as permissões do sistema.
|
| COMO ADICIONAR NOVAS PERMISSÕES NO FUTURO:
| 1. Adicione as novas permissões no array $permissoes
| 2. Rode: docker-compose exec php php artisan db:seed --class=PermissionSeeder
| 
| O método updateOrCreate garante que não vai duplicar permissões
| existentes, apenas criar as novas.
|
*/

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissoes = [
            
            // ========== MÓDULO: ABORDADOS ==========
            [
                'module' => 'abordados',
                'name' => 'abordados.visualizar',
                'description' => 'Visualizar registros de abordados',
                'order' => 1,
            ],
            [
                'module' => 'abordados',
                'name' => 'abordados.criar',
                'description' => 'Cadastrar novos abordados',
                'order' => 2,
            ],
            [
                'module' => 'abordados',
                'name' => 'abordados.editar',
                'description' => 'Editar registros de abordados',
                'order' => 3,
            ],
            [
                'module' => 'abordados',
                'name' => 'abordados.excluir',
                'description' => 'Excluir registros de abordados',
                'order' => 4,
            ],

            // ========== MÓDULO: OCORRÊNCIAS (FUTURO) ==========
            [
                'module' => 'ocorrencias',
                'name' => 'ocorrencias.visualizar',
                'description' => 'Visualizar ocorrências',
                'order' => 1,
            ],
            [
                'module' => 'ocorrencias',
                'name' => 'ocorrencias.criar',
                'description' => 'Registrar novas ocorrências',
                'order' => 2,
            ],
            [
                'module' => 'ocorrencias',
                'name' => 'ocorrencias.editar',
                'description' => 'Editar ocorrências',
                'order' => 3,
            ],
            [
                'module' => 'ocorrencias',
                'name' => 'ocorrencias.excluir',
                'description' => 'Excluir ocorrências',
                'order' => 4,
            ],

            // ========== MÓDULO: MARIA DA PENHA (FUTURO) ==========
            [
                'module' => 'maria_penha',
                'name' => 'maria_penha.visualizar',
                'description' => 'Visualizar registros de Maria da Penha',
                'order' => 1,
            ],
            [
                'module' => 'maria_penha',
                'name' => 'maria_penha.criar',
                'description' => 'Cadastrar novos registros de Maria da Penha',
                'order' => 2,
            ],
            [
                'module' => 'maria_penha',
                'name' => 'maria_penha.editar',
                'description' => 'Editar registros de Maria da Penha',
                'order' => 3,
            ],
            [
                'module' => 'maria_penha',
                'name' => 'maria_penha.gerenciar',
                'description' => 'Gerenciamento completo do módulo Maria da Penha',
                'order' => 4,
            ],

            // ========== MÓDULO: HORAS EXTRAS / REFORÇO (FUTURO) ==========
            [
                'module' => 'horas_extras',
                'name' => 'horas_extras.visualizar',
                'description' => 'Visualizar escalas de reforço',
                'order' => 1,
            ],
            [
                'module' => 'horas_extras',
                'name' => 'horas_extras.registrar',
                'description' => 'Registrar horas de reforço operacional',
                'order' => 2,
            ],
            [
                'module' => 'horas_extras',
                'name' => 'horas_extras.aprovar',
                'description' => 'Aprovar horas de reforço',
                'order' => 3,
            ],
            [
                'module' => 'horas_extras',
                'name' => 'horas_extras.gerenciar',
                'description' => 'Gerenciamento completo de horas extras',
                'order' => 4,
            ],

            // ========== MÓDULO: USUÁRIOS ==========
            [
                'module' => 'usuarios',
                'name' => 'usuarios.visualizar',
                'description' => 'Visualizar lista de usuários',
                'order' => 1,
            ],
            [
                'module' => 'usuarios',
                'name' => 'usuarios.criar',
                'description' => 'Cadastrar novos usuários',
                'order' => 2,
            ],
            [
                'module' => 'usuarios',
                'name' => 'usuarios.editar',
                'description' => 'Editar usuários',
                'order' => 3,
            ],
            [
                'module' => 'usuarios',
                'name' => 'usuarios.excluir',
                'description' => 'Desativar/excluir usuários',
                'order' => 4,
            ],

            // ========== MÓDULO: ROLES/PERFIS ==========
            [
                'module' => 'roles',
                'name' => 'roles.visualizar',
                'description' => 'Visualizar perfis de acesso',
                'order' => 1,
            ],
            [
                'module' => 'roles',
                'name' => 'roles.criar',
                'description' => 'Criar novos perfis de acesso',
                'order' => 2,
            ],
            [
                'module' => 'roles',
                'name' => 'roles.editar',
                'description' => 'Editar perfis e permissões',
                'order' => 3,
            ],
            [
                'module' => 'roles',
                'name' => 'roles.excluir',
                'description' => 'Excluir perfis de acesso',
                'order' => 4,
            ],

            // ========== MÓDULO: RELATÓRIOS ==========
            [
                'module' => 'relatorios',
                'name' => 'relatorios.basicos',
                'description' => 'Acessar relatórios básicos',
                'order' => 1,
            ],
            [
                'module' => 'relatorios',
                'name' => 'relatorios.avancados',
                'description' => 'Acessar relatórios avançados e estatísticas',
                'order' => 2,
            ],
            [
                'module' => 'relatorios',
                'name' => 'relatorios.exportar',
                'description' => 'Exportar relatórios (PDF, Excel)',
                'order' => 3,
            ],
        ];

        foreach ($permissoes as $permissao) {
            // updateOrCreate: Atualiza se existir, cria se não existir
            // Primeiro array: campos para buscar
            // Segundo array: campos para criar/atualizar
            Permission::updateOrCreate(
                ['name' => $permissao['name']], // Busca pelo nome
                $permissao // Dados completos
            );
        }
    }
}
