<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela Pivot Role-Permission
|--------------------------------------------------------------------------
| Esta é uma TABELA PIVOT (ou tabela de junção/associação).
| 
| O QUE É UMA TABELA PIVOT?
| É uma tabela que conecta duas outras tabelas em um relacionamento
| "muitos para muitos" (Many-to-Many).
|
| No nosso caso:
| - Um Role pode ter MUITAS Permissions
| - Uma Permission pode estar em MUITOS Roles
|
| Exemplo de dados:
| | role_id | permission_id |
| |---------|---------------|
| |    1    |       1       |  → Admin tem permissão "abordados.visualizar"
| |    1    |       2       |  → Admin tem permissão "abordados.criar"
| |    2    |       1       |  → Agente tem permissão "abordados.visualizar"
|
| Note que não tem ID próprio, a chave primária é composta (role_id + permission_id)
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_permission', function (Blueprint $table) {
             // Chave estrangeira para roles
            $table->foreignId('role_id')
                  ->constrained('roles')
                  ->onDelete('cascade'); // Se deletar o role, deleta os vínculos
            
            // Chave estrangeira para permissions
            $table->foreignId('permission_id')
                  ->constrained('permissions')
                  ->onDelete('cascade'); // Se deletar a permission, deleta os vínculos
            
            // Chave primária composta
            // Isso garante que não exista duplicata (mesmo role + mesma permission)
            $table->primary(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
