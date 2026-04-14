<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teste extends Model
{
    protected $table = 'testes';

    protected $fillable = [
        'projeto_id',
        'descricao',
        'data_teste',
        'resultado',
        'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'data_teste' => 'date',
        ];
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
}
