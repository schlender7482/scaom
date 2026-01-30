<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Busca o role de Administrador
        $adminRole = Role::where('name', 'Administrador')->first();

        // Cria o usuário administrador padrão
        User::updateOrCreate(
            ['email' => 'admin@sistema.com'],
            [
                'name' => 'Administrador do Sistema',
                'password' => 'admin123',
                'cpf' => '00000000000',
                'registration' => 'ADMIN001',
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        // Cria um usuário de teste para cada role (opcional)
        $roles = Role::where('is_admin', false)->get();
        
        foreach ($roles as $index => $role) {
            $nomeSlug = strtolower(str_replace(' ', '', $role->name));
            User::updateOrCreate(
                ['email' => $nomeSlug . '@sistema.com'],
                [
                    'name' => 'Usuário ' . $role->name,
                    'password' => 'senha123',
                    'registration' => 'TEST' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'role_id' => $role->id,
                    'is_active' => true,
                ]
            );
        }
    }
}
