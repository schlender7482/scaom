<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela de Permissões
|--------------------------------------------------------------------------
| Armazena TODAS as permissões/ações possíveis do sistema.
| 
| ESTRUTURA DE NOMENCLATURA:
| Usamos o padrão "modulo.acao" para organizar as permissões.
| Exemplos:
|   - abordados.visualizar
|   - abordados.criar
|   - abordados.editar
|   - abordados.excluir
|   - ocorrencias.visualizar
|   - maria_penha.gerenciar
|   - usuarios.gerenciar
|
| Isso facilita filtrar permissões por módulo e manter organizado.
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            // Chave primária
            $table->id();
            
            // Módulo a que pertence esta permissão
            // Exemplos: "abordados", "ocorrencias", "maria_penha", "usuarios"
            // Serve para agrupar permissões na interface de gerenciamento
            $table->string('module', 50);
            
            // Nome único da permissão
            // Formato: "modulo.acao"
            // Exemplo: "abordados.criar"
            $table->string('name', 100)->unique();
            
            // Descrição amigável para exibir na interface
            // Exemplo: "Criar novos registros de abordados"
            $table->string('description');
            
            // Ordem de exibição dentro do módulo (para organizar na tela)
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Índice para buscar permissões por módulo rapidamente
            $table->index('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
