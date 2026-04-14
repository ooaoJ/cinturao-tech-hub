<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    protected $table = 'criterios';

    protected $fillable = [
        'nome',
        'tipo',
        'descricao',
        'peso',
    ];

    public function avaliacaoCriterios()
    {
        return $this->hasMany(AvaliacaoCriterio::class, 'criterio_id');
    }
}
