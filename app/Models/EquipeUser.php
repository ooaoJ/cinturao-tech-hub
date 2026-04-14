<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipeUser extends Model
{
    protected $table = 'equipe_user';

    protected $fillable = [
        'equipe_id',
        'user_id',
        'funcao_id',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funcao()
    {
        return $this->belongsTo(FuncaoEquipe::class, 'funcao_id');
    }
}
