<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
|--------------------------------------------------------------------------
| Model Abordado
|--------------------------------------------------------------------------
| Representa uma pessoa abordada.
|
| SOFT DELETES:
| Quando você "deleta" um abordado, ele não é removido do banco.
| Apenas ganha uma data em "deleted_at".
| Isso permite recuperar registros e manter histórico.
|
*/

class Addressed extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nome da tabela no banco.
     * 
     * Por padrão, Laravel usa o plural do nome do Model em inglês.
     * Como "Abordado" não é inglês, definimos explicitamente.
     */
    protected $table = 'addresseds';

     /**
     * Campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'photo',
        'name',
        'cpf',
        'rg',
        'birth_date',
        'mother_name',
        'father_name',
        'city',
        'neighborhood',
        'address',
        'latitude',
        'longitude',
        'local_approach',
        'characteristics',
        'observations',
        'user_insert_id',
        'user_update_id',
        'approach_date',
    ];

    /**
     * Conversão de tipos.
     */
    protected $casts = [
        'birth_date' => 'date',
        'approach_date' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // ========== RELACIONAMENTOS ==========

    /**
     * Quem cadastrou este abordado
     */
    public function userInsert()
    {
        return $this->belongsTo(User::class, 'user_insert_id');
    }

    /**
     * Quem fez a última atualização
     */
    public function userUpdate()
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }

    // ========== MÉTODOS AUXILIARES ==========

    /**
     * Formata o CPF para exibição: 000.000.000-00
     * 
     * Acessor: Permite usar $abordado->cpf_formatado
     */
    public function getCpfFormatAttribute(): ?string
    {
        if (!$this->cpf) return null;
        
        return substr($this->cpf, 0, 3) . '.' .
               substr($this->cpf, 3, 3) . '.' .
               substr($this->cpf, 6, 3) . '-' .
               substr($this->cpf, 9, 2);
    }

    /**
     * Retorna a idade calculada
     */
    public function getAgeAttribute(): ?int
    {
        if (!$this->birth_date) return null;
        
        return $this->birth_date->age;
    }
}
