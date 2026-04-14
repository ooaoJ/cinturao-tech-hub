<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    protected $table = 'etapas';

    protected $fillable = [
        'cidade_id',
        'nome',
        'data_inicio',
        'data_final',
    ];

    protected function casts(): array
    {
        return [
            'data_inicio' => 'date',
            'data_final' => 'date',
        ];
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
}
