<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Migration: Tabela de Abordados
|--------------------------------------------------------------------------
| Esta é a tabela principal do sistema. Armazena todas as pessoas
| abordadas pelos policiais em campo.
|
*/

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addressed', function (Blueprint $table) {
            $table->id();
            
            // Foto da pessoa
            // Armazenamos o CAMINHO do arquivo, não a foto em si
            // Exemplo: "fotos/abordados/2024/foto123.jpg
            $table->string('photo')->nullable();
            $table->string('name')->index();
            $table->char('cpf', 11)->unique()->nullable()->index();
            $table->string('rg', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('mother_name')->nullable()->index();
            $table->string('father_name')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('neighborhood', 100)->nullable();
            $table->string('address', 255)->nullable();
            // ========== GEOLOCALIZAÇÃO DA ABORDAGEM ==========
            
            // Latitude e Longitude do LOCAL DA ABORDAGEM
            // decimal(10,8) = 10 dígitos no total, 8 após a vírgula
            // Isso dá precisão de ~1mm, mais que suficiente
            // Exemplo: -23.55052000 (latitude de São Paulo)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Descrição do local da abordagem
            // Exemplo: "Em frente ao mercado X, esquina com rua Y"
            $table->string('local_approach')->nullable();

            // ========== CARACTERÍSTICAS E OBSERVAÇÕES ==========
            
            // Características físicas
            // text = Texto longo, sem limite prático
            // Exemplo: "Tatuagem de dragão no braço direito, cicatriz na testa"
            $table->text('characteristics')->nullable();
            
            // Observações gerais
            // Exemplo: "Pessoa em situação de rua, frequenta a praça central"
            $table->text('observations')->nullable();
 
            // ========== CONTROLE DO SISTEMA ==========
            
            // Quem cadastrou este abordado
            // Referência para a tabela users
            // onDelete('restrict') = Não deixa deletar usuário se ele tiver cadastros
            $table->foreignId('user_insert_id')
                  ->constrained('users')
                  ->onDelete('restrict');
            
            // Quem fez a última atualização (pode ser diferente de quem cadastrou)
            $table->foreignId('user_update_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('restrict');
            
            // Data/hora da abordagem (quando aconteceu, não quando cadastrou)
            $table->datetime('approach_date')->nullable();
            $table->timestamps();
            // Soft Delete - Em vez de apagar, marca como deletado
            // Isso permite recuperar registros "apagados"
            // deleted_at = Se tiver data, o registro está "deletado"
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addressed');
    }
};
