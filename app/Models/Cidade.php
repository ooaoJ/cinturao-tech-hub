<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    protected $table = 'cidades';

    protected $fillable = [
        'nome',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function etapas()
    {
        return $this->hasMany(Etapa::class);
    }

    public function equipes()
    {
        return $this->hasMany(Equipe::class);
    }
}
