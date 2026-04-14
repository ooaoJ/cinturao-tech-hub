<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvaliacaoCriterio extends Model
{
    protected $table = 'avaliacao_criterio';

    protected $fillable = [
        'avaliacao_id',
        'criterio_id',
        'nota',
        'comentario',
    ];

    protected function casts(): array
    {
        return [
            'nota' => 'decimal:2',
        ];
    }

    public function avaliacao()
    {
        return $this->belongsTo(Avaliacao::class);
    }

    public function criterio()
    {
        return $this->belongsTo(Criterio::class);
    }
}
