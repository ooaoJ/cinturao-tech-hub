<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $table = 'equipes';

    protected $fillable = [
        'nome',
        'orientador_id',
        'cidade_id',
        'etapa_id',
    ];

    public function orientador()
    {
        return $this->belongsTo(User::class, 'orientador_id');
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    public function etapa()
    {
        return $this->belongsTo(Etapa::class);
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'equipe_user')
            ->withPivot('funcao_id')
            ->withTimestamps();
    }

    public function equipeUsuarios()
    {
        return $this->hasMany(EquipeUser::class);
    }

    public function projeto()
    {
        return $this->hasOne(Projeto::class);
    }
}
