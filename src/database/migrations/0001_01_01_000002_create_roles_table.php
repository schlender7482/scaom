<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela de Roles (Perfis)
|--------------------------------------------------------------------------
| Armazena os perfis de acesso do sistema.
| 
| IMPORTANTE:
| Diferente da versão anterior, os Roles agora NÃO têm campos booleanos
| de permissão. As permissões são vinculadas através da tabela pivot
| "role_permission".
|
| O campo "is_admin" é uma exceção: quando true, o usuário tem acesso
| TOTAL ao sistema, sem precisar verificar permissões individuais.
| Isso evita ter que vincular todas as permissões ao admin.
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            
            // Nome do perfil
            $table->string('name', 50)->unique();
            
            // Descrição do perfil
            $table->string('description')->nullable();
            
            // Se TRUE, este role tem acesso TOTAL ao sistema
            // Ignora todas as verificações de permissão individual
            // Use com cuidado! Normalmente só para "Administrador Master"
            $table->boolean('is_admin')->default(false);
            
            // Cor do badge para exibição na interface (opcional)
            // Exemplos: "primary", "success", "danger", "warning"
            $table->string('color', 20)->default('secondary');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
