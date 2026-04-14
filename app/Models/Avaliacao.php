<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'projeto_id',
        'avaliador_id',
        'comentario_geral',
        'nota_final',
    ];

    protected function casts(): array
    {
        return [
            'nota_final' => 'decimal:2',
        ];
    }

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }

    public function criterios()
    {
        return $this->hasMany(AvaliacaoCriterio::class, 'avaliacao_id');
    }
}
