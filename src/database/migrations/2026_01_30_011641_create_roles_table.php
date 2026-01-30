<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela de Roles (Perfis de Acesso)
|--------------------------------------------------------------------------
| Esta tabela armazena os diferentes níveis de acesso do sistema.
| Exemplo: Administrador, Agente Consulta, Agente Completo
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
            $table->string('name', 50)->unique();
            $table->string('description', 255)->nullable();
            $table->boolean('cant_consult')->default(false);
            $table->boolean('cant_insert')->default(false);
            $table->boolean('cant_manage_users')->default(false);
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
