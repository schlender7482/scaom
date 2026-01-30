<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Adicionar Foreign Keys
|--------------------------------------------------------------------------
| Esta migration roda POR ÚLTIMO para adicionar todas as foreign keys.
| 
| POR QUE SEPARAR?
| Em bancos relacionais, as foreign keys criam dependências entre tabelas.
| Se tentarmos criar uma FK para uma tabela que não existe, dá erro.
| 
| Separando em uma migration final, garantimos que todas as tabelas
| já existem antes de criar os relacionamentos.
|
| Esta é uma prática comum e profissional em projetos Laravel grandes.
|
*/

return new class extends Migration
{
    public function up(): void
    {
        // Foreign Key: users.role_id → roles.id
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('restrict');
        });

        // Foreign Key: abordados.usuario_cadastro_id → users.id
        Schema::table('addressed', function (Blueprint $table) {
            $table->foreign('user_insert_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->foreign('user_update_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        // Remove as foreign keys na ordem inversa
        Schema::table('addressed', function (Blueprint $table) {
            $table->dropForeign(['user_insert_id']);
            $table->dropForeign(['user_update_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
    }
};