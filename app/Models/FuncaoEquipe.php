<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuncaoEquipe extends Model
{
    protected $table = 'funcoes_equipe';

    protected $fillable = [
        'nome',
    ];

    public function equipeUsuarios()
    {
        return $this->hasMany(EquipeUser::class, 'funcao_id');
    }
}
