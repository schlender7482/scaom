<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela de Usuários
|--------------------------------------------------------------------------
| Armazena os usuários do sistema (policiais que vão usar o sistema).
| Cada usuário pertence a um Role (perfil de acesso).
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->char('cpf', 11)->unique()->nullable();
            //Matrícula funcional do policial.
            $table->string('registration', 20)->unique()->nullable();
            $table->string('phone', 15)->nullable();

            // IMPORTANTE: Apenas a coluna, SEM a foreign key constraint
            // A foreign key será adicionada em outra migration
            $table->unsignedBigInteger('role_id')->nullable();

            $table->boolean('is_active')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
